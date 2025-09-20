<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'latitude',
        'longitude',
        'address',
        'contact_phone',
        'contact_email',
        'website',
        'facebook',
        'line_id',
        'opening_hours',
        'is_active'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relationships
     */
    public function culturalItems()
    {
        return $this->hasMany(CulturalItem::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithLocation($query)
    {
        return $query->whereNotNull('latitude')
                     ->whereNotNull('longitude');
    }

    /**
     * Accessors
     */
    public function getMapUrlAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return null;
    }

    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            'เขตธนบุรี',
            'กรุงเทพมหานคร'
        ]);
        return implode(', ', $parts);
    }

    public function getHasContactAttribute()
    {
        return $this->contact_phone || $this->contact_email || $this->website;
    }

}