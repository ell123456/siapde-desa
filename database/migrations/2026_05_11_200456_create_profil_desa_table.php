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
        Schema::create('profil_desa', function (Blueprint $table) {
            $table->id();
            // Tambahkan kolom di bawah ini:
            $table->string('nama_desa')->default('Desa XYZ');
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('nama_kades')->nullable();
            $table->string('nama_sekdes')->nullable();
            $table->string('nama_kaur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_desa');
    }
};
