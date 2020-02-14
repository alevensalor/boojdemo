<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tag;
use App\Book;

class TagController extends Controller
{

    // This returns all of the books linked to this tag id.
    public function detail(Request $request, $id) {
        // When we load the books for the tag, load the authors too. No need to make things
        // more complicated with a loop here.
        $tag = Tag::where(['id' => $id])->with(['books', 'books.authors'])->first();

        // If there is no tag with this id, just load all the books.
        if (!$tag) {
            $books = Book::with(['authors'])->get();
            return response()->json(['books' => $books]);
        } else {
            return $tag->toJSON();
        }
    }

    public function all(Request $request) {
        $tags = Tag::select();

        $sort = $request->input('sort');
        if($sort) {
            $tags->orderBy('txt', $sort);
        }
        return $tags->get()->toJSON();
    }

}
