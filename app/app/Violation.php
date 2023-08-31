<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    protected $fillable = [
        'post_id','text',
    ];

        public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
