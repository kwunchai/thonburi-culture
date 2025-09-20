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
        'address',
        'contact_name',
        'contact_phone',
        'contact_email',
        'website',
        'facebook',
        'line_id',
        'image',
        'gallery_images',
        'latitude',
        'longitude',
        'established_year',
        'population',
        'area_size',
        'highlights',
        'working_hours',
        'is_active'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'area_size' => 'decimal:2',
        'is_active' => 'boolean',
        'gallery_images' => 'array',
        'population' => 'integer',
        'established_year' => 'integer'
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
    public function getGalleryImagesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
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

    public function getDisplayAddress()
    {
        $parts = array_filter([
            $this->address,
            'เขตธนบุรี',
            'กรุงเทพมหานคร'
        ]);
        return implode(', ', $parts);
    }
}