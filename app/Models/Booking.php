<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookingVehicle;
use App\Models\User;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_stock_id',
        'departure_date',
        'departure_time',
        'total_price',
        'payment_proof_path',
        'status',
        'booksource',
        'booker_name'    
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(BookingVehicle::class);
    }

    public function ticketStock()
    {
        return $this->belongsTo(TicketStock::class, 'ticket_stock_id');
    }

    public function passenger()
    {
        return $this->hasMany(BookingPassengers::class);
    }
}
