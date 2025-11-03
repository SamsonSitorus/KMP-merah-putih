<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPrice extends Model
{
    protected $fillable = [
        'ticket_stock_id',
        'passenger_type',
        'vehicle_type',
        'price',
    ];

    /**
     * Relasi ke tabel TicketStock
     */
    public function stock()
    {
        return $this->belongsTo(TicketStock::class, 'ticket_stock_id');
    }

    /**
     * Scope untuk memfilter harga berdasarkan tipe penumpang
     */
    public function scopePassenger($query, $type)
    {
        return $query->where('passenger_type', $type);
    }

    /**
     * Scope untuk memfilter harga berdasarkan tipe kendaraan
     */
    public function scopeVehicle($query, $type)
    {
        return $query->where('vehicle_type', $type);
    }
}
