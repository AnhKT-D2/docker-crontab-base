<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function lists($request);
    public function store($request, $googleClient);
    public function deleteUser($id, $googleClient);
    public function show($id);
    public function updateUser($request, $id);
}
