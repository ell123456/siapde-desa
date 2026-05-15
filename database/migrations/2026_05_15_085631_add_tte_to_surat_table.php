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
        // PAKAI 'surat' (TANPA S) SESUAI NAMA TABEL LO
        Schema::table('surat', function (Blueprint $table) {
            // Cek biar nggak error kalau kolom telanjur ada
            if (!Schema::hasColumn('surat', 'tte_code')) {
                $table->string('tte_code')->nullable()->unique()->after('status');
            }
            if (!Schema::hasColumn('surat', 'disetujui_at')) {
                $table->timestamp('disetujui_at')->nullable()->after('tte_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            if (Schema::hasColumn('surat', 'tte_code')) {
                $table->dropColumn('tte_code');
            }
            if (Schema::hasColumn('surat', 'disetujui_at')) {
                $table->dropColumn('disetujui_at');
            }
        });
    }
};
