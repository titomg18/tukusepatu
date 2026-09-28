<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama_user',
        'email',
        'password',
        'role',
        'tgl_daftar',
        'foto_profil',
        'status_user',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tgl_daftar' => 'date',
    ];

    // Karena kita tidak pakai remember_token
    public function getRememberToken() { return null; }
    public function setRememberToken($value) {}
    public function getRememberTokenName() { return null; }
}