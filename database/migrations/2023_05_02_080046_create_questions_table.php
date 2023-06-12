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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->enum('question_type',['multiple_choice','fill_in_the_blank', 'true/false', 'matching', 'essay'])->default('multiple_choice');
            $table->unsignedBigInteger('subject_id');
            $table->string('correct_answer');
            $table->integer('created_by')->nullable();
            $table->integer('updated-by')->nullable();

            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
