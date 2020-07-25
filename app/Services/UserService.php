<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserService
{
    const SERVICE = "github";
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function redirectLoginGithub()
    {
        return Socialite::driver(static::SERVICE)->scopes(['read:user', 'repo'])->redirect();
    }

    public function createOrGetUser()
    {
        $user = Socialite::driver(static::SERVICE)->user();
        $userDB = $this->userRepository->findByEmail($user->getEmail());
        if (empty($userDB)) {
            $userDB = new User();
            $userDB->name = $user->getNickname();
            $userDB->email = $user->getEmail();
            $userDB->avatar = $user->getAvatar();
            $userDB->token = $user->token;
            if (!$userDB->save()) {
                throw new \Exception('Create user failed due to DB Error...');
            }
        } else {
            $userDB->token = $user->token;
            $this->userRepository->store($userDB);
        }
        Auth::loginUsingId($userDB->id);
    }
}