<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Position extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_remote' => 'boolean',
        'published_at' => 'datetime',
        'closes_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function getSalaryRangeAttribute(): string
    {
        if (!$this->salary_min && !$this->salary_max) return 'Competitive';
        $fmt = fn($v) => $this->salary_period === 'hour' ? '$' . $v . '/hr' : '$' . number_format($v / 1000) . 'K';
        if ($this->salary_min && $this->salary_max) return $fmt($this->salary_min) . ' – ' . $fmt($this->salary_max);
        return $fmt($this->salary_min ?: $this->salary_max);
    }

    public function getDepartmentLabelAttribute(): string
    {
        return match($this->department) {
            'service' => 'Service',
            'sales' => 'Sales',
            'parts' => 'Parts',
            'body-shop' => 'Body Shop',
            'admin' => 'Administration',
            'management' => 'Management',
            default => ucfirst($this->department),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'emerald',
            'draft' => 'slate',
            'paused' => 'amber',
            'closed' => 'red',
            'filled' => 'blue',
            default => 'slate',
        };
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
