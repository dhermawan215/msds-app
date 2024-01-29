<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UserLogController;
use App\Models\UserLog;

class UserSettingController extends Controller
{
    private $dateTime;
    private $ip;
    private $userAgent;

    public function __construct()
    {
        $this->dateTime = Carbon::now()->toDateTimeString();
        $this->ip = \request()->ip();
        $this->userAgent = \request()->header('user-agent');
    }

    public function profile()
    {
        return \view('user.profile');
    }

    public function update(Request $request)
    {
        $auth = Auth::user()->id;

        $userData = User::findOrFail($auth);

        $userData->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        return \response()->json(['success' => \true], 200);
    }

    public function passwordUpdate(Request $request)
    {
        // \dd($request);
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|same:confirm_password',
            'confirm_password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        //has check old password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return \response()->json(['success' => false, 'data' => 'old password does not match'], 403);
        }

        $passwordUpdate = User::where('id', Auth::user()->id);
        $passwordUpdate->update([
            'password' => Hash::make($request->new_password)
        ]);

        $data = [];
        $data['user_id'] = Auth::user()->id;
        $data['email'] = Auth::user()->email;
        $data['ip_address'] = $this->ip;
        $data['date_time'] = $this->dateTime;
        $data['log_user_agent'] = $this->userAgent;
        $data['activity'] = 'change password';
        $data['status'] = 'true';

        $log = UserLogController::logUserActivity($data);

        return \response()->json(['success' => true, 'data' => 'change password success']);
    }

    public function userLog(Request $request)
    {
        $userId = Auth::user()->id;

        $log = UserLog::select('user_id', 'name', 'user_logs.email', 'date_time', 'activity', 'status')
            ->join('users', 'user_logs.user_id', '=', 'users.id')
            ->where('user_logs.user_id', $userId)->limit(10)->orderBy('user_logs.date_time', 'DESC')->get();

        return \response()->json(['success' => true, 'content' => $log], 200);
    }
}
