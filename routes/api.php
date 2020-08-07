<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tiles/{tile_ids}/posts', 'TileController@show')->name('tiles.posts.show')->middleware('auth:api');
Route::get('/tiles/{tile_ids}/art_posts', 'ArtTileController@show')->name('tiles.art_posts.show')->middleware('auth:api');

Route::post('/posts', 'PostController@store')->name('posts.store')->middleware('auth:api');
Route::post('/art_posts/text_posts', 'ArtPostController@textStore')->name('art_posts.text_posts.store')->middleware('auth:api');

// Route::get('/posts/{post_id}', 'PostController@show')->name('posts.show')->middleware('auth:api');

Route::post('/login', 'API\AuthController@login')->name('auth.login');
Route::post('/register', 'API\AuthController@register')->name('auth.register');