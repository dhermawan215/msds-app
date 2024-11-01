<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserVerification;
use App\Models\UserForgotPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SendForgotPassword;
use Illuminate\Support\Facades\Validator;
use App\Notifications\SendEmailVerification;
use Illuminate\Support\Facades\Notification;

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

        $userData = User::select('id', 'email', 'is_active')->where('email', $request->email)->first();
        if (!$userData) {
            $data['status'] = 'false';
            $userLogIfFails = self::logUserAuth($data);
            return \response()->json(['data' => 'Please check your email or password'], 401);
        }

        if ($userData->is_active == 0) {
            $data['status'] = 'false';
            $userLogIfFails = self::logUserAuth($data);
            return \response()->json(['data' => 'Please check your email, password or contact administrator!'], 401);
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
    /**
     * request activate account
     */
    public function activateAccount(Request $request)
    {
        //user session
        $user = Auth::user();
        //create token activation
        $tokenString1 = Str::random(12);
        $tokenString2 = Str::random(18);
        $realToken = date('Ymdh') . $tokenString1 . date('is') . $tokenString2 . date('s');

        try {
            //save request data to database
            $query = UserVerification::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'token_verification' => $realToken,
                'token_expired_at' => Carbon::now()->addMinute(30),
            ]);
            //contain the information of verification account
            $content = [
                'user' => $user->name,
                'token' => $query->token_verification,
            ];
            //send notification
            Notification::route('mail', [$user->email => $user->name])->notify(new SendEmailVerification($content));

            return redirect()->route('dashboard')->with('activation', 'Email verification successful to send');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard')->with('activation', 'Error, please try again!');
        }
    }
    /**
     * activation account proccess
     * @param $token
     */
    public function activation($token)
    {
        $query = UserVerification::where('token_verification', $token)->first();

        //check possibility unvalid token
        if (is_null($query)) {
            return view('errors.succes-verification', ['message' => 'we could not find your request.', 'title' => 'Opps!']);
        }
        //check possibility token expired
        if (Carbon::parse($query->token_expired_at) < Carbon::now()) {
            return view('errors.succes-verification', ['message' => 'token expired.', 'title' => 'Opps!']);
        }
        //update account data
        try {
            $queryUser = User::find($query->user_id);

            $proccess = $queryUser->update([
                'email_verified_at' => Carbon::now(),
            ]);
            return view('errors.succes-verification', ['message' => 'Your account was verified.', 'title' => 'Success!']);
        } catch (\Throwable $th) {
            return view('errors.succes-verification', ['message' => 'We could not process your request.', 'title' => 'Error!']);
        }
    }
    /**
     * view forgot password
     */
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }
    /**
     * process request then sending email to user
     */
    public function processForgotPassword(Request $request)
    {
        $email = $request->email;
        $tokenString1 = Str::random(22);
        $tokenString2 = Str::random(28);
        $realToken = date('Ymdh') . $tokenString1 . date('is') . $tokenString2 . date('s');

        try {
            //create the user request forgot password
            $query = UserForgotPassword::create([
                'email' => $email,
                'token_change_password' => $realToken,
                'token_expired_at' => Carbon::now()->addMinute(10),
            ]);
            $content = [
                'user' => $email,
                'token' => $realToken
            ];
            //send notification
            Notification::route('mail', [$email => $email])->notify(new SendForgotPassword($content));
            return redirect()->route('forgot_password')->with('forgot_password', 'we are sending an email to you; Please check your email to process the reset password');
        } catch (\Throwable $th) {
            return redirect()->route('forgot_password')->with('forgot_password', 'Error, please try again!');
            //throw $th;
            dd($th);
        }
    }
    /**
     * change password
     * @param $token
     */
    public function changePassword($token)
    {
        $query = UserForgotPassword::where('token_change_password', $token)->first();

        if (is_null($query)) {
            return view('errors.succes-verification', ['message' => 'we could not find your request.', 'title' => 'Opps!']);
        }
        //check possibility token expired
        if (Carbon::parse($query->token_expired_at) < Carbon::now()) {
            return view('errors.succes-verification', ['message' => 'token expired.', 'title' => 'Opps!']);
        }

        return view('auth.forgot-change-password', ['token' => $query->token_change_password, 'email' => $query->email]);
    }
    /**
     * process change password
     */
    public function processChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'confirm_password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|same:new_password'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        try {
            $query = User::where('email', $request->email)->first();
            $query->update([
                'password' => Hash::make($request->new_password)
            ]);
            return response()->json(['success' => true, 'message' => 'success change password', 'url' => route('login')], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => true, 'message' => 'error, please try again'], 500);
        }
    }
}
