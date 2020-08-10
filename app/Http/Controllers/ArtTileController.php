<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ArtTile;
use App\ArtPost;

class ArtTileController extends Controller
{
    
    public function pull($request)
    {
        $tile_ids_array = array_map('intval', explode(",", $request));

        if (count($tile_ids_array) > 15) {
            return response(['success' => false, 
                'data' => []], 200);
        }
        
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
    }

    public function fetch($request)
    {

        $latest_post_ids = array_map('intval', explode(",", $request));
        if (count($latest_post_ids) > 15) {
            return response(['success' => false, 
                'data' => []], 200);
        }

        // dd($tile_ids_array);
        $posts = ArtPost::findMany($latest_post_ids);
        if (!$posts->isEmpty()) {
            return response(['success' => true, 
                'data' => $posts->map(function ($post) {
                    return [
                        'tile_id' => $post->artTile->id,
                        'posts' => $post->artTile->artPosts->where('id', '>', $post->id)->map->only(['id', 'longitude', 'latitude', 'rotation','postable']),
                    ];
                })], 200);
        } else {
            return response(['success' => false, 
                'data' => []], 200);
        }
    }

}
