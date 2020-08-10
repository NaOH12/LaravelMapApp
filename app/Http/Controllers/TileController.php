<?php

namespace App\Http\Controllers;

use App\Tile;
use App\Post;
use Illuminate\Http\Request;

class TileController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pull($request)
    {
        $tile_ids_array = array_map('intval', explode(",", $request));

        if (count($tile_ids_array) > 15) {
            return response(['success' => false, 
                'data' => []], 200);
        }

        $tiles = Tile::findMany($tile_ids_array);
        if (!$tiles->isEmpty()) {
            return response(['success' => true, 
                'data' => $tiles->map(function ($tile) {
                    return [
                        'tile_id' => $tile->id,
                        'posts' => $tile->posts->map->only(['id', 'post_content', 'longitude', 'latitude']),
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

        $posts = Post::findMany($latest_post_ids);
        if (!$posts->isEmpty()) {
            return response(['success' => true, 
                'data' => $posts->map(function ($post) {
                    return [
                        'tile_id' => $post->tile->id,
                        'posts' => $post->tile->posts->where('id', '>', $post->id)->map->only(['id', 'post_content', 'longitude', 'latitude']),
                    ];
                })], 200);
        } else {
            return response(['success' => false, 
                'data' => []], 200);
        }
    }

}