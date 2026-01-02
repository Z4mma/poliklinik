<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'nama',
        'alamat',
        'no_ktp',
        'no_rm',
        'role',
        'id_poli',
        'email',
        'password'
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];
    protected function cast(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    public function pasien(){
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function jadwalPeriksa(){
        return $this->hasMany(JadwalPeriksa::class, 'id_dokter');
    }
}