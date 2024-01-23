<?php

namespace App\Console\Commands;

use App\Services\CurrencyUpdate\CurrencyUpdateInterface;
use Illuminate\Console\Command;

class UpdateRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * Execute the console command.
     */
    public function handle(CurrencyUpdateInterface $updater)
    {
        $updater->updateRates();
    }
}
