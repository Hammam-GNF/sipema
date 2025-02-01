<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'roles';
    protected $fillable = ['id_role', 'role', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}
