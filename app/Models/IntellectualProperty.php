<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use App\Policies\IntellectualPropertyPolicy;

class IntellectualProperty extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'ip_id';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'ip_id';
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'type',
        'description',
        'owner_id',
        'owner_type',
        'registration_date',
        'registration_number',
        'status',
        'metadata',
        'attachments',
        'expiry_date',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'registration_date' => 'date',
        'expiry_date' => 'date',
        'metadata' => 'array',
        'attachments' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'created_by',
        'updated_by',
    ];

    /**
     * Valid IP types
     */
    public const TYPES = [
        'copyright' => 'Copyright',
        'patent' => 'Patent',
        'trademark' => 'Trademark',
        'local_wisdom' => 'Local Wisdom',
        'trade_secret' => 'Trade Secret',
        'other' => 'Other',
    ];

    /**
     * Valid statuses
     */
    public const STATUSES = [
        'draft' => 'Draft',
        'pending' => 'Pending Review',
        'registered' => 'Registered',
        'active' => 'Active',
        'expired' => 'Expired',
        'rejected' => 'Rejected',
        'revoked' => 'Revoked',
    ];

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->owner_id = $model->owner_id ?? Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    /**
     * Relationships
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByOwner($query, int $ownerId)
    {
        return $query->where('owner_id', $ownerId);
    }

    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->whereBetween('expiry_date', [
            now(),
            now()->addDays($days)
        ]);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->whereRaw(
            'MATCH(title, description) AGAINST(? IN BOOLEAN MODE)',
            [$term]
        );
    }

    /**
     * Accessors & Mutators
     */
    public function getIsExpiredAttribute(): bool
    {
        if (!$this->expiry_date) {
            return false;
        }
        return $this->expiry_date->isPast();
    }

    public function getTypeNameAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function getStatusNameAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status ?? 'Unknown';
    }

    /**
     * Business Logic Methods
     */
    public function markAsRegistered(string $registrationNumber, ?string $registrationDate = null): bool
    {
        return $this->update([
            'status' => 'registered',
            'registration_number' => $registrationNumber,
            'registration_date' => $registrationDate ?? now(),
        ]);
    }

    public function expire(): bool
    {
        return $this->update([
            'status' => 'expired',
            'expiry_date' => now(),
        ]);
    }

    public function revoke(): bool
    {
        return $this->update(['status' => 'revoked']);
    }
}