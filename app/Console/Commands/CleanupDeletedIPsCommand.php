<?php

namespace App\Console\Commands;

use App\Models\IntellectualProperty;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Command: Cleanup Soft Deleted IPs
 * Usage: php artisan ip:cleanup {--days=30}
 */
class CleanupDeletedIPsCommand extends Command
{
    protected $signature = 'ip:cleanup
                            {--days=30 : Delete IPs soft-deleted more than this many days ago}
                            {--force : Skip confirmation}';

    protected $description = 'Permanently delete soft-deleted intellectual properties';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $force = $this->option('force');

        $cutoffDate = now()->subDays($days);

        $deletedIPs = IntellectualProperty::onlyTrashed()
            ->where('deleted_at', '<', $cutoffDate)
            ->get();

        if ($deletedIPs->isEmpty()) {
            $this->info('No IPs to cleanup.');
            return Command::SUCCESS;
        }

        $this->warn("Found {$deletedIPs->count()} IP(s) to permanently delete (deleted before {$cutoffDate->format('Y-m-d')})");

        // ต้องใช้ $this->confirm() แทน confirm()
        if (!$force && !$this->confirm('Do you want to proceed?')) {
            $this->info('Cleanup cancelled.');
            return Command::SUCCESS;
        }

        $progressBar = $this->output->createProgressBar($deletedIPs->count());
        $progressBar->start();

        foreach ($deletedIPs as $ip) {
            // Delete associated files
            // ต้องใช้ use Illuminate\Support\Facades\Storage;
            if ($ip->attachments) {
                foreach ($ip->attachments as $attachment) {
                    Storage::disk('public')->delete($attachment['path']);
                }
            }

            $ip->forceDelete();
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info("✓ Cleanup completed! {$deletedIPs->count()} IP(s) permanently deleted.");

        Log::info('IP Cleanup Completed', [
            'count' => $deletedIPs->count(),
            'days' => $days,
        ]);

        return Command::SUCCESS;
    }
}
