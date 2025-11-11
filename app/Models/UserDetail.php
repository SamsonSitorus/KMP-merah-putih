<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'users_detail'; // nama tabel
     protected $fillable = [
        'user_id',
        'tanggal_lahir',
        'gender',
        'jenis_id',
        'nomor_identitas',
        'kota_asal',
        'ZipCode',
        'foto_profil'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
