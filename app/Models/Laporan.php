<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Laporan extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    protected $fillable = [
        'id_petugas',
        'id_pengaduan',
        'isi_laporan',
        'tanggal_laporan',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }
}
