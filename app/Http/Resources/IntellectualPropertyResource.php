<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IntellectualPropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'ip_id' => $this->ip_id,
            'title' => $this->title,
            'type' => [
                'value' => $this->type,
                'label' => $this->type_name,
            ],
            'description' => $this->description,
            'owner' => [
                'id' => $this->owner_id,
                'name' => $this->owner->name ?? 'N/A',
                'email' => $this->when(
                    $request->user()?->id === $this->owner_id,
                    $this->owner->email ?? null
                ),
            ],
            'registration' => [
                'date' => $this->registration_date?->format('Y-m-d'),
                'number' => $this->registration_number,
            ],
            'status' => [
                'value' => $this->status,
                'label' => $this->status_name,
            ],
            'expiry' => [
                'date' => $this->expiry_date?->format('Y-m-d'),
                'is_expired' => $this->is_expired,
                'days_remaining' => $this->expiry_date?->diffInDays(now(), false),
            ],
            'metadata' => $this->metadata,
            'attachments' => $this->attachments,
            'timestamps' => [
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => $this->when(
                    !is_null($this->deleted_at),
                    $this->deleted_at?->format('Y-m-d H:i:s')
                ),
            ],
            'audit' => $this->when(
                $request->user() && $request->user()->id === $this->owner_id,
                [
                    'created_by' => $this->creator->name ?? 'System',
                    'updated_by' => $this->updater->name ?? 'N/A',
                ]
            ),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'timestamp' => now()->toIso8601String(),
                'version' => '1.0',
            ],
        ];
    }
}