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
        Schema::table('tourisms', function (Blueprint $table) {
            $table->dropColumn('ticket_price');
            $table->json('tickets')->nullable()->after('description');
            $table->json('spots')->nullable()->after('tickets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tourisms', function (Blueprint $table) {
            $table->string('ticket_price')->nullable();
            $table->dropColumn('tickets');
            $table->dropColumn('spots');
        });
    }
};
