<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\User;
use App\Models\WalletRequest;
use App\Models\Trnx; // your transaction model
use App\Services\WithdrawalService; // optional
use Symfony\Component\HttpFoundation\Response;

class WalletController extends Controller
{
    protected $withdrawalService;

    public function __construct(WithdrawalService $withdrawalService = null)
    {
        $this->withdrawalService = $withdrawalService;
    }

    public function withdrawRequest(Request $request)
    {
        // Prefer JSON for AJAX
        $isAjax = $request->expectsJson() || $request->ajax();

        $user = auth()->user();
        if (!$user) {
            $msg = 'Please login first.';
            return $isAjax
                ? response()->json(['status' => 'error', 'message' => $msg], Response::HTTP_UNAUTHORIZED)
                : redirect()->back()->with('alert-danger', $msg);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'withdraw_type' => 'required|in:crypto',
            'wallet'        => 'required|string',
            'amount'        => 'required|numeric',
        ]);

        if ($validator->fails()) {
            if ($isAjax) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check transaction password / otp
        if (!hash_equals((string)$user->trnx_pass, (string)$request->input('otp'))) {
            $msg = 'Incorrect Transaction Password!';
            return $isAjax
                ? response()->json(['status' => 'error', 'message' => $msg], Response::HTTP_FORBIDDEN)
                : redirect()->back()->with('alert-danger', $msg);
        }

        // min / max checks
        $minWithdraw = 20;
        $amount = (float)$request->input('amount');
        if ($amount < $minWithdraw) {
            $msg = "Minimum Withdraw Amount is {$minWithdraw}";
            return $isAjax
                ? response()->json(['status' => 'error', 'message' => $msg], Response::HTTP_UNPROCESSABLE_ENTITY)
                : redirect()->back()->with('alert-danger', $msg)->withInput();
        }

        $maxWithdraw = (float) config('custome.max_withdraw') ?? 0;
        if ($maxWithdraw > 0 && $amount > $maxWithdraw) {
            $msg = "Maximum Withdraw Amount is {$maxWithdraw}";
            return $isAjax
                ? response()->json(['status' => 'error', 'message' => $msg], Response::HTTP_UNPROCESSABLE_ENTITY)
                : redirect()->back()->with('alert-danger', $msg)->withInput();
        }

        // check previous pending withdraw for same wallet
        $pendingCount = WalletRequest::where('user_id', $user->user_id)
            ->where('wallet_type', $request->input('wallet'))
            ->where('wallet_status', 'P')
            ->count();
        if ($pendingCount > 0) {
            $msg = 'Please wait till your previous withdrawal clears.';
            return $isAjax
                ? response()->json(['status' => 'error', 'message' => $msg], Response::HTTP_CONFLICT)
                : redirect()->back()->with('alert-danger', $msg)->withInput();
        }

        // only support 'totalwallet' as in your logic
        if ($request->input('wallet') !== 'totalwallet') {
            $msg = 'Unsupported wallet type.';
            return $isAjax
                ? response()->json(['status' => 'error', 'message' => $msg], Response::HTTP_BAD_REQUEST)
                : redirect()->back()->with('alert-danger', $msg);
        }

        // Check balance
        if ($user->user_fund_wallet < $amount) {
            $msg = 'You have insufficient balance.';
            return $isAjax
                ? response()->json(['status' => 'error', 'message' => $msg], Response::HTTP_PAYMENT_REQUIRED)
                : redirect()->back()->with('alert-danger', $msg);
        }

        // All checks passed — perform withdrawal in transaction
        try {
            DB::beginTransaction();

            // Calculate commission + payable
            $adminPercent = (float) config('custome.admin_charge') ?? 0;
            $adminCommission = round($amount * $adminPercent / 100, 8);
            $payableAmount = round($amount - $adminCommission, 8);
            $currency = 'USDT';
            $address = $user->trx_address;

            // If you have a WithdrawalService, use it (recommended)
            // if ($this->withdrawalService) {
            //     $result = $this->withdrawalService->processWithdrawal($user, $amount, $payableAmount, $adminCommission, $address);
            // } else {
            // Inline process (similar to your logic)
            $nonce = getNonce();

            $fields = [
                'version'      => 1,
                'key'          => env('public_key'),
                'format'       => 'json',
                'cmd'          => 'create_withdrawal',
                'amount'       => $payableAmount,
                'currency'     => $currency,
                'address'      => $address,
                'auto_confirm' => 1,
                'nonce'        => $nonce
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
            dd($result);
            if ($result['error'] == 'ok') {

                // create wallet_request
                $wr = new WalletRequest();
                $wr->user_id = $user->user_id;
                $wr->withdraw_type = $request->input('withdraw_type');
                $wr->wallet_type = $request->input('wallet');
                $wr->wallet_gateway = 'TRON';
                $wr->wallet_gatway_detail = $address;
                $wr->wallet_amount = $amount;
                $wr->wallet_admin_commision = $adminCommission;
                $wr->payable_amount = $payableAmount;
                $wr->wallet_requestdate = now()->toDateString();
                $wr->wallet_transferdate = now()->toDateString();
                // you used "A" in original on success of coinpayments — to start use "P" or "A" as you desire
                $wr->wallet_status = "P"; // Pending until confirmed by coinpayments
                $wr->save();

                // deduct user wallet
                $user->user_wallet = $user->user_wallet - $amount;
                $user->save();

                // create transaction record
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
            } else {
                $result = ['error' => 'not_executed']; // placeholder
            }

            DB::commit();

            $msg = 'Withdraw request submitted successfully.';

            return $isAjax
                ? response()->json([
                    'status' => 'success',
                    'message' => $msg,
                    'balance' => number_format($user->user_wallet, 8),
                    'wallet_request_id' => $wr->id ?? null
                ], Response::HTTP_OK)
                : redirect()->back()->with('alert-success', $msg);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Withdraw request error: ' . $e->getMessage());
            $msg = 'Something went wrong. Try again later.';
            return $isAjax
                ? response()->json(['status' => 'error', 'message' => $msg], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('alert-danger', $msg);
        }
    }
}
