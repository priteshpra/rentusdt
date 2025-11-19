<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deposite;
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
        $user = auth()->user();
        // today's registered users
        $totalUSDT        = Deposite::sum('amount1');
        $transactions = Deposite::with('get_user')->where('user_id', $user['id'])->get();
        return view('rentus.index', compact(
            'totalUSDT',
            'transactions'
        ));
    }
}
