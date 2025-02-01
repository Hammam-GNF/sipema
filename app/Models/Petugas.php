<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Petugas extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'petugas';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
}
