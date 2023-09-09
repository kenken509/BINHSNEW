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
        Schema::create('student_active_quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sent_quizzes_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('quiz_id');
            $table->string('grading_period');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('quiz_score')->nullable();
            $table->string('quiz_grade')->nullable(); 
            $table->enum('status',['done','lapse','pending'])->default('pending');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sent_quizzes_id')->references('id')->on('sent_quizzes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_active_quizzes');
    }
};
