<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\SimulateAirQualityData::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Run the simulation every 15 minutes
        $schedule->command('air-quality:simulate')->everyFifteenMinutes();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 