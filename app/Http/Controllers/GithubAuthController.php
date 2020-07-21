<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        } catch (\Exception $e) {
            return redirect()
                ->to('/')
                ->with('error', 'Login via Github failed. Please try again');
        }
    }
}