<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'checkin',
        'checkout',
        'overtime_minutes',
        'notes',
        'source',
    ];

    protected $casts = [
        'date' => 'date',
        'checkin' => 'datetime',
        'checkout' => 'datetime',
        'overtime_minutes' => 'integer',
    ];

    /**
     * Get the employee that owns the attendance record.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the total working hours for the day.
     */
    public function getTotalHoursAttribute(): float
    {
        if (!$this->checkin || !$this->checkout) {
            return 0;
        }

        $checkin = Carbon::parse($this->checkin);
        $checkout = Carbon::parse($this->checkout);
        
        return $checkout->diffInHours($checkin);
    }

    /**
     * Get the overtime hours for the day.
     */
    public function getOvertimeHoursAttribute(): float
    {
        return $this->overtime_minutes / 60;
    }

    /**
     * Check if the attendance is complete (has both checkin and checkout).
     */
    public function getIsCompleteAttribute(): bool
    {
        return !is_null($this->checkin) && !is_null($this->checkout);
    }

    /**
     * Check if the attendance is late (checkin after 9:00 AM).
     */
    public function getIsLateAttribute(): bool
    {
        if (!$this->checkin) {
            return false;
        }

        $checkinTime = Carbon::parse($this->checkin);
        $expectedTime = Carbon::parse($this->date)->setTime(9, 0, 0);
        
        return $checkinTime->gt($expectedTime);
    }
}