<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('analyse:words 4')
            ->withoutOverlapping(2880)
            ->runInBackground()
            ->everyFifteenMinutes();
        $schedule->command('analyse:words 5')
            ->withoutOverlapping(2880)
            ->runInBackground()
            ->everyFifteenMinutes();
        $schedule->command('domain:available')
            ->withoutOverlapping(2880)
            ->runInBackground()
            ->everyFifteenMinutes();
        $schedule->command('rule:apply')
            ->withoutOverlapping(2880)
            ->runInBackground()
            ->everyFifteenMinutes();
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
