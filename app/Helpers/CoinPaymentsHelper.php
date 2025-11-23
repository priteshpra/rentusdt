<?php

use Illuminate\Support\Facades\DB;

function getNonce()
{
    $row = DB::table('coinpayments_nonce')->first();

    $newNonce = $row->nonce + 1;

    DB::table('coinpayments_nonce')->update(['nonce' => $newNonce]);

    return $newNonce;
}
