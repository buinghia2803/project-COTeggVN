<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'm_type_id',
        'price',
        'description'
    ];

    /**
     * Const status
     */
    const STATUS_AVAILABLE = 1;
    const STATUS_NOT_AVAILABLE = 2;

    /**
     * Relation of room with user.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Relation of room with m_type.
     */
    public function mType()
    {
        return $this->hasOne(MType::class, 'id', 'm_type_id');
    }

    /**
     * Relation of room with m_type.
     */
    public function roomUsers()
    {
        return $this->hasMany(RoomUser::class);
    }
}
