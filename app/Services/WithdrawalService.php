<?php

namespace App\Services;

use App\Models\User;
use App\Models\WalletRequest;
use App\Models\Trnx;
use Illuminate\Support\Facades\Log;

class WithdrawalService
{
    public function processWithdrawal(User $user, float $amount, float $payableAmount, float $adminCommission, string $address)
    {
        // Prepare POST fields for CoinPayments
        $fields = [
            'version'      => 1,
            'key'          => env('public_key'),
            'format'       => 'json',
            'cmd'          => 'create_withdrawal',
            'amount'       => $payableAmount,
            'currency'     => 'USDT',
            'address'      => $address,
            'auto_confirm' => 1
        ];

        // Build Query String
        $post_data = http_build_query($fields, '', '&');

        // Sign the HMAC
        $hmac = hash_hmac('sha512', $post_data, env('private_key'));

        // cURL Request
        $ch = curl_init('https://www.coinpayments.net/api.php');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["HMAC: " . $hmac]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $result = json_decode($response, true);
        if ($result['error'] == 'ok') {

            // create wallet_request
            $wr = new WalletRequest();
            $wr->user_id = $user->user_id;
            $wr->withdraw_type = 'crypto';
            $wr->wallet_type = 'totalwallet';
            $wr->wallet_gateway = 'TRON';
            $wr->wallet_gatway_detail = $address;
            $wr->wallet_amount = $amount;
            $wr->wallet_admin_commision = $adminCommission;
            $wr->payable_amount = $payableAmount;
            $wr->Wallet_requestdate = now()->toDateString();
            $wr->Wallet_transferdate = now()->toDateString();
            $wr->Wallet_status = "P";
            $wr->save();

            // deduct user wallet
            $user->user_wallet = $user->user_wallet - $amount;
            $user->save();

            // trx
            $timestamps = 'AMTDU' . 'WITHDRAW-MAIN' . $user->user_id;
            $hash = $amount . '/- Deduct From Total Wallet For Withdraw request send By Username : ' . $user->user_username;

            $trnx = new Trnx();
            $trnx->user_id   = $user->user_id;
            $trnx->tx_id     = $timestamps;
            $trnx->type      = "withdraw_request";
            $trnx->hash      = $hash;
            $trnx->amount    = $amount;
            $trnx->date_time = now()->format('Y-m-d h:i a');
            $trnx->save();

            // optionally queue coinpayments withdrawal job here

            return $wr;
        }
    }
}
