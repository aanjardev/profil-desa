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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('reporter_name', 150);
            $table->string('reporter_phone', 20);
            $table->string('reporter_email', 100)->nullable();
            $table->string('title', 255);
            $table->text('content');
            $table->string('attachment', 255)->nullable();
            $table->enum('status', ['pending', 'proses', 'selesai']);
            $table->text('admin_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
