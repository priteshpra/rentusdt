<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deposite;
use App\Models\ReturnHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon; // if you want date helpers

class ReturnHistoryController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index(Request $request)
    {
        // today's registered users
        $user = auth()->user();
        $perPage = (int) $request->input('per_page', 15);
        $returnHist = ReturnHistory::with('get_user')->where('user_id', $user['id'])->paginate($perPage);
        // dd($returnHist);
        return view('rentus.return', compact(
            'returnHist',
        ));
    }

    public function filterTransactions(Request $request)
    {
        $user = auth()->user();
        $filter = $request->input('filter'); // today, last_week, last_month, this_year
        $perPage = (int) $request->input('per_page', 15);

        $query = ReturnHistory::with('get_user')
            ->where('user_id', $user['id']);

        switch ($filter) {
            case 'today':
                $query->whereDate('return_date', today());
                break;

            case 'last_week':
                $query->whereBetween('return_date', [
                    now()->subWeek()->startOfWeek(),
                    now()->subWeek()->endOfWeek()
                ]);
                break;

            case 'last_month':
                $query->whereMonth('return_date', now()->subMonth()->month);
                break;

            case 'this_year':
                $query->whereYear('return_date', now()->year);
                break;
        }

        $returnHist = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'html'   => view('rentus.return-table', compact('returnHist'))->render()
        ]);
    }
}
