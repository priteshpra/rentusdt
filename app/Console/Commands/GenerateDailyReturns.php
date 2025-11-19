<?php

namespace App\Console\Commands;

use App\Models\Deposite;
use Illuminate\Console\Command;
use App\Models\Investment;
use App\Services\InvestmentReturnService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GenerateDailyReturns extends Command
{
    protected $signature = 'returns:generate {--date=}';
    protected $description = 'Generate daily returns for active investments';

    protected InvestmentReturnService $service;

    public function __construct(InvestmentReturnService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle()
    {
        // Allows overriding date for testing: --date=2025-11-19
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : Carbon::now();
        $forDate = $date->toDateString();

        $this->info("Generating returns for date: {$forDate}");

        // Query active investments that are within start/end date (if set)
        // $forDate = date('Y-m-d');
        // $this->info('forDate ' . $forDate . '');
        $investments = Deposite::where('status_1', 0)->whereDate('created_at', $forDate)->get();

        $this->info('Found ' . $investments->count() . ' active investments');

        $created = 0;
        foreach ($investments as $inv) {
            try {
                $this->service->createDailyReturnForInvestment($inv, $forDate);
                $created++;
            } catch (\Exception $e) {
                // log and continue
                Log::error('Failed to create return for investment ' . $inv->id . ': ' . $e->getMessage());
            }
        }

        $this->info("Done. Created/ensured returns for {$created} investments.");
        return 0;
    }
}
