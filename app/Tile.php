<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tile extends Model
{
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'x', 'y',
    ];

    public function posts() {
        return $this->hasMany('App\Post');
    }
    
    public function artTiles() {
        return $this->hasMany('App\ArtTile');
    }

}
