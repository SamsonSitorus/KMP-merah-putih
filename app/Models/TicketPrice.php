<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPrice extends Model
{
    protected $fillable = [
        'ticket_stock_id',
        'passenger_type',
        'price',
    ];

    // Relasi balik ke stok tiket
    public function stock()
    {
        return $this->belongsTo(TicketStock::class, 'ticket_stock_id');
    }
}
