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
        // Kolom ini sudah ada di migration awal (create_emergency_contacts_table).
        // Guard ini mencegah error "Duplicate column" jika migrasi dijalankan dari awal.
        if (!Schema::hasColumn('emergency_contacts', 'description')) {
            Schema::table('emergency_contacts', function (Blueprint $table) {
                $table->text('description')->nullable()->after('phone');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emergency_contacts', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
