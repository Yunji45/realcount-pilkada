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
        Schema::create('tps_realcounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('provinsi_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kabupaten_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kecamatan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelurahan_id')->constrained()->cascadeOnDelete();
            $table->string('rw')->nullable();
            $table->string('DPT')->nullable();
            $table->date('periode')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->enum('status', ['Aktif', 'Non-aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tps_realcounts');
    }
};
