<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = [
        'title',
        'description',
        'department_id',
        'salary_range_min',
        'salary_range_max',
        'is_active',
    ];

    protected $casts = [
        'salary_range_min' => 'decimal:2',
        'salary_range_max' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the department that owns the position.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the employees for the position.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
