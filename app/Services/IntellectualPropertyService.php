<?php

namespace App\Services;

use App\Models\IntellectualProperty;
use App\Notifications\IPExpiringNotification;
use App\Notifications\IPRegisteredNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class IntellectualPropertyService
{
    /**
     * Register an intellectual property
     * 
     * @param IntellectualProperty $ip
     * @param string $registrationNumber
     * @param string|null $registrationDate
     * @return bool
     */
    public function registerIP(
        IntellectualProperty $ip,
        string $registrationNumber,
        ?string $registrationDate = null
    ): bool {
        DB::beginTransaction();
        
        try {
            $success = $ip->markAsRegistered(
                $registrationNumber,
                $registrationDate
            );
            
            if ($success) {
                // Send notification to owner
                $ip->owner->notify(new IPRegisteredNotification($ip));
                
                // Log the registration
                Log::info("IP Registered", [
                    'ip_id' => $ip->ip_id,
                    'title' => $ip->title,
                    'registration_number' => $registrationNumber,
                    'registered_by' => auth()->id(),
                ]);
            }
            
            DB::commit();
            return $success;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("IP Registration Failed", [
                'ip_id' => $ip->ip_id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Check and notify expiring IPs
     * 
     * @param int $daysThreshold
     * @return int Number of notifications sent
     */
    public function notifyExpiringIPs(int $daysThreshold = 30): int
    {
        $expiringIPs = IntellectualProperty::expiringSoon($daysThreshold)
            ->with('owner')
            ->get();
        
        $notificationCount = 0;
        
        foreach ($expiringIPs as $ip) {
            try {
                $ip->owner->notify(new IPExpiringNotification($ip));
                $notificationCount++;
                
                Log::info("Expiry notification sent", [
                    'ip_id' => $ip->ip_id,
                    'expiry_date' => $ip->expiry_date,
                    'days_remaining' => $ip->expiry_date->diffInDays(now()),
                ]);
                
            } catch (\Exception $e) {
                Log::error("Failed to send expiry notification", [
                    'ip_id' => $ip->ip_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        
        return $notificationCount;
    }

    /**
     * Auto-expire IPs that have passed their expiry date
     * 
     * @return int Number of IPs expired
     */
    public function autoExpireIPs(): int
    {
        $expiredIPs = IntellectualProperty::where('expiry_date', '<', now())
            ->whereNotIn('status', ['expired', 'revoked'])
            ->get();
        
        $expiredCount = 0;
        
        foreach ($expiredIPs as $ip) {
            try {
                $ip->expire();
                $expiredCount++;
                
                Log::info("IP Auto-expired", [
                    'ip_id' => $ip->ip_id,
                    'title' => $ip->title,
                    'expiry_date' => $ip->expiry_date,
                ]);
                
            } catch (\Exception $e) {
                Log::error("Failed to auto-expire IP", [
                    'ip_id' => $ip->ip_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        
        return $expiredCount;
    }

    /**
     * Generate report for a specific user's IPs
     * 
     * @param int $userId
     * @return array
     */
    public function generateUserReport(int $userId): array
    {
        $ips = IntellectualProperty::byOwner($userId)->get();
        
        return [
            'total' => $ips->count(),
            'by_type' => $ips->groupBy('type')->map->count(),
            'by_status' => $ips->groupBy('status')->map->count(),
            'active' => $ips->where('status', 'active')->count(),
            'expiring_soon' => $ips->filter(fn($ip) => 
                $ip->expiry_date && 
                $ip->expiry_date->between(now(), now()->addDays(30))
            )->count(),
            'expired' => $ips->where('status', 'expired')->count(),
            'total_value' => $ips->sum(fn($ip) => 
                $ip->metadata['estimated_value'] ?? 0
            ),
        ];
    }

    /**
     * Validate if title is unique (case-insensitive)
     * 
     * @param string $title
     * @param int|null $excludeId
     * @return bool
     */
    public function isTitleUnique(string $title, ?int $excludeId = null): bool
    {
        $query = IntellectualProperty::whereRaw('LOWER(title) = ?', [strtolower($title)]);
        
        if ($excludeId) {
            $query->where('ip_id', '!=', $excludeId);
        }
        
        return !$query->exists();
    }

    /**
     * Bulk update status
     * 
     * @param array $ipIds
     * @param string $status
     * @return int Number of updated records
     */
    public function bulkUpdateStatus(array $ipIds, string $status): int
    {
        return IntellectualProperty::whereIn('ip_id', $ipIds)
            ->update([
                'status' => $status,
                'updated_by' => auth()->id(),
                'updated_at' => now(),
            ]);
    }

    /**
     * Search IPs with advanced filters
     * 
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function advancedSearch(array $filters)
    {
        $query = IntellectualProperty::query();
        
        if (isset($filters['search'])) {
            $query->search($filters['search']);
        }
        
        if (isset($filters['type'])) {
            $query->byType($filters['type']);
        }
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['owner_id'])) {
            $query->byOwner($filters['owner_id']);
        }
        
        if (isset($filters['date_from'])) {
            $query->where('registration_date', '>=', $filters['date_from']);
        }
        
        if (isset($filters['date_to'])) {
            $query->where('registration_date', '<=', $filters['date_to']);
        }
        
        if (isset($filters['expiring'])) {
            $query->expiringSoon($filters['expiring_days'] ?? 30);
        }
        
        return $query->with(['owner'])->get();
    }
}