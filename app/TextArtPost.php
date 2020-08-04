<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ArtPost;

class TextArtPost extends ArtPost
{    
    public $timestamps = false;
    
    public function post(){
        return $this->morphOne('App\ArtPost', 'postable');
    }
    
}
