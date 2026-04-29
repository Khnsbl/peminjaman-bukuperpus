<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'peminjamans'; // INI YANG KURANG

    protected $fillable = [
        'user_id', 'buku_id', 'tanggal_pinjam',
        'tanggal_kembali', 'tanggal_dikembalikan',
        'tanggal_pengajuan_kembali', 'status',
        'denda', 'denda_dibayar', 'alasan_terlambat',
    ];

    protected $casts = [
        'tanggal_pinjam'             => 'date',
        'tanggal_kembali'            => 'date',
        'tanggal_dikembalikan'       => 'date',
        'tanggal_pengajuan_kembali'  => 'date',
        'denda_dibayar'              => 'boolean',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isTerlambat(): bool
    {
        $tgl = $this->tanggal_pengajuan_kembali ?? Carbon::today();
        return $tgl->gt($this->tanggal_kembali);
    }

    public function jumlahHariTerlambat(): int
    {
        if (!$this->isTerlambat()) return 0;
        $tgl = $this->tanggal_pengajuan_kembali ?? Carbon::today();
        return $this->tanggal_kembali->diffInDays($tgl);
    }
}