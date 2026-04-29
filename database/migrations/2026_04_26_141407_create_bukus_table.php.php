<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku')->unique();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->year('tahun_terbit')->nullable();
            $table->foreignId('category_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('bahasa')->default('Indonesia');
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(0);
            $table->string('cover')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};