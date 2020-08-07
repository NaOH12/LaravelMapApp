<?php

namespace App\Http\Controllers;

use App\Tile;
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
    public function show($tile_ids)
    {
        $tile_ids_array = array_map('intval', explode(",", $tile_ids));
        // dd($tile_ids_array);
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
        // $tile = Tile::find($tile_id);
        // if ($tile != null) {
        //     return response(['success' => true, 'message' => 'Retrieved successfully', 
        //         'data' => $tile->posts->map->only(['id', 'post_content', 'longitude', 'latitude'])], 200);
        // } else {
        //     return response(['success' => false, 'message' => 'No tile exists.', 
        //         'data' => []], 200);
        // }
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
