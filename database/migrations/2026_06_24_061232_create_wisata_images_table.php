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
        Schema::create('tourism_umkm_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tourism_umkm_id')->constrained('tourism_umkm')->onDelete('cascade');
            $table->string('image_path', 255);
            $table->string('caption', 255)->nullable();
            $table->boolean('is_thumbnail')->default(false);
            $table->integer('order_num')->nullable()->default(0);
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourism_umkm_images');
    }
};
