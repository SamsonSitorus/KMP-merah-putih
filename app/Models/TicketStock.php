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
        'stock_roda_4',
        'stock_roda_2',
        'stock_passenger'
    ];

    public function originPort()
    {
        return $this->belongsTo(Port::class, 'origin_port_id');
    }

    public function destinationPort()
    {
        return $this->belongsTo(Port::class, 'destination_port_id');
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
