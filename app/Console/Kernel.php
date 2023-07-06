<?php

namespace App\Console;

use App\Console\Commands\CustomCommand;
use App\Console\Commands\MergeCurrentBranchWithAnother;
use App\Console\Commands\PushToCurrentBranch;
use App\Console\Commands\PushToCurrentBranchAndMerge;
use App\Console\Commands\SendNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendMail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CustomCommand::class,
        SendNotification::class,
        PushToCurrentBranch::class,
        PushToCurrentBranchAndMerge::class,
        MergeCurrentBranchWithAnother::class,
        SendMail::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:rides')
                 ->everyMinute();

              $schedule->command('send:mail')
                ->daily(); 
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
