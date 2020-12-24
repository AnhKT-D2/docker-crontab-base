<?php

namespace App\Http\Controllers\Api;

use Laravel\Socialite\Facades\Socialite;

class SocialController extends ApiController
{
    public function googleUrl()
    {
        return $this->sendSuccess([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl()
        ]);
    }

    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        dd($googleUser);
    }
}
