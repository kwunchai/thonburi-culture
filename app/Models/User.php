<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isIpManager(): bool
    {
        return $this->role === 'ip_manager';
    }

    public function isViewer(): bool
    {
        return $this->role === 'viewer';
    }

    public function canManageIp(): bool
    {
        return in_array($this->role, ['admin', 'ip_manager']);
    }

    public function culturalItems()
    {
        return $this->hasMany(CulturalItem::class, 'created_by');
    }

    public function intellectualProperties()
    {
        return $this->hasMany(IntellectualProperty::class, 'created_by');
    }
}