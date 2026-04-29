<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan hanya kolom yang belum ada di tabel users
            if (!Schema::hasColumn('users', 'kelas')) {
                $table->string('kelas', 50)->nullable()->after('nisn');
            }
            if (!Schema::hasColumn('users', 'jurusan')) {
                $table->string('jurusan', 100)->nullable()->after('kelas');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('siswa')->after('email');
            }
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['kelas', 'jurusan', 'role', 'foto', 'is_active'];
            $existing = array_filter($columns, fn($col) => Schema::hasColumn('users', $col));
            if (!empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
};