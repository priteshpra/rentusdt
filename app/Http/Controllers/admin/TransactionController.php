<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposite;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon; // if you want date helpers

class TransactionController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index(Request $request)
    {
        // today's registered users
        $perPage = (int) $request->input('per_page', 15);
        $transactions = Deposite::with('get_user')->paginate($perPage);
        // dd($transactions);
        return view('admin.payment', compact(
            'transactions',
        ));
    }

    public function filterTransactions(Request $request)
    {
        $user = auth()->user();
        $filter = $request->input('filter'); // today, last_week, last_month, this_year
        $perPage = (int) $request->input('per_page', 15);

        $query = Deposite::with('get_user');
        // ->where('user_id', $user['id']);

        switch ($filter) {
            case 'today':
                $query->whereDate('apply_date', today());
                break;

            case 'last_week':
                $query->whereBetween('apply_date', [
                    now()->subWeek()->startOfWeek(),
                    now()->subWeek()->endOfWeek()
                ]);
                break;

            case 'last_month':
                $query->whereMonth('apply_date', now()->subMonth()->month);
                break;

            case 'this_year':
                $query->whereYear('apply_date', now()->year);
                break;
        }

        $transactions = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'html'   => view('admin.transaction-table', compact('transactions'))->render()
        ]);
    }
}
