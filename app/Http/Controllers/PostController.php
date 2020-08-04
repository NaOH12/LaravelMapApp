<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tile;
use App\MapApp;
use Illuminate\Http\Request;

class PostController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'post_content' => 'required|max:140',
            'longitude' => 'required|numeric|min:-180|max:180',
            'latitude' => 'required|numeric|min:-85|max:85',
        ]);

        $zoom_level = MapApp::POST_ZOOM_LEVEL;//$zoom_level = 16;
        $long = floatval($validateData['longitude']);
        $lat = floatval($validateData['latitude']);
        $tile_x = floor((($long + 180) / 360) * pow(2, $zoom_level));
        $tile_y = floor((1 - log(tan(deg2rad($lat)) + 1 / cos(deg2rad($lat))) / pi()) /2 * pow(2, $zoom_level));
        
        $tile_id = (pow(2, $zoom_level) * $tile_y) + $tile_x + 1;
        // dd([(pow(2,$zoom_level)), $long,$lat, $tile_x, $tile_y, $tile_id]);

        $tile = Tile::firstOrCreate([
            'id' => $tile_id
        ], [
            'id' => $tile_id,
            'x' => $tile_x,
            'y' => $tile_y,
        ]);

        $post = new Post;
        $post->post_content = $validateData['post_content'];
        $post->longitude = $validateData['longitude'];
        $post->latitude = $validateData['latitude'];
        $post->tile_id = $tile_id;
        $post->user_id = $request->user('api')->id;
        $post->save();

        return response(['success' => true, 'message' => 'Post successful', 
            'data' => $post->id], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);

        return response(['success' => true, 'message' => 'Retrieved successfully', 
            'data' => $post], 200);
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
