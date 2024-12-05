<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kreasi extends Model
{
    use HasFactory;

    protected $table = 'kreasis'; // Nama tabel di database
    protected $primaryKey = 'id'; // Kolom ID di tabel
    public $timestamps = true; // Gunakan created_at dan updated_at
    protected $fillable = [
        'judul_kreasi',
        'foto_kreasi',
        'alat_bahan',
        'langkah',
        'author', // Foreign key untuk user
        'kategori_kreasi',
        'tanggal',
    ];

    // Relasi ke user yang membuat kreasi
    public function user()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    // Relasi ke kategori (opsional jika ada)
    public function kategori()
    {
        return $this->belongsTo(KategoriSampah::class, 'kategori_kreasi', 'id');
    }
}