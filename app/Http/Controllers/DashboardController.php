<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SysUserGroup;
use Illuminate\Http\Request;
use App\Models\SampleRequest;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function index(Request $request)
    {

        $date = Carbon::now();
        $dateView = $date->toFormattedDateString();
        //user information
        $user = Auth::user();
        $userGroup = $this->getUserGroup($user->sys_group_id);
        $alert = null;
        /**
         * check if email verified null and user was requested but the time is over than 15 minutes
         * so, show the alert resend
         * if the user firtsly request, show the alert send email verification
         * */
        $userRequestVerified = $this->userRepo->getHowManyVerified($user->email);

        if (is_null($user->email_verified_at) && is_null($userRequestVerified)) {
            //show alert first time to user how to activate their email
            $alert = 'first-time';
        }

        if (is_null($user->email_verified_at) && isset($userRequestVerified)) {
            if (Carbon::parse($userRequestVerified->token_expired_at) < Carbon::now()) {
                $alert = 'reminder-activated';
            } else {
                $alert = 'email-succesfully-sent';
            }
        }
        return view('dashboard', [
            'date' => $dateView,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'email_verified' => is_null($user->email_verified_at) ? 'Not Verified' : 'Verified',
            'ip' => $request->ip(),
            'user_group' => $userGroup->name,
            'alert' => $alert,
        ]);
    }

    private function getUserGroup($id)
    {
        return SysUserGroup::find($id);
    }
    /**
     * statistic for sample request line chart in dashboard
     */
    public function statisticSampleRequest()
    {
        $sampleRequests = SampleRequest::select(
            DB::raw('YEAR(request_date) as year'),
            DB::raw('MONTH(request_date) as month'),
            DB::raw('COUNT(*) as total_requests')
        )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Format data for Chart.js
        $formattedData = [
            'labels' => [],
            'data' => []
        ];

        foreach ($sampleRequests as $request) {
            $formattedData['labels'][] = $request->year . '-' . str_pad($request->month, 2, '0', STR_PAD_LEFT);
            $formattedData['data'][] = $request->total_requests;
        }

        return response()->json($formattedData);
    }
}
