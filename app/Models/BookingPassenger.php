<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPassenger extends Model
{
    protected $fillable = [
        'booking_id', 'name'
    ];
    protected $table = 'booking_passengers';
    
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
