<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Mitra tempat mahasiswa FSTI pernah melaksanakan Kerja Praktik (KP) dan/atau Magang.
 */
class InternshipPartner extends Model
{
    use HasFactory;

    public const TYPES = [
        'kp' => 'Kerja Praktik',
        'magang' => 'Magang',
        'kp_magang' => 'KP & Magang',
    ];

    protected $fillable = [
        'name',
        'business_field',
        'location',
        'type',
        'study_program_ids',
        'website',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'study_program_ids' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Filter berdasarkan jenis. Mitra "KP & Magang" ikut muncul saat filter KP maupun Magang.
     */
    public function scopeOfType(Builder $query, ?string $type): Builder
    {
        if (!in_array($type, ['kp', 'magang'], true)) {
            return $query;
        }

        return $query->whereIn('type', [$type, 'kp_magang']);
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
