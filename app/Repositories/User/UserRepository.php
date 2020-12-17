<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\RepositoryAbstract;

class UserRepository extends RepositoryAbstract implements UserRepositoryInterface
{
    public function model()
    {
        return User::class;
    }

    public function getAll()
    {
        return parent::paginate(15);
    }
}
