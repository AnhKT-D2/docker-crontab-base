<?php

namespace App\Repositories\User;

use App\Enums\Constant;
use App\Models\User;
use App\Repositories\RepositoryAbstract;
use Google_Service_Drive;
use Illuminate\Support\Facades\DB;

class UserRepository extends RepositoryAbstract implements UserRepositoryInterface
{
    public function model()
    {
        return User::class;
    }

    public function lists($request)
    {
        $perPage = $request->input('perPage', Constant::PER_PAGE_DEFAULT);
        $users = $this->model;

        try {
            if ($request->has('level') && $request->level > Constant::HAS_ROLES) {
                $users->where('level', '=', $request['level']);
            }

            if ($request->has('userInfo') && $request->userInfo) {
                $users->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->userInfo%")
                        ->orWhere('email', 'like', "%$request->userInfo%")
                        ->orWhere('users.id', '=', $request->userInfo);
                });
            }

            $users = $users->join('avatars', 'users.id', '=', 'avatars.user_id')
                ->where('is_avatar', Constant::USER_AVATAR)
                ->select('users.*', 'avatars.path', 'avatars.is_avatar')->paginate($perPage);
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }

        return [
            'success' => true,
            'users' => $users
        ];
    }

    public function store($request, $googleClient)
    {
        $images = $request->file('files');
        $userData = $request->only(['name', 'email', 'password', 'phone', 'level']);
        $userData['password'] = bcrypt($userData['password']);
        $user = $this->model;

        DB::beginTransaction();
        try {
            $user = $user->create($userData);
            $i = 0;
            foreach ($images as $image) {
                $imageID = $this->getImageID($image, $googleClient);
                if ($i == $request->isAvatar) {
                    $user->avatars()
                        ->create(['path' => $imageID, 'is_avatar' => Constant::USER_AVATAR]);
                } else {
                    $user->avatars()
                        ->create(['path' => $imageID, 'is_avatar' => Constant::USER_BACKGROUND]);
                }

                $i++;
            }
            DB::commit();

            return [
                'success' => true
            ];
        } catch (\Exception $exception) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function deleteUser($id, $googleClient)
    {
        $driveService = new Google_Service_Drive($googleClient);

        DB::beginTransaction();
        try {
            $user = $this->model->findOrFail($id);
            try {
                foreach ($user->avatars as $avatar) {
                    $driveService->files->delete($avatar->path);
                }
            } catch (\Exception $exception) {}
            $user->avatars()->delete();
            $user->delete();
            DB::commit();

            return [
                'success' => true,
            ];
        } catch (\Exception $exception) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function updateUser($request, $id)
    {
        $userData = $request->only(['name', 'email', 'phone', 'level']);
        $user = $this->model;

        DB::beginTransaction();
        try {
            $user = $user->findOrFail($id);
            $user->update($userData);
            DB::commit();

            return [
              'success' => true,
            ];
        } catch (\Exception $exception) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function show($id)
    {
        try {
            $user['user'] = $this->model->findOrFail($id);
            $user['avatars'] = $user['user']->avatars;

            return [
                'success' => true,
                'data' => $user
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    private function getImageID($image, $googleClient)
    {
        $driveService = new Google_Service_Drive($googleClient);
        try {
            $fileMetadata = new \Google_Service_Drive_DriveFile([
                'name' => time() . '.' . $image->getClientOriginalExtension(),
                'parents' => Constant::FOLDER_DEFAULT
            ]);
            $file = $driveService->files->create($fileMetadata, [
                'data' => file_get_contents($image->getRealPath()),
                'uploadType' => 'multipart',
                'fields' => 'id',
            ]);
            return $file->id;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
