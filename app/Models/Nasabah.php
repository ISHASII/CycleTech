<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Nasabah extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel di database
    protected $table = 'nasabah'; // Pastikan nama tabel sesuai dengan database Anda

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'photo',
        'password_plaintext',
    ];

    // Kolom-kolom yang harus disembunyikan saat serialisasi (misalnya ke JSON)
    protected $hidden = [
        'password',
        'password_plaintext',
        'remember_token',
    ];

    // Kolom-kolom dengan tipe data khusus
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
