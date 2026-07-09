<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel Kontak Darurat untuk halaman Pelayanan
     */
    public function up(): void
    {
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('phone', 20);
            $table->string('category', 100)->nullable();
            $table->string('description')->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('order_num')->nullable()->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};
