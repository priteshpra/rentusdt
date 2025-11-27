<?php

use App\Models\Deposite;
use Illuminate\Support\Facades\DB;

function getNonce()
{
    $row = DB::table('coinpayments_nonce')->first();

    $newNonce = $row->nonce + 1;

    DB::table('coinpayments_nonce')->update(['nonce' => $newNonce]);

    return $newNonce;
}
function getTodayDeposit($user_id)
{
    return Deposite::where('user_id', $user_id)
        ->whereDate('apply_date', today())
        ->sum('amount1');
}

function getTotalInvest($user_id)
{
    return Deposite::where('user_id', $user_id)->sum('amount1');
}
