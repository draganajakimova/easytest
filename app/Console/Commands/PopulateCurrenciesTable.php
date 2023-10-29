<?php

namespace App\Console\Commands;

use App\Http\Controllers\Currencies\Models\Currency;
use App\Http\Controllers\Fixer\FixerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PopulateCurrenciesTable extends Command
{
    protected $fixerService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies_data:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a one-time-only command which will be used to populate currencies table with data from fixer.io';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FixerService $fixerService)
    {
        parent::__construct();
        $this->fixerService = $fixerService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fixer_response = $this->fixerService->proxy('GET', 'symbols');
        if ($fixer_response['success']) {
            foreach ($fixer_response['symbols'] as $key => $value) {
                Log::info('Saving currency: ' . $key);
                Currency::updateOrCreate([
                    'code' => $key
                ], [
                    'code' => $key,
                    'name' => $value
                ]);
            }
            Log::info('Populating currencies table finished');
        } else {
            Log::info('Populating currencies table did not start due to fixer response issue.');
        }
    }
}
