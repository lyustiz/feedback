<?php

namespace App\Jobs;

use App\Models\UserPresence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PrescenceEstimateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userPresence;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UserPresence $userPresence)
    {
        $this->userPresence = $userPresence
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $userPresences  =  $userPresence->where('status_id', 3)
    }
}
