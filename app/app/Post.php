<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id','title', 'image', 'episode','path','create_at',
      ];

      public function comment()
{
    return $this->belongsTo('App\Comment');
}
public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
    public function violations()
    {
        return $this->hasMany('App\Violation');
    }

}
