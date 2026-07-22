<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sotk_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('target_id');
            $table->string('line_type', 50)->default('solid'); // solid, dashed
            $table->timestamps();

            $table->foreign('source_id')->references('id')->on('village_officials')->onDelete('cascade');
            $table->foreign('target_id')->references('id')->on('village_officials')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sotk_lines');
    }
};
