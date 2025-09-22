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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('checkin')->nullable();
            $table->time('checkout')->nullable();
            $table->integer('overtime_minutes')->default(0);
            $table->text('notes')->nullable();
            $table->enum('source', ['device', 'import', 'manual'])->default('device');
            $table->timestamps();

            $table->index(['employee_id', 'date']);
            $table->unique(['employee_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};