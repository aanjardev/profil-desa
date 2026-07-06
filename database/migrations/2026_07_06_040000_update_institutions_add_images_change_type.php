<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - Ubah kolom type dari ENUM ke string agar lebih fleksibel
     * - Tambah kolom images (JSON) untuk galeri foto lembaga
     */
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            // Ganti ENUM type ke string (lebih fleksibel, kategori umum)
            $table->string('type', 50)->default('kemasyarakatan')->change();

            // Tambah galeri foto lembaga
            $table->json('images')->nullable()->after('logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->dropColumn('images');
            $table->enum('type', ['BPD', 'PKK', 'LINMAS', 'KIM', 'RTRW', 'KARANG_TARUNA', 'BUMDES'])->change();
        });
    }
};
