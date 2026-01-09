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
        'vehicle_name',
        'vehicle_year',
        'count',
        'no_plat',
        'category'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
