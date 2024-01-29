<?php

namespace App\Http\Controllers;

use App\Models\UserLog;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    public static function logUserActivity($data)
    {
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
}
