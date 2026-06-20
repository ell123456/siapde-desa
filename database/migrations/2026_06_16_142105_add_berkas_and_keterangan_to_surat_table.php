<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBerkasAndKeteranganToSuratTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('surat', function (Blueprint $table) {
            // Kita hanya tambah kolom berkas saja karena keterangan sudah ada
            $table->text('berkas')->nullable()->after('disetujui_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropColumn(['berkas']);
        });
    }
}
