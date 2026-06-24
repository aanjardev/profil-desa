<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel RT/RW untuk halaman Kelembagaan
     */
    public function up(): void
    {
        Schema::create('rt_rws', function (Blueprint $table) {
            $table->id();
            $table->string('rw_number', 10);          // Nomor RW (contoh: 001)
            $table->string('rt_number', 10)->nullable(); // Nomor RT (null = data RW)
            $table->string('head_name', 150);          // Nama ketua RT/RW
            $table->string('head_phone', 20)->nullable(); // No HP ketua
            $table->integer('total_kk')->nullable()->default(0);    // Jumlah KK
            $table->integer('total_male')->nullable()->default(0);   // Jumlah laki-laki
            $table->integer('total_female')->nullable()->default(0); // Jumlah perempuan
            $table->string('area_name', 100)->nullable(); // Nama wilayah/dusun
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rt_rws');
    }
};
