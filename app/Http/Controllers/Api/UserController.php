<?php

namespace App\Http\Controllers\Api;

use App\Enums\ErrorType;
use App\Exports\UserExport;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Components\Google_Client;
use Maatwebsite\Excel\Excel;

class UserController extends ApiController
{
    private $userRepository, $client;

    public function __construct(UserRepositoryInterface $userRepository, Google_Client $client)
    {
        $this->userRepository = $userRepository;
        $this->client = $client->getClient();
    }

    public function lists(Request $request)
    {
        $users = $this->userRepository->lists($request);

        if (!$users['success']) {
            return $this->sendError(ErrorType::STATUS_500, ErrorType::STATUS_500);
        }

        return $this->sendSuccess($users['users']);
    }

    public function store(Request $request)
    {
        $user = $this->userRepository->store($request, $this->client);

        if (!$user['success']) {
            return $this->sendError(ErrorType::STATUS_500, ErrorType::STATUS_500);
        }

        return $this->sendSuccess();
    }

    public function destroy($id)
    {
        $user = $this->userRepository->deleteUser($id, $this->client);

        if (!$user['success']) {
            return $this->sendError(ErrorType::STATUS_500, ErrorType::STATUS_500);
        }

        return $this->sendSuccess();
    }

    public function update(Request $request, $id)
    {
        $user = $this->userRepository->updateUser($request, $id);

        if (!$user['success']) {
            return $this->sendError(ErrorType::STATUS_500, ErrorType::STATUS_500);
        }

        return $this->sendSuccess();
    }

    public function show($id)
    {
        $user = $this->userRepository->show($id);

        if (!$user['success']) {
            return $this->sendError(ErrorType::STATUS_500, ErrorType::STATUS_500);
        }

        return $this->sendSuccess($user['data']);
    }

    public function exportExcel()
    {
        return Excel::download(new UserExport(), "asd.csv");
    }
}
