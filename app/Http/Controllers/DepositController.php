<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Deposite; // your model (note spelling from your code)
use Exception;

class DepositController extends Controller
{
    public function depositInsert(Request $request)
    {

        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Please Login First!'], 401);
        }

        // Strong validation: integer or numeric and >=1
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'min:1'],
            'coin' => ['required', 'in:USDT.TRC20'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        $amount = $request->input('amount');
        $coin = $request->input('coin'); // e.g. 'USDT.TRC20'

        // check first-time or subsequent constraints (your existing logic)
        $existingCompletedCount = Deposite::where('user_id', $user['id'])->where('status_1', 1)->count();
        if ($existingCompletedCount == 0 && $amount < 1) {
            return response()->json(['success' => false, 'message' => 'Amount Must Be $1 For First Time'], 400);
        }

        // Minimum deposit global (ensure get_meta_value returns number)
        if (config('custome.min_deposite') > $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Please Enter Value Greater Than Minimum Deposite Amount!'
            ], 400);
        }

        // Build API request payload
        $orderId = Str::random(8);
        $payload = [
            'price_amount' => $amount,
            'price_currency' => 'USDTTRC20',   // provider expects this format
            'pay_currency'   => 'USDTTRC20',
            'ipn_callback_url' => env('NOWPAYMENTS_IPN'),
            'order_id' => $orderId,
            'order_description' => 'Deposit to your account'
        ];
        $apiKey = env('NOWPAYMENTS_KEY');


        if (!$apiKey) {
            Log::error('NowPayments API key not set');
            return response()->json(['success' => false, 'message' => 'Payment gateway not configured'], 500);
        }

        try {
            // Use Laravel Http client. set timeout and throw on server error optionally.
            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(15)->post('https://api.nowpayments.io/v1/payment', $payload);

            if ($response->failed()) {
                Log::warning('NowPayments API returned non-200', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json(['success' => false, 'message' => 'Payment gateway error', 'details' => $response->json()], 502);
            }

            $result = $response->json();

            if (empty($result['payment_id'])) {
                // gateway responded but no payment id
                return response()->json(['success' => false, 'message' => 'Invalid gateway response', 'data' => $result], 502);
            }

            // expire at — example: 3 minutes from now (you used 180 seconds)
            $expireAt = Carbon::now()->addSeconds(180);
            // dd($user);
            // Save deposit
            $dep = new Deposite();
            $dep->user_id = $user['id'];
            $dep->buyer_email = $user['email'] ?? null;
            $dep->amount1 = $result['price_amount'] ?? $amount;
            $dep->currency1 = $result['price_currency'] ?? $payload['price_currency'];
            $dep->status_1 = 0; // pending
            $dep->order_id = $result['order_id'] ?? $orderId;
            $dep->status_text = $result['payment_status'] ?? null;
            $dep->amount2 = $result['amount_received'] ?? 0;
            $dep->currency2 = $result['pay_currency'] ?? $payload['pay_currency'];
            $dep->expire_at = $expireAt->toDateTimeString();
            $dep->txn_id = $result['payment_id'];
            $dep->address_1 = $result['pay_address'] ?? null;
            $dep->status_url = 'https://api.nowpayments.io/v1/payment/' . ($result['payment_id'] ?? '');
            $dep->gateway = $result['type'] ?? 'nowpayments';
            $dep->amount = $amount;
            $dep->status = 0;
            $dep->apply_date = Carbon::now()->format('Y-m-d h:i a');
            $dep->save();


            $redirUrl = url('/Deposite-status/' . $result['payment_id']);
            // compute remaining seconds
            $remainingSeconds = max(0, strtotime($dep->expire_at) - time());

            $data_query = [
                'user' => $user,
                'deposite' => $dep,
                'remaining_seconds' => $remainingSeconds,
                'redirect_url' => $redirUrl,
            ];
            return view('rentus.thank-you', []);
            // return response()->json(['success' => true, 'data' => $data_query, 'message' => 'this is your URL and data'], 200);
        } catch (Exception $e) {
            Log::error('NowPayments request failed', ['exception' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Payment gateway request failed'], 500);
        }
    }

    /**
     * Webhook endpoint to receive IPN from NowPayments.
     * Be sure to validate signature or ip if provider supports it.
     */
    public function nowPaymentsWebhook(Request $request)
    {
        Log::info('NowPayments webhook received', ['payload' => $request->all()]);
        $payload = $request->all();

        // Example: update deposit by payment_id or order_id
        $paymentId = $payload['payment_id'] ?? null;
        if (!$paymentId) {
            return response()->json(['success' => false, 'message' => 'Missing payment_id'], 400);
        }

        $depo = Deposite::where('txn_id', $paymentId)->first();
        if (!$depo) {
            Log::warning('Deposit not found for payment_id', ['payment_id' => $paymentId]);
            return response()->json(['success' => false, 'message' => 'Deposit not found'], 404);
        }

        // Example mapping. Real keys depend on provider payload
        $status = $payload['payment_status'] ?? null;
        $depo->status_text = $status;
        if (in_array($status, ['finished', 'success', 'confirmed'])) {
            $depo->status_1 = 1; // mark completed
            $depo->status = 1;
            // credit user balance here (do in transaction and idempotently)
        } elseif (in_array($status, ['expired', 'failed', 'cancelled'])) {
            $depo->status_1 = 2; // failed/expired
            $depo->status = 2;
        }
        $depo->amount2 = $payload['amount_received'] ?? $depo->amount2;
        $depo->save();

        return response()->json(['success' => true]);
    }
}
