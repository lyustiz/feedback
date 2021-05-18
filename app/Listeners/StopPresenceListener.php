<?php

namespace App\Listeners;

use App\Events\StopPresenceEvent;
use App\Models\UserPresence;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StopPresenceListener implements ShouldQueue
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
     * @param  StopPresenceEvent  $event
     * @return void
     */
    public function handle(StopPresenceEvent $event)
    {
        UserPresence::whereIn('id', $event->userPresences)->update(['comments' => 'quewe']);
    }
}
