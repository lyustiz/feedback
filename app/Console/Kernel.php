<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\ScheduleObjects\PresenceEstimate;
use App\ScheduleObjects\ComissionDetail;
use App\ScheduleObjects\ProfileProgressMonth;
use App\ScheduleObjects\ProfileProgressDay;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ModelMakeCommand::class,
        Commands\ControllerMakeCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       // $schedule->call(new PresenceEstimate)->everyMinute();

        $schedule->call(new ComissionDetail)->everyMinute()->name('ComissionDetail')->withoutOverlapping();

        $schedule->call(new ProfileProgressMonth)->everyMinute()->name('ProfileProgressMonth')->withoutOverlapping();

        $schedule->call(new ProfileProgressDay)->everyMinute()->name('ProfileProgressDay')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
