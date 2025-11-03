<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStock extends Model
{
    protected $fillable = [
        'origin_port_id',
        'destination_port_id',
        'departure_date',
        'departure_time',
        'total_stock',
        'remaining_stock',
    ];

    public function originPort()
    {
        return $this->belongsTo(Port::class, 'origin_port_id');
    }

    public function destinationPort()
    {
        return $this->belongsTo(Port::class, 'destination_port_id');
    }

    // Relasi ke harga tiket
    public function prices()
    {
        return $this->hasMany(TicketPrice::class, 'ticket_stock_id');
    }
}
