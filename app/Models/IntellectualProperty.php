<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\IpType;
use App\Enums\IpStatus;

class IntellectualProperty extends Model
{
    protected $fillable = [
        'application_no','title','type','status','applicant_name','faculty',
        'research_title','budget_year','funding_source','submitter_name',
        'certificate_no','certificate_path','remark','slug','published_at',
        'is_published','attachments'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'attachments'  => 'array',
    ];

    // ตัวช่วย
    public function getTypeLabelAttribute(): string { return (string)$this->type; }
    public function getStatusLabelAttribute(): ?string { return $this->status; }
}
