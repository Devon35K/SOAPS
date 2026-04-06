<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'year_section',
        'contact_email',
        'document_type',
        'other_type',
        'file_name',
        'file_data',
        'file_size',
        'description',
        'status',
        'comments',
    ];

    protected $casts = [
        'submission_date' => 'datetime',
    ];

    /**
     * Get the user that owns the submission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
