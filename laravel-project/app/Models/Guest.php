<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Guest extends Model
{
    protected $table = 'guests';

    protected $fillable = [
		'name',
		'surname',
		'email',
	];

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class,'guestsList', 'guest_id', 'booking_id');
    }
}
