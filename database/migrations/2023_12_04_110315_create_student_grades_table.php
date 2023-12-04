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
        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->decimal('first_grading', 8, 2)->default(0);
            $table->decimal('second_grading', 8, 2)->default(0);
            $table->decimal('third_grading', 8, 2)->default(0);
            $table->decimal('fourth_grading', 8, 2)->default(0);
            
            // Computed column for final_grade
            $table->decimal('final_grade', 8, 2)->storedAs(
                '(`first_grading` + `second_grading` + `third_grading` + `fourth_grading`) / 4'
            );
            
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('restrict');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
