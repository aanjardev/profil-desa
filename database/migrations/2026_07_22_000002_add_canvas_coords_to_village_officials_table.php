<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_officials', function (Blueprint $table) {
            $table->integer('pos_x')->nullable()->after('type');
            $table->integer('pos_y')->nullable()->after('pos_x');
        });
    }

    public function down(): void
    {
        Schema::table('village_officials', function (Blueprint $table) {
            $table->dropColumn(['pos_x', 'pos_y']);
        });
    }
};
