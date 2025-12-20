<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
        'established_year',
        'population',
        'area_size',
        'highlights',
        'is_active'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'area_size' => 'decimal:2',
        'is_active' => 'boolean'
        // Note: population and established_year are stored as strings to allow flexible input
        // population can be "1,500-1,800" or "ประมาณ 2,000 คน"
        // established_year is Buddhist Era year (พ.ศ.) like "2510"
    ];

    // Relationships
    public function culturalItems()
    {
        return $this->hasMany(CulturalItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithLocation($query)
    {
        return $query->whereNotNull('latitude')
                     ->whereNotNull('longitude');
    }

    // Accessors
    /**
     * Get formatted population display string
     * Handles both numeric values and text (e.g., "1,500-1,800" or "ประมาณ 2,000 คน")
     * 
     * @return string
     */
    public function getPopulationDisplayAttribute()
    {
        // Handle null/empty
        if (empty($this->population)) {
            return '-';
        }

        $population = trim($this->population);

        // Check if it's a numeric value (can be integer or numeric string like "1500")
        if (is_numeric($population)) {
            return number_format((float)$population) . ' คน';
        }

        // It's text - check if it already contains "คน"
        if (str_contains($population, 'คน')) {
            return $population;
        }

        // Append " คน" for text values that don't have it
        return $population . ' คน';
    }

    // Methods
    public function hasLocation()
    {
        return $this->latitude && $this->longitude;
    }

    public function getMapUrl()
    {
        if ($this->hasLocation()) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return null;
    }
}