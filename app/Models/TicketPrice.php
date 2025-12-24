<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPrice extends Model
{
    use HasFactory;

    protected $table = 'ticket_prices';

    protected $fillable = [
        'name',
        'ticket_type_id',
        'price',
    ];

    /**
     * Relasi ke tabel TicketStock
     */
    public function tickettype()
    {
        return $this->belongsTo(Tickettype::class, 'ticket_type_id');
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
