<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;

class ShowAuthViewsController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    public function forgotPassword()
    {
        return Inertia::render('Auth/Password/ForgotPassword');
    }

    public function resetPassword()
    {
        return Inertia::render('Auth/Password/ResetPassword');
    }
}
