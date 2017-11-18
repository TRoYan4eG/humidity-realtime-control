<?php

namespace App\Console\Commands;

use App\Jobs\GetReadings;
use App\Straw;
use Illuminate\Console\Command;

class GetStrawReadings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'straws:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Straw readings';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $straws = Straw::get();
        foreach ($straws as $straw){
            dispatch((new GetReadings($straw))->onQueue('readings'));
        }
    }
}
