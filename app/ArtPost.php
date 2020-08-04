<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtPost extends Model
{

    protected $fillable = [
        'id', 'longitude', 'latitude', 'rotation', 'postable_id', 'postable_type', 'user_id', 'tile_id',
    ];
    
    public function postable(){
        return $this->morphTo();
    }

    public function artTile() {
        return $this->belongsTo('App\ArtTile');
    }

}
