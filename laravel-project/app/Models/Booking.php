<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
		'room_id',
        'creator_id',
		'inTime',
		'outTime',
	];

    //СОздатель
    public function creator(): HasOne
    {
        return $this->hasOne(User::class,'id', 'creator_id');
    }

    //Участники встречи, что являются юзерами системы
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'usersList','booking_id','user_id');
    }

    public function room(): HasOne
    {
        return $this->hasOne(Room::class,'id', 'room_id');
    }

    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(Guest::class,'guestsList','booking_id','guest_id');
    }
}
