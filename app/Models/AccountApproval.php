<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'full_name',
        'email',
        'status',
        'sport',
        'campus',
        'year_section',
        'file_name',
        'file_data',
        'file_type',
        'file_size',
        'approval_status',
        'approved_by',
        'approval_date',
    ];

    protected $casts = [
        'request_date' => 'datetime',
        'approval_date' => 'datetime',
    ];

    /**
     * Get the admin that approved the account.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }
}
