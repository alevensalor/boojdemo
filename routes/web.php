<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Tag;
use App\Book;
use App\Author;

Route::get('/', function () {

    $data = [];
    $data['tags'] = Tag::orderBy('txt', 'ASC')->get();
    $data['books'] = Book::with('authors')->get();
    $data['authors'] = Author::orderBy('name')->get();

    return view('welcome', $data);
});
