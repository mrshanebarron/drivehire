<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    protected $guarded = [];

    protected $casts = [
        'stage_history' => 'array',
        'applied_at' => 'datetime',
        'match_score' => 'float',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class);
    }

    public function getStageLabelAttribute(): string
    {
        return match($this->stage) {
            'new' => 'New',
            'screening' => 'Screening',
            'interview' => 'Interview',
            'assessment' => 'Assessment',
            'offer' => 'Offer',
            'hired' => 'Hired',
            'rejected' => 'Rejected',
            default => ucfirst($this->stage),
        };
    }

    public function getStageColorAttribute(): string
    {
        return match($this->stage) {
            'new' => 'blue',
            'screening' => 'indigo',
            'interview' => 'violet',
            'assessment' => 'amber',
            'offer' => 'emerald',
            'hired' => 'green',
            'rejected' => 'red',
            default => 'slate',
        };
    }

    public static array $stages = ['new', 'screening', 'interview', 'assessment', 'offer', 'hired', 'rejected'];
}
