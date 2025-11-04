<?php

namespace App\Console\Commands;

use App\Models\IntellectualProperty;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

/**
 * Command: Generate IP Statistics Report
 * Usage: php artisan ip:report {--user=} {--export=}
 */
class GenerateIPReportCommand extends Command
{
    protected $signature = 'ip:report
                            {--user= : Generate report for specific user ID}
                            {--export= : Export format (json|csv)}
                            {--output= : Output file path}';

    protected $description = 'Generate intellectual property statistics report';

    public function handle(): int
    {
        $userId = $this->option('user');
        $exportFormat = $this->option('export') ?? 'json';

        $this->info('Generating IP Report...');

        $query = IntellectualProperty::query();

        if ($userId) {
            $query->where('owner_id', $userId);
            $this->info("Filtering by User ID: {$userId}");
        }

        $ips = $query->with('owner')->get();

        $report = [
            'generated_at' => now()->toIso8601String(),
            'total_ips' => $ips->count(),
            'by_type' => $ips->groupBy('type')->map->count()->toArray(),
            'by_status' => $ips->groupBy('status')->map->count()->toArray(),
            'active' => $ips->where('status', 'active')->count(),
            'registered' => $ips->where('status', 'registered')->count(),
            'pending' => $ips->where('status', 'pending')->count(),
            'expired' => $ips->where('status', 'expired')->count(),
            'expiring_soon' => $ips->filter(fn($ip) => 
                $ip->expiry_date && 
                $ip->expiry_date->between(now(), now()->addDays(30))
            )->count(),
        ];

        // Display report
        $this->newLine();
        $this->info('=== IP STATISTICS REPORT ===');
        $this->table(
            ['Metric', 'Value'],
            collect($report)->except(['by_type', 'by_status'])->map(fn($value, $key) => [
                ucwords(str_replace('_', ' ', $key)),
                $value
            ])->values()->toArray()
        );

        // Export if requested
        if ($this->option('export')) {
            $this->exportReport($report, $exportFormat);
        }

        return Command::SUCCESS;
    }

    private function exportReport(array $report, string $format): void
    {
        $outputPath = $this->option('output') ?? storage_path('reports/ip_report_' . now()->format('Y-m-d_His') . '.' . $format);

        match($format) {
            'json' => file_put_contents($outputPath, json_encode($report, JSON_PRETTY_PRINT)),
            'csv' => $this->exportToCsv($report, $outputPath),
            default => $this->error("Unsupported export format: {$format}")
        };

        $this->info("Report exported to: {$outputPath}");
    }

    private function exportToCsv(array $report, string $path): void
    {
        $fp = fopen($path, 'w');
        fputcsv($fp, ['Metric', 'Value']);
        foreach ($report as $key => $value) {
            if (!is_array($value)) {
                fputcsv($fp, [ucwords(str_replace('_', ' ', $key)), $value]);
            }
        }
        fclose($fp);
    }
}
