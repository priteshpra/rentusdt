<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deposite;
use App\Models\User;
use App\Models\ReturnHistory;
use Illuminate\Http\Request;
use Carbon\Carbon; // if you want date helpers

class DashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index()
    {
        $today = date('Y-m-d');
        $user = auth()->user();
        // today's registered users
        $totalUSDT  = $totalInvest = Deposite::where('user_id', $user['id'])->sum('amount1');
        $transactions = Deposite::with('get_user')->where('user_id', $user['id'])->orderBy('id', 'desc')->limit(5)->get();
        $todays = Deposite::where('user_id', $user['id'])->whereDate('apply_date', $today)->sum('amount1');
        $totalReturn = ReturnHistory::where('user_id', $user['id'])->sum('monthly_return');
        $todaysReturn = ReturnHistory::where('user_id', $user['id'])->whereDate('processed_at', $today)->sum('daily_return');
        return view('rentus.index', compact(
            'totalUSDT',
            'transactions',
            'totalInvest',
            'user',
            'todays',
            'totalReturn',
            'todaysReturn'
        ));
    }
}
