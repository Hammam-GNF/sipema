<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TindakLanjut extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tindak_lanjut';
    protected $primaryKey = 'id_tindak_lanjut';
    protected $fillable = [
        'id_petugas',
        'id_pengaduan',
        'tanggal_tindak_lanjut',
        'catatan_tindak_lanjut',
        'hasil',
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
