<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel Kontak Layanan Desa untuk halaman Pelayanan
     */
    public function up(): void
    {
        Schema::create('contact_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name', 150);       // Nama layanan (contoh: Pelayanan KTP)
            $table->string('officer_name', 150)->nullable(); // Nama petugas
            $table->string('phone', 20)->nullable();   // Nomor telepon/HP
            $table->string('email', 100)->nullable();  // Email
            $table->string('office_hours', 100)->nullable(); // Jam operasional
            $table->string('location', 255)->nullable(); // Lokasi/ruangan
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
        Schema::dropIfExists('contact_services');
    }
};
