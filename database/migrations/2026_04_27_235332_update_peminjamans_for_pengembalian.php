<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu',        // user ajukan
                'dipinjam',        // admin approve
                'ditolak',         // admin tolak
                'pengajuan_kembali', // user isi form pengembalian
                'terlambat_review',  // admin review keterlambatan
                'menunggu_bayar',    // user harus bayar denda
                'dikembalikan',      // selesai
                'terlambat',         // selesai tapi terlambat
            ])->default('menunggu')->change();

            $table->text('alasan_terlambat')->nullable()->after('denda');
            $table->date('tanggal_pengajuan_kembali')->nullable()->after('alasan_terlambat');
            $table->boolean('denda_dibayar')->default(false)->after('tanggal_pengajuan_kembali');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['alasan_terlambat', 'tanggal_pengajuan_kembali', 'denda_dibayar']);
        });
    }
};