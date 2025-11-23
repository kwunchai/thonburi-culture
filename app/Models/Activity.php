<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'images', // Multiple images JSON
        'activity_date',
        'start_time',
        'end_time', 
        'location',
        'category_id',
        'is_active',
        'sort_order',
        'views_count',
        'meta_data',
        'created_by'
    ];

    protected $casts = [
        'activity_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'views_count' => 'integer',
        'images' => 'array',
        'meta_data' => 'array',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(ActivityCategory::class, 'category_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('activity_date', 'desc');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('activity_date', '>=', now()->toDateString());
    }

    public function scopePast($query)
    {
        return $query->where('activity_date', '<', now()->toDateString());
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->orderBy('views_count', 'desc')->limit($limit);
    }

    // Accessors
    public function getFormattedDateAttribute()
    {
        return $this->activity_date ? $this->activity_date->format('d M Y') : null;
    }

    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time ? $this->start_time->format('H:i') : null;
    }

    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? $this->end_time->format('H:i') : null;
    }

    public function getTimeRangeAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return $this->formatted_start_time . ' - ' . $this->formatted_end_time;
        }
        return null;
    }

    public function getAllImagesAttribute()
    {
        $allImages = [];
        
        // Add main image
        if ($this->image) {
            $allImages[] = $this->image;
        }
        
        // Add additional images
        if ($this->images && is_array($this->images)) {
            $allImages = array_merge($allImages, $this->images);
        }
        
        return $allImages;
    }

    public function getIsUpcomingAttribute()
    {
        return $this->activity_date && $this->activity_date->isFuture();
    }

    public function getStatusBadgeAttribute()
    {
        if (!$this->is_active) {
            return ['class' => 'bg-gray-500', 'text' => 'ปิดการใช้งาน'];
        }
        
        if ($this->is_upcoming) {
            return ['class' => 'bg-blue-500', 'text' => 'กำลังจะมาถึง'];
        }
        
        return ['class' => 'bg-green-500', 'text' => 'จัดแล้ว'];
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
