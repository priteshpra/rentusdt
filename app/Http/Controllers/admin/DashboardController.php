<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon; // if you want date helpers

class DashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index()
    {
        // today's registered users
        $todayUsers = User::whereDate('created_at', Carbon::today())->get();
        $activeUsers      = User::where('status', 1)->count();
        $totalUSDT        = ''; //User::sum('total_usdt');
        return view('admin.dashboard', compact(
            'todayUsers',
            'totalUSDT',
            'activeUsers'
        ));
    }
}
