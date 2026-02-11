<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    protected $guarded = [];

    protected $casts = [
        'skills' => 'array',
        'certifications' => 'array',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(($this->first_name[0] ?? '') . ($this->last_name[0] ?? ''));
    }

    public function getAvailabilityLabelAttribute(): string
    {
        return match($this->availability) {
            'immediate' => 'Available Now',
            '2-weeks' => '2 Weeks Notice',
            '1-month' => '1 Month Notice',
            'passive' => 'Passively Looking',
            default => ucfirst($this->availability),
        };
    }
}
