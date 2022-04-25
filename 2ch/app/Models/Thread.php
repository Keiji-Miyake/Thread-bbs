<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'threads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'is_user_checked', 'latest_comment_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
