<?php

namespace App\Listeners;

use App\Events\ImportProfilePhotoEvent;
use App\Models\Profile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ImportProfilePhotoListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ImportProfilePhotoEvent  $event
     * @return void
     */
    public function handle(ImportProfileEvent $event)
    {
        $profiles = Profile::whereNull('updated_at')->get();
    }
}
