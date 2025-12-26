<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPessanger extends Model
{
    protected $fillable = [
        'booking_id', 'name','category'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
