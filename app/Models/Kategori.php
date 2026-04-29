<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'status',
        'warna',
    ];

    // ✅ Tambahan relasi ke Buku
    public function bukus()
    {
        return $this->hasMany(Buku::class, 'category_id');
    }
}