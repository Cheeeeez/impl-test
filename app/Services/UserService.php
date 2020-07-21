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
        return Socialite::driver(static::SERVICE)->redirect();
    }

    public function createOrGetUser()
    {
        $user = Socialite::driver(static::SERVICE)->user();
        $userDB = $this->userRepository->findByEmail($user->getEmail());
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