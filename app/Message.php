<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    /**
     * Mass-assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'content', 'user_id'
    ];

    /**
     * Get the user the message belongs to
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
