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
            $table->unsignedBigInteger('comment_id')->nullable(); // comments table
            $table->unsignedBigInteger('subject'); // to which page this will be posted
            $table->string('title');
            $table->mediumText('content'); //16,777,215 characters - 16 MB
            $table->enum('status',['active','pending']);
            
            $table->string('attachments')->nullable(); // image or video
            $table->timestamps(); 

            $table->foreign('author_id')->references('id')->on('users')->onDelete('restrict');
            

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
