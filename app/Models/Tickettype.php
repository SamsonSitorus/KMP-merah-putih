<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tickettype extends Model
{
    protected $table = 'ticket_types';  

    protected $fillable = [
        'name',
    ];  

    //relasi ke ticket prices
    public function ticketPrices(): HasMany
    {   
        return $this->hasMany(TicketPrice::class, 'ticket_type_id');
    }

    //relasi ke ticket stocks       
    public function ticketStocks(): HasMany
    {   
        return $this->hasMany(TicketStock::class, 'ticket_type_id');
    }       
}
