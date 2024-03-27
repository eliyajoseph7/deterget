<?php

namespace App\Console\Commands\Reports;

use App\Http\Controllers\Reports\RemainSaleController;
use Illuminate\Console\Command;

class RemainSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sale:remain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect remained products from sale';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new RemainSaleController)->remain();
        $this->info('Remain products collected successfully!');
    }
}
