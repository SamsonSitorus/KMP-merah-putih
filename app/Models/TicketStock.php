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

    /**
     * Cari stok tiket berdasarkan filter rute dan tanggal.
     * Mengembalikan collection TicketStock yang cocok.
     *
     * @param int|null $originId
     * @param int|null $destinationId
     * @param string|null $departureDate (Y-m-d)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchByRoute($originId = null, $destinationId = null, $departureDate = null)
    {
        $query = self::query();

        if ($originId) {
            $query->where('origin_port_id', $originId);
        }

        if ($destinationId) {
            $query->where('destination_port_id', $destinationId);
        }

        if ($departureDate) {
            $query->where('departure_date', $departureDate);
        }

        return $query->get();
    }
}
