<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    public $timestamps = false;

    function user() {
        return $this->belongsTo("App\User");
    }
}