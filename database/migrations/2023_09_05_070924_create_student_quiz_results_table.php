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
        Schema::create('student_quiz_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('quiz_id');
            $table->string('grading_period');
            $table->integer('quiz_score');
            $table->string('quiz_grade'); 
            $table->enum('status',['done','lapse']);
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_quiz_results');
    }
};
