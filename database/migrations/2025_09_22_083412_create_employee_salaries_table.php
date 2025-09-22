<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Salary component name (e.g., "Base Salary", "Allowance", "Bonus")
            $table->decimal('salary', 10, 2); // Salary amount
            $table->boolean('is_active')->default(true); // Whether this salary component is active
            $table->date('effective_date')->nullable(); // When this salary component becomes effective
            $table->date('end_date')->nullable(); // When this salary component ends (for historical tracking)
            $table->text('notes')->nullable(); // Additional notes about this salary component
            $table->timestamps();

            $table->index(['employee_id', 'is_active']);
            $table->index(['employee_id', 'effective_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salaries');
    }
};