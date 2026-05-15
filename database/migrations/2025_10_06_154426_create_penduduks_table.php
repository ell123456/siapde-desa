<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id('id_penduduk');
            $table->string('nik', 20)->unique();
            $table->string('nama', 100);
            $table->string('tempat_lahir', 100); // <-- Tambahkan ini
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('pekerjaan', 100)->nullable(); // <-- Tambahkan ini
            $table->text('alamat');

            // Relasi ke tabel users
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps(); // <--- tambahkan ini
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
