<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pengaduan extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';
    protected $fillable = [
        'id_petugas',
        'id_user',
        'judul_pengaduan',
        'deskripsi',
        'tanggal_pengaduan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjut::class, 'id_pengaduan', 'id_pengaduan');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_pengaduan', 'id_pengaduan');
    }
}
