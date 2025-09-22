<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PositionHistory extends Model
{
    protected $fillable = [
        'employee_id',
        'title',
        'department_id',
        'start_date',
        'end_date',
        'is_primary',
        'salary',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_primary' => 'boolean',
        'salary' => 'decimal:2',
    ];

    /**
     * Get the employee that owns the position history.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the department for this position.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the duration of this position in days.
     */
    public function getDurationInDaysAttribute(): int
    {
        $start = $this->start_date;
        $end = $this->end_date ?? now();
        
        return $start->diffInDays($end);
    }

    /**
     * Check if this position is currently active.
     */
    public function getIsActiveAttribute(): bool
    {
        return is_null($this->end_date);
    }

    /**
     * Scope for active positions.
     */
    public function scopeActive($query)
    {
        return $query->whereNull('end_date');
    }

    /**
     * Scope for primary positions.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }
}