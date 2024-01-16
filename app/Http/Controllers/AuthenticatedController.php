<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticatedController extends Controller
{
    public function login()
    {
        return \view('auth.login');
    }

    public function authenticated(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        if (Auth::attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();
            $url = \url('/');

            return \response()->json(['success' => true, 'data' => $url], 200);
        }

        return \response()->json(['data' => 'Please check your email, password and try again!'], 401);
    }
}
