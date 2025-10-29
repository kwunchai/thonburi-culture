<?php

// ============================================
// Kernel.php - Register Commands
// ============================================


namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     */
    protected $commands = [
        \App\Console\Commands\CheckIPExpiryCommand::class,
        \App\Console\Commands\GenerateIPReportCommand::class,
        \App\Console\Commands\CleanupDeletedIPsCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Check IP expiry daily at 9:00 AM
        $schedule->command('ip:check-expiry --auto-expire')
            ->dailyAt('09:00')
            ->emailOutputOnFailure(config('ip.notification.admin_email'));

        // Generate weekly report every Monday at 8:00 AM
        $schedule->command('ip:report --export=json')
            ->weeklyOn(1, '08:00');

        // Cleanup soft-deleted IPs monthly
        $schedule->command('ip:cleanup --days=90 --force')
            ->monthlyOn(1, '00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}