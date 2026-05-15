<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {

            $table->id('id_surat');

            $table->unsignedBigInteger('id_penduduk');

            $table->foreign('id_penduduk')
                ->references('id_penduduk')
                ->on('penduduk')
                ->onDelete('cascade');

            $table->string('jenis_surat', 100);

            $table->date('tanggal_pengajuan');

            $table->enum('status', [
                'diajukan',
                'diproses',
                'disetujui',
                'ditolak'
            ])->default('diajukan');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
