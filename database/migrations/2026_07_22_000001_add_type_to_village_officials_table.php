<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_officials', function (Blueprint $table) {
            // Type: eksekutif (default) | legislatif (BPD) | kasun | staf
            $table->string('type', 30)->default('eksekutif')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('village_officials', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
