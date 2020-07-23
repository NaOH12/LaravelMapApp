<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tile extends Model
{
    
    public $timestamps = false;

    public function posts() {
        return $this->hasMany('App\Post');
    }

}
