<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel Struktur PPID untuk halaman PPID
     */
    public function up(): void
    {
        Schema::create('ppid_officials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);               // Nama petugas PPID
            $table->string('position', 150);           // Jabatan dalam PPID
            $table->string('photo', 255)->nullable();  // Path foto
            $table->string('phone', 20)->nullable();   // No HP
            $table->string('email', 100)->nullable();  // Email
            $table->integer('order_num')->nullable()->default(0); // Urutan tampilan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppid_officials');
    }
};
