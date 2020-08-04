<?php

namespace App\Http\Controllers;

use App\ArtPost;
use App\Tile;
use App\ArtTile;
use App\MapApp;
use App\TextArtPost;
use Illuminate\Http\Request;

class ArtPostController extends Controller
{

    public function textStore(Request $request)
    {

        $validateData = $request->validate([
            'text_content' => 'required|max:140',
            'longitude' => 'required|numeric|min:-180|max:180',
            'latitude' => 'required|numeric|min:-85|max:85',
            'rotation' => 'required|numeric|min:0|max:360',
            'colour' => 'required|numeric|min:0|max:4294967295',
            'font' => 'required|numeric|min:0|max:255',
            'size' => 'required|numeric|min:5|max:20',
        ]);

        $art_tile_id = Self::createMissingTiles($validateData['longitude'], $validateData['latitude']);
       

        // $tile = Tile::firstOrCreate([
        //     'id' => $tile_id
        // ], [
        //     'id' => $tile_id,
        //     'x' => $tile_x,
        //     'y' => $tile_y,
        //     'z' => $zoom_level
        // ]);

        // $post = new Post;
        // $post->post_content = $validateData['post_content'];
        // $post->longitude = $validateData['longitude'];
        // $post->latitude = $validateData['latitude'];
        // $post->tile_id = $tile_id;
        // $post->user_id = $request->user('api')->id;
        // $post->save();
        $text_post = new TextArtPost;
        $text_post->text_content = $validateData['text_content'];
        $text_post->colour = $validateData['colour'];
        $text_post->font = $validateData['font'];
        $text_post->size = $validateData['size'];
        $text_post->save();

        // Create parent post
        $post = new ArtPost;
        $post->art_tile_id = $art_tile_id;
        $post->longitude = $validateData['longitude'];
        $post->latitude = $validateData['latitude'];
        $post->rotation = $validateData['rotation'];
        $post->postable_id = 0;
        $post->postable_type = "";
        $post->user_id = $request->user('api')->id;
        $post->save();

        // Attach child to parent
        $text_post->post()->save($post);

        return response(['success' => true, 'message' => 'Post successful', 
            'data' => $post->id], 200);

    }

    /**
     * Create art post's art tile and parent tile if missing.
     * Returns the art tiles id.
     *
     * @param  double  $long
     * @param  double  $lat
     * @return int $id
     * 
     */
    private function createMissingTiles($long, $lat) {

        $post_zoom_level = MapApp::POST_ZOOM_LEVEL;
        $stamp_zoom_level = MapApp::STAMP_ZOOM_LEVEL;

        $tile_x = floor((($long + 180) / 360) * pow(2, $stamp_zoom_level));
        $tile_y = floor((1 - log(tan(deg2rad($lat)) + 1 / cos(deg2rad($lat))) / pi()) /2 * pow(2, $stamp_zoom_level));
        $tile_id = (pow(2, $stamp_zoom_level) * $tile_y) + $tile_x + 1;

        // dd([(pow(2,$zoom_level)), $long,$lat, $tile_x, $tile_y, $tile_id]);

        $art_tile = ArtTile::where('id', '=', $tile_id)->first();
        
        // If the art post's art tile does not exist, then create the art tile.
        if ($art_tile == null) {

            // Gather information about the art tiles parent tile.
            $parent_tile_x = floor((($long + 180) / 360) * pow(2, $post_zoom_level));
            $parent_tile_y = floor((1 - log(tan(deg2rad($lat)) + 1 / cos(deg2rad($lat))) / pi()) /2 * pow(2, $post_zoom_level));
            $parent_tile_id = (pow(2, $post_zoom_level) * $tile_y) + $tile_x + 1;

            $parent_tile = Tile::where('id', '=', $parent_tile_id)->first();

            // dd($parent_tile);

            // If parent tile doesnt exist then create one.
            if ($parent_tile == null) {
                
                $parent_tile = new Tile;
                $parent_tile->id = $parent_tile_id;
                $parent_tile->x = $parent_tile_x;
                $parent_tile->y = $parent_tile_y;
                $parent_tile->save();

            }

            // Create art tile.
            $art_tile = new ArtTile;
            $art_tile->id = $tile_id;
            $art_tile->x = $tile_x;
            $art_tile->y = $tile_y;
            $art_tile->tile_id = $parent_tile_id;
            $art_tile->save();
        }

        return $art_tile->id;

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

}
