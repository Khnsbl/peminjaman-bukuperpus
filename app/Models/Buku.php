<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'isbn',
        'tahun_terbit',
        'category_id',
        'stok',
        'bahasa',
        'deskripsi',
        'cover',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'category_id');
    }
}