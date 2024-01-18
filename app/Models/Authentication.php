<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "user_id",
        "type",
        "token",
        "created_at",
    ];

    const TYPE_REGISTER = 1;
    const TYPE_FORGOT_PASSWORD = 2;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Check Expired Time for authentication
     *
     * @param $authentication
     * @return boolean
     */
    public function hasExpiredTime(): bool
    {
        // Check time around 30 minute
        $time = strtotime(date('Y-m-d H:i:s'));
        $createdAt = strtotime($this->created_at);
        if ($time - $createdAt >= 60 * 30) {
            return true;
        }

        return false;
    }
}
