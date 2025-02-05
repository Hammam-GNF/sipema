<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notifikasi extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    protected $fillable = [
        'id_user',
        'id_pengaduan',
        'pesan',
        'status_baca',
        'tanggal_kirim'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }
}
