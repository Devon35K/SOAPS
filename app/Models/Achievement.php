<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    use HasFactory;

    protected $primaryKey = 'achievement_id';

    protected $fillable = [
        'user_id',
        'athlete_name',
        'level_of_competition',
        'performance',
        'number_of_events',
        'leadership_role',
        'sportsmanship',
        'community_impact',
        'completeness_of_documents',
        'total_points',
        'documents',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'submission_date' => 'datetime',
        'documents' => 'array',
    ];

    /**
     * Get the user that owns the achievement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
