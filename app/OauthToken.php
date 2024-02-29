<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthToken extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function hasExpired()
    {
         return now()->timestamp > $this->expires_in;
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
