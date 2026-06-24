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
        Schema::create('service_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_name', 255);
            $table->text('requirements');
            $table->string('estimated_time', 100)->nullable();
            $table->string('fee', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order_num')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_letters');
    }
};
