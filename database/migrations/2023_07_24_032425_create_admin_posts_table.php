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
        Schema::create('admin_posts', function (Blueprint $table) {
            $table->id();
            $table->enum('page',['home','about','contact','download','news']);
            $table->unsignedBigInteger('author_id')->nullable();  // users table
            $table->string('title')->nullable();
            $table->mediumText('content')->nullable(); //16,777,215 characters - 16 MB
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps(); 

            $table->foreign('author_id')->references('id')->on('users')->onDelete('restrict');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_posts');
    }
};
