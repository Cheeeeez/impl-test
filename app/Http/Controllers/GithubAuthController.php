<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller
{
    const SERVICE = "github";

    public function redirectLogin()
    {
        return Socialite::driver(static::SERVICE)->redirect();
    }

    public function handleCallback()
    {
        try {
            $user = Socialite::driver(static::SERVICE)->user();
            // dd($user);
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
            return redirect()
                ->to('/')
                ->with('success', 'Login successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->to('/')
                ->with('error', 'Login via Github failed. Please try again');
        }
    }
}