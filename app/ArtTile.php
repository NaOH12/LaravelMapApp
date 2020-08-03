<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtTile extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'x', 'y', 'parent_tile_id',
    ];

    // public function posts() {
    //     return $this->hasMany('App\Post');
    // }

    public function parentTile() {
        return $this->hasOne('App\Tile');
    }

}
