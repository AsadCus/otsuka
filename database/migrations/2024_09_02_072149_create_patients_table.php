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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik');
            $table->string('unique_number')->unique();
            $table->string('place_of_birth');
            $table->timestamp('time_of_birth');
            $table->text('address')->nullable();
            $table->foreignId('province_id')->index()->constrained('reg_provinces')->cascadeOnDelete();
            $table->foreignId('regency_id')->index()->constrained('reg_regencies')->cascadeOnDelete();
            $table->foreignId('treated_by')->index()->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
