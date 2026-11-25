<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
//use Illuminate\Database\Eloquent\Relations\HasMany;
//use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    protected $table = 'rooms';
    protected $fillable = [
        'inTime',
        'outTime',    
        'name',
        'capacity',
        'space'
    ];

    public function bookings(): HasMany
    {
        return $this->belongsTo(Booking::class);
    }
}
