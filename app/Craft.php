<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Craft extends Model
{
    public function author() {
        return $this->hasOne('App\User', 'id', 'author_id');
    }
}
