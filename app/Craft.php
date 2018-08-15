<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Craft extends Model
{
    protected $fillable = ['name', 'description', 'image_url', 'author_id'];
    protected $appends = array('user_id');

    public function author() {
        return $this->hasOne('App\User', 'id', 'author_id');
    }

    public function getUserIdAttribute()
    {
        return $this['author_id'];
    }
}
