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
    Schema::create('saved_designs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('status')->default('cart'); // Can be 'cart', 'saved_project', 'ordered'
        $table->json('design_data'); // Stores colors, patterns, jersey type
        $table->json('roster_data')->nullable(); // Stores the array of players
        $table->string('thumbnail_path')->nullable(); // Optional: path to the base64 generated image
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_designs');
    }
};
