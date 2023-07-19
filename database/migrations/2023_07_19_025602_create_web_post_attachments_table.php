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
        Schema::create('web_post_attachments', function(Blueprint $table){
            $table->id();
            $table->enum('type',['Image','Video']);
            $table->unsignedBigInteger('web_post_id');
            $table->foreign('web_post_id')->references('id')->on('web_posts')->onDelete('cascade');
            $table->string('filename');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_post_attachments');
    }
};
