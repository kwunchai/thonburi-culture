<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CulturalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'community_id',
        'description',
        'image',
        'publish_date',
        'is_published',
        'is_featured',      // เพิ่ม
        'featured_order',    // เพิ่ม
        'created_by'
    ];

    protected $casts = [
        'publish_date' => 'date',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',  // เพิ่ม
    ];

    // Relationships (เหมือนเดิม)
    public function category()
    {
        return $this->belongsTo(CulturalCategory::class, 'category_id');
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('publish_date', '<=', now());
    }

    // Scope สำหรับ Featured Items
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->orderBy('featured_order', 'asc')
                     ->orderBy('publish_date', 'desc');
    }
}