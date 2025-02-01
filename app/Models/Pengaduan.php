<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pengaduan extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'Pengaduan';
    protected $fillable = [
        'id_petugas',
        'id_kategori',
        'deskripsi',
        'status',
    ];

    public function petugas()
    {
        return $this->hasMany(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function kategori()
    {
        return $this->hasMany(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
