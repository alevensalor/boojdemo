<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Author;
use App\Book;

class AuthorController extends Controller
{

    public function all(Request $request) {
        $sort = $request->input('sort');
        $search = $request->input('search');

        $authors = Author::select();

        if ($sort) {
            $authors->orderBy('name', $sort);
        }

        if ($search) {
            $authors->where('name', 'like', '%'.$search.'%');
        }

        return $authors->get()->toJSON();
    }

    public function detail(Request $request, $id) {
        return Author::find($id)->with('books')->toJSON();
    }

    public function update(Request $request, $id) {
        $author = Author::find($id);
        $author->update(['name' => $request->input('name')]);
        return $author->toJSON();
    }


    public function add(Request $request) {
        $name = $request->input('name');

        $author = new Author();
        $author->name = $name;
        $author->save();

        return $author->toJSON();
    }

    public function delete(Request $request, $id) {
        Author::find($id)->delete();
        return response()->json(["message" => "Author $id deleted."]);
    }

}
