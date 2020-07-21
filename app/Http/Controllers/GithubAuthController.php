<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function redirectLogin()
    {
        return $this->userService->redirectLoginGithub();
    }

    public function handleCallback()
    {
        try {
            $this->userService->createOrGetUser();
            return redirect()
                ->to('/')
                ->with('success', 'Login successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->to('/')
                ->with('error', 'Login via Github failed. Please try again');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}