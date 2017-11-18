<?php

namespace App\Jobs;

use App\Straw;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetReadings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $straw;

    /**
     * GetReadings constructor.
     * @param Straw $straw
     *
     */
    public function __construct(Straw $straw)
    {
        $this->straw = $straw;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->straw->sensors){
            $this->straw->getSensorsReadings();
        }
    }
}
