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
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('event_date');
        });
        
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE posts MODIFY category VARCHAR(255) NOT NULL DEFAULT 'Berita'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE posts MODIFY category ENUM('berita', 'pengumuman', 'agenda') NOT NULL");
        
        Schema::table('posts', function (Blueprint $table) {
            $table->dateTime('event_date')->nullable();
        });
    }
};
