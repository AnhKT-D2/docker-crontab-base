<?php

namespace App\Services\Auth;

interface AuthServiceInterface
{
    public function signIn($data);

    public function account();
}
