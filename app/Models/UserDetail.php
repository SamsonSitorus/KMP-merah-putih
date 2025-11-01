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
        'email',
        'nomor_identitas',
        'kota_asal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
