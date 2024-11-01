<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik')->unique();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->string('email')->unique();
            $table->text('ktp')->nullable();
            $table->text('photo')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Pria', 'Wanita'])->default('Pria');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['Aktif', 'Pending', 'Tidak Aktif'])->default('Aktif');
            // $table->foreignId('kelurahan_id')->constrained()->restrictOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
