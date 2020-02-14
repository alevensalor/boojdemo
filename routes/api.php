<?php

use Illuminate\Http\Request;

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



/*
 * Book routes:
 */
Route::get('/books', "BookController@all");
Route::get('/books/{id}', "BookController@detail");
Route::post('/books', "BookController@add");
Route::put('/books/{id}', "BookController@update");
Route::delete('/books/{id}', "BookController@delete");

/*
 * Author params
 */
Route::get('/authors', "AuthorController@all");
Route::get('/authors/{id}', "AuthorController@detail");
Route::post('/authors', "AuthorController@add");
Route::put('/authors', "AuthorController@update");
Route::delete('/authors/{id}', "AuthorController@delete");


/*
 * Tag routes
 */
Route::get('/tags/{id}', "TagController@detail");
Route::get('/tags', "TagController@all");
