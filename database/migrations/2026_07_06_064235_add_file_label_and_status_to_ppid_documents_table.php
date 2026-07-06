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
        Schema::table('ppid_documents', function (Blueprint $table) {
            $table->string('file_label')->nullable()->after('file_path');
            $table->boolean('is_active')->default(true)->after('file_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppid_documents', function (Blueprint $table) {
            $table->dropColumn(['file_label', 'is_active']);
        });
    }
};
