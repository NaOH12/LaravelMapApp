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
        'id', 'x', 'y', 'tile_id',
    ];

    // public function posts() {
    //     return $this->hasMany('App\Post');
    // }

    public function tile() {
        return $this->belongsTo('App\Tile');
    }

    public function artPosts() {
        return $this->hasMany('App\ArtPost');
    }

}
