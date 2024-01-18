<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'checkin_date',
        'checkout_date',
        'price',
        'status'
    ];

    /**
     * Const status
     */
    const STATUS_APPROVE = 1;
    const STATUS_REJECT = 2;

    /**
     * Relation of room user with user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation of room user with room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
