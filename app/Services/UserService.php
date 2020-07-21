<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserService
{
    const SERVICE = "github";

    public function redirectLoginGithub()
    {
        return Socialite::driver(static::SERVICE)->redirect();
    }

    public function createOrGetUser()
    {
        $user = Socialite::driver(static::SERVICE)->user();
        $userDB = User::query()->where('email', $user->getEmail())->first();

        if (empty($userDB)) {
            $userDB = new User();
            $userDB->name = $user->getNickname();
            $userDB->email = $user->getEmail();
            if (!$userDB->save()) {
                throw new \Exception('Create user failed due to DB Error...');
            }
        }
        Auth::loginUsingId($userDB->id);
    }
}