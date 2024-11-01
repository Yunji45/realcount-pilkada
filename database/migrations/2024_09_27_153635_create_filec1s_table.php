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
        Schema::create('filec1s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tps_realcount_id')->constrained()->restrictOnDelete();
            $table->foreignId('election_id')->constrained()->restrictOnDelete();
            $table->string('file')->nulllable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filec1s');
    }
};
