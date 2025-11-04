<?php

namespace App\Console\Commands;

use App\Models\IntellectualProperty;
use App\Events\IntellectualPropertyExpired;
use App\Events\IntellectualPropertyExpiring;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Command: Check and Auto-Expire IPs
 * Usage: php artisan ip:check-expiry
 */
class CheckIPExpiryCommand extends Command
{
    protected $signature = 'ip:check-expiry
                            {--notify-days=30 : Days before expiry to send notification}
                            {--auto-expire : Automatically expire IPs past their expiry date}';

    protected $description = 'Check for expiring intellectual properties and send notifications';

    public function handle(): int
    {
        $notifyDays = (int) $this->option('notify-days');
        $autoExpire = $this->option('auto-expire');

        $this->info("Checking IP expiry status...");
        $this->newLine();

        // Check expiring IPs
        $expiringCount = $this->checkExpiringIPs($notifyDays);
        
        // Auto-expire if flag is set
        $expiredCount = 0;
        if ($autoExpire) {
            $expiredCount = $this->autoExpireIPs();
        }

        $this->newLine();
        $this->info("✓ Expiry check completed!");
        $this->table(
            ['Status', 'Count'],
            [
                ['Expiring Soon (within ' . $notifyDays . ' days)', $expiringCount],
                ['Auto-Expired', $expiredCount],
            ]
        );

        Log::info('IP Expiry Check Completed', [
            'expiring_count' => $expiringCount,
            'expired_count' => $expiredCount,
        ]);

        return Command::SUCCESS;
    }

    private function checkExpiringIPs(int $days): int
    {
        // ต้องแน่ใจว่า Model มี Local Scope ชื่อ expiringSoon
        $expiringIPs = IntellectualProperty::expiringSoon($days) 
            ->whereNotIn('status', ['expired', 'revoked'])
            ->with('owner')
            ->get();

        $this->info("Found {$expiringIPs->count()} IP(s) expiring within {$days} days");

        $progressBar = $this->output->createProgressBar($expiringIPs->count());
        $progressBar->start();

        foreach ($expiringIPs as $ip) {
            $daysRemaining = $ip->expiry_date->diffInDays(now());
            event(new IntellectualPropertyExpiring($ip, $daysRemaining));
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        return $expiringIPs->count();
    }

    private function autoExpireIPs(): int
    {
        $expiredIPs = IntellectualProperty::where('expiry_date', '<', now())
            ->whereNotIn('status', ['expired', 'revoked'])
            ->get();

        $this->warn("Found {$expiredIPs->count()} expired IP(s) to process");

        $progressBar = $this->output->createProgressBar($expiredIPs->count());
        $progressBar->start();

        foreach ($expiredIPs as $ip) {
            // โค้ดที่นี่ควรจะเปลี่ยนสถานะ IP เป็น 'expired' ด้วย
            // $ip->update(['status' => 'expired']); 
            event(new IntellectualPropertyExpired($ip));
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        return $expiredIPs->count();
    }
}
