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
            $table->string('name', 150);               // Nama layanan darurat (contoh: Polsek, Puskesmas)
            $table->string('phone', 20);               // Nomor telepon darurat
            $table->string('category', 100)->nullable(); // Kategori (kesehatan, keamanan, bencana, dll)
            $table->string('address', 255)->nullable(); // Alamat
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
