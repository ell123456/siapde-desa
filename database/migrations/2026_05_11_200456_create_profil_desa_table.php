<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_desa', function (Blueprint $table) {
            // Tambah kolom yang belum ada
            if (!Schema::hasColumn('profil_desa', 'syarat_waris')) {
                $table->text('syarat_waris')->nullable()->after('syarat_domisili');
            }
            if (!Schema::hasColumn('profil_desa', 'syarat_lahir')) {
                $table->text('syarat_lahir')->nullable()->after('syarat_waris');
            }
            if (!Schema::hasColumn('profil_desa', 'syarat_mati')) {
                $table->text('syarat_mati')->nullable()->after('syarat_lahir');
            }
            if (!Schema::hasColumn('profil_desa', 'syarat_belum_rumah')) {
                $table->text('syarat_belum_rumah')->nullable()->after('syarat_mati');
            }
            if (!Schema::hasColumn('profil_desa', 'syarat_pindah')) {
                $table->text('syarat_pindah')->nullable()->after('syarat_belum_rumah');
            }
            if (!Schema::hasColumn('profil_desa', 'syarat_tanah')) {
                $table->text('syarat_tanah')->nullable()->after('syarat_pindah');
            }
        });
    }

    public function down(): void
    {
        Schema::table('profil_desa', function (Blueprint $table) {
            $table->dropColumn([
                'syarat_waris',
                'syarat_lahir',
                'syarat_mati',
                'syarat_belum_rumah',
                'syarat_pindah',
                'syarat_tanah',
            ]);
        });
    }
};
