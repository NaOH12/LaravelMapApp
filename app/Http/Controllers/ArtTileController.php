<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ArtTile;

class ArtTileController extends Controller
{
    
    public function show($tile_ids)
    {
        $tile_ids_array = array_map('intval', explode(",", $tile_ids));
        // dd($tile_ids_array);
        $tiles = ArtTile::findMany($tile_ids_array);
        if (!$tiles->isEmpty()) {
            return response(['success' => true, 
                'data' => $tiles->map(function ($tile) {
                    return [
                        'tile_id' => $tile->id,
                        'posts' => $tile->artPosts->map->only(['id', 'longitude', 'latitude', 'rotation','postable']),
                    ];
                })], 200);
        } else {
            return response(['success' => false, 
                'data' => []], 200);
        }
        // $tile = ArtTile::find($tile_id);
        // if ($tile != null) {
        //     return response(['success' => true, 'message' => 'Retrieved successfully', 
        //         'data' => $tile->artPosts->map->only(['id', 'longitude', 'latitude', 'rotation','postable'])], 200);
        // } else {
        //     return response(['success' => false, 'message' => 'No tile exists.', 
        //         'data' => []], 200);
        // }
    }

}
