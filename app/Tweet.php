<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'content', 'publishDate', 'tweet_id', 'sent', 'user_id'];

    function user() {
        return $this->belongsTo("App\User");
    }
}