<?php

namespace App\Services;

use App\Models\Deposite;
use App\Models\Investment;
use App\Models\ReturnHistory;
use App\Models\Trnx;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class InvestmentReturnService
{
    // number of working days to split monthly into (22 as per your logic)
    protected int $workingDays = 22;

    /**
     * Create return history record for a given investment and date (idempotent).
     * Returns the created ReturnHistory instance or existing one.
     */
    public function createDailyReturnForInvestment(Deposite $inv, string $forDate)
    {
        // if already exists (unique constraint) return it
        $existing = ReturnHistory::where('investment_id', $inv->id)->where('for_date', $forDate)->first();
        if ($existing) {
            return $existing;
        }

        $userss = $inv;
        $datentime = date("Y-m-d") . " " . date("h:i a");
        foreach ($userss as $va) {

            $postdata = array();
            $txn_id = $va->txn_id;
            $url = "https://api.nowpayments.io/v1/payment/" . $txn_id;
            $apiKey = "ZJW3TMT-TTVMXR5-GJZJ3N1-46A5C54";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "x-api-key: $apiKey"
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $resultss = json_decode($response);

            $status_text = $resultss->payment_status;

            $deposite   = deposite::where('txn_id', $txn_id)->first();
            if (count($deposite) > 0 && $deposite->status_1 != 1) {
                if ($status_text == 'finished') {
                    $deposite->status_1     = 1;
                    $deposite->amount1     = $resultss->outcome_amount;
                } elseif ($status_text == 'failed' || $status_text == 'expired') {
                    $deposite->status_1     = 2;
                } else {
                    $deposite->status_1     = 0;
                }
                $deposite->status_text  = $status_text;
                $deposite->save();

                if ($deposite->status_1 == '1') {
                    if ($status_text == 'finished') {
                        $user = User::where('user_id', $deposite->user_id)->first();
                        if ($user != '') {

                            $coin = "USDTTRC20";
                            $user->user_fund_wallet   = $user->user_fund_wallet + $deposite->amount;
                            $user->save();

                            /** trx joining */
                            $hash2      = 'Fund successfully added to your fund wallet' . $deposite->amount;

                            $trnx2 = new Trnx();
                            $trnx2->user_id          = $user->user_id;
                            $trnx2->type             = 'Fund_add';
                            $trnx2->hash             = $hash2;
                            $trnx2->amount           = $deposite->amount;
                            $trnx2->date_time        = $datentime;
                            $trnx2->save();

                            $deposite->pay_status        = 1;
                            $deposite->status        = 1;
                            $deposite->save();

                            // echo "user fund add successfully";
                            Log::info('User fund added successfully', [
                                'user_id' => $user->user_id,
                                'amount' => $deposite->amount,
                            ]);

                            $monthly = $this->calculateMonthlyAmount($inv); // as float
                            $daily = $this->calculateDailyAmount($monthly);

                            return DB::transaction(function () use ($inv, $forDate, $monthly, $daily) {
                                return ReturnHistory::create([
                                    'investment_id'    => $inv->id,
                                    'user_id'          => $inv->user_id,
                                    'principal_snapshot' => $inv->principal,
                                    'monthly_amount'   => $monthly,
                                    'daily_amount'     => $daily,
                                    'for_date'         => $forDate,
                                    'status'           => 'pending',
                                    'processed_at'     => null,
                                ]);
                            });
                        } else {
                            // echo "user not found";
                            Log::info('user not found', [
                                'user_id' => $user->user_id
                            ]);
                        }
                    }
                } else {
                    // echo "transaction not completed yet";
                    Log::info('transaction not completed yet', [
                        'user_id' => $user->user_id
                    ]);
                }
            } else {
                echo "invalid deposite transaction / deposite process already done";
                Log::info('invalid deposite transaction / deposite process already done', [
                    'user_id' => $user->user_id
                ]);
            }
        }
    }

    // Calculate monthly interest
    public function calculateMonthlyAmount(Deposite $inv): float
    {
        // principal * (monthly_rate_percent / 100)
        return (float) bcmul((string)$inv->amount2, bcdiv((string)$inv->monthly_rate_percent, '100', 8), 8);
    }

    // Calculate daily share from monthly
    public function calculateDailyAmount(float $monthlyAmount): float
    {
        if ($this->workingDays == 0) {
            return 0.0;
        }
        // Use bc math for precision, return float rounded to 8 decimals (or 2 if currency)
        $daily = bcdiv((string)$monthlyAmount, (string)$this->workingDays, 8);
        return (float) $daily;
    }
}
