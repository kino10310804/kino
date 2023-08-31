<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_id','post_id', 
      ];

      public function user()
    {   
        return $this->belongsTo('App\User');
    }
    public function post()
    {   
        return $this->belongsTo('App\Post');
    }
    public function like_exist($user_id, $post_id) {        
      return Like::where('user_id', $user_id)->where('post_id', $post_id)->exists();       
      }

}
