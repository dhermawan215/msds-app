<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLog;
use Carbon\Carbon;
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
        $data = [];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $data['email'] = $request->email;
        $data['date_time'] = Carbon::now()->toDateTimeString();
        $data['ip_address'] = $request->ip();
        $data['log_user_agent'] = $request->header('user-agent');
        $data['activity'] = 'login to system';

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        if (Auth::attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();
            $url = \url('/');

            $data['status'] = 'true';
            $userLogLogin = self::logUserAuth($data);

            return \response()->json(['success' => true, 'data' => $url], 200);
        }
        // create user log when login fails
        $data['status'] = 'false';
        $userLogIfFails = self::logUserAuth($data);

        return \response()->json(['data' => 'Please check your email, password and try again!'], 401);
    }

    private static function logUserAuth($data)
    {
        $email = $data['email'];
        $user = User::where('email', $email)->first();

        if (is_null($user)) {
            $userId = null;
        } else {
            $userId = $user->id;
        }

        $data['user_id'] = $userId;
        // store to log user data
        $userLogs = UserLog::create([
            'user_id' => $data['user_id'],
            'email' => $data['email'],
            'ip_address' => $data['ip_address'],
            'log_user_agent' => $data['log_user_agent'],
            'activity' => $data['activity'],
            'status' => $data['status'],
            'date_time' => $data['date_time'],
        ]);
    }

    public function logout(Request $request)
    {
        $data = [];
        $data['email'] = Auth::user()->email;
        $data['date_time'] = Carbon::now()->toDateTimeString();
        $data['ip_address'] = $request->ip();
        $data['log_user_agent'] = $request->header('user-agent');
        $data['activity'] = 'logout from system';
        $data['status'] = 'true';
        $data['user_id'] = Auth::user()->id;

        $userLogtoLogout = self::logUserAuth($data);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $url = \url('/login');

        return \response()->json(['success' => \true, 'data' => $url], 200);
    }
}
