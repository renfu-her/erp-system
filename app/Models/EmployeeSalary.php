<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeSalary extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'salary',
        'is_active',
        'effective_date',
        'end_date',
        'notes',
    ];

    protected $casts = [
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
        'effective_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the employee that owns the salary component.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Scope for active salary components.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for current salary components (active and within date range).
     */
    public function scopeCurrent($query)
    {
        $today = now()->toDateString();
        
        return $query->where('is_active', true)
                    ->where(function ($q) use ($today) {
                        $q->whereNull('effective_date')
                          ->orWhere('effective_date', '<=', $today);
                    })
                    ->where(function ($q) use ($today) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', $today);
                    });
    }

    /**
     * Get the total salary for an employee.
     */
    public static function getTotalSalaryForEmployee($employeeId)
    {
        return static::where('employee_id', $employeeId)
                    ->current()
                    ->sum('salary');
    }

    /**
     * Get salary components for an employee.
     */
    public static function getSalaryComponentsForEmployee($employeeId)
    {
        return static::where('employee_id', $employeeId)
                    ->current()
                    ->orderBy('name')
                    ->get();
    }
}