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
        Schema::create('web_posts', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('author_id');  // users table
            $table->unsignedBigInteger('subject_id')->nullable(); // to which subject the post will be posted
            $table->string('title');
            $table->mediumText('content'); //16,777,215 characters - 16 MB
            $table->enum('status',['active','pending'])->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps(); 

            $table->foreign('author_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('restrict');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_posts');
    }
};
