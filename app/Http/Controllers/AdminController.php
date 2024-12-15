<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    //
    public function top_buyer()
    {
        // Refresh the materialized view
        DB::statement('REFRESH MATERIALIZED VIEW top_buyers');

        // Fetch data from the materialized view
        $topBuyers = DB::table('top_buyers')->get();

        // Pass the data to the view
        return view('admin.top_buyer', ['topBuyers' => $topBuyers]);
    }

    public function activity_logs()
    {
        // Fetch all activity logs
        $activityLogs = DB::table('activity_logs')->get();

        // dd($activityLogs);

        // Return the view with the logs
        return view('admin.activity_logs', compact('activityLogs'));
    }
}
