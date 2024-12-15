<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        // No middleware needed here
    }

    public function top_buyer()
    {
        // Check if the user is an admin
        if (Auth::check() && Auth::user()->usertype != 'admin') {
            return redirect('/'); // Redirect if not admin
        }

        // Proceed with the function if user is an admin
        DB::statement('REFRESH MATERIALIZED VIEW top_buyers');
        $topBuyers = DB::table('top_buyers')->get();
        return view('admin.top_buyer', ['topBuyers' => $topBuyers]);
    }

    public function activity_logs()
    {
        // Check if the user is an admin
        if (Auth::check() && Auth::user()->usertype != 'admin') {
            return redirect('/'); // Redirect if not admin
        }

        // Fetch all activity logs
        $activityLogs = DB::table('activity_logs')->get();
        return view('admin.activity_logs', compact('activityLogs'));
    }
}
