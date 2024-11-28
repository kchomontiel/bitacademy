<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::get();

        if (fullAccess()) {
            return view('backend.adminDashboard');
        } elseif ($user->role = 'instructor') {
            return view('backend.instructorDashboard');
        } else {
            return view('backend.dashboard');
        }

        //   $user = User::get();
        //   if($user->role = 'instructor')
        //     return view('backend.instructorDashboard');
    }
}
