<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingVehicle extends Model
{
    use HasFactory;

    protected $table = 'booking_vehicles';

    protected $fillable = [
        'booking_id',
        'vehicle_type',
        'count',
        'unit_price',
        'total_price'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
