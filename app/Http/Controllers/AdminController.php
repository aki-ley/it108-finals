<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\User;

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

    
    public function show_users()
    {
        if (Auth::check() && Auth::user()->usertype != 'admin') {
            return redirect('/'); // Redirect if not admin
        }

        $users = DB::table('users')->get();

        

        return view ('admin.show_users', compact('users'));
    }

    public function remove_user($user_id)
    {
        // Check if the user is authenticated and is an admin
        if (Auth::check() && Auth::user()->usertype != 'admin') {
            return redirect('/'); // Redirect if not admin
        }

        // Get the ID of the user performing the deletion
        $updatedById = auth()->id(); 

        // Fetch the user to be deleted
        $user = DB::table('users')->where('user_id', $user_id)->first();

        $user->updated_by = $updatedById;
        $updatedByRole = User::where('user_id', $updatedById)->value('usertype');

        // Check if the user exists before attempting to delete
        if ($user) {
            // Delete the user
            DB::table('users')->where('user_id', $user_id)->delete();

            // Log the deletion in the activity_logs table
            DB::table('activity_logs')->insert([
                'usertype' => $updatedByRole,
                'action_performed' => 'DELETE',
                'table_name' => 'users',
                'column_data' => 'usertype',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('message', 'User  deleted successfully!');
        }

        return redirect()->back()->with('error', 'User  not found!');
    }

    public function edit_role(Request $request, $user_id)
    {
        // Validate the incoming request
        $request->validate([
            'usertype' => 'required|string|in:admin,seller,user', // Adjust roles as necessary
        ]);

        // Find the user by ID
        $user = User::findOrFail($user_id);

        // Set the ID of the currently authenticated user
        $updatedById = auth()->id();

        // Update the user's role
        $user->updated_by = $updatedById; // Set to the ID of the currently authenticated user
        $user->usertype = $request->input('usertype');
        $user->save();

        // Retrieve the usertype of the user who performed the action
        $updatedByRole = User::where('user_id', $updatedById)->value('usertype');

        // Log the activity
        \DB::table('activity_logs')->insert([
            'usertype' => $updatedByRole,
            'action_performed' => 'UPDATE',
            'table_name' => 'users',
            'column_data' => 'usertype',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('message', 'User  role updated successfully.');
    }

}
