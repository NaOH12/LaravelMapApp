<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ArtTile;

class ArtTileController extends Controller
{
    
    public function show($tile_id)
    {
        // $tile = ArtTile::findOrFail($tile_id);
        $tile = ArtTile::find($tile_id);
        if ($tile != null) {
            return response(['success' => true, 'message' => 'Retrieved successfully', 
                'data' => $tile->artPosts->map->only(['id', 'longitude', 'latitude', 'rotation','postable'])], 200);
        } else {
            return response(['success' => false, 'message' => 'No tile exists.', 
                'data' => []], 200);
        }
    }

}
