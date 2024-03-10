<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['logout']);
    }

    public function login(LoginRequest $request)
    {
        dd(auth()->attempt($request->validated(), true));
    }
}
