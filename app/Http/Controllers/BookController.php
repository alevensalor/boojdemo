<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Book;
use App\Author;
use App\Tag;

class BookController extends Controller
{

    public function all(Request $request) {
        $sort = $request->input('sort');
        $search = $request->input('search');

        $books = Book::select();

        if ($sort) {
            $books->orderBy('title', $sort);
        }

        if ($search) {
            $books->where('title', 'like', '%'.$search.'%');
        }

        return $books->with('authors')->get()->toJSON();
    }

    public function detail(Request $request, $id) {
        return Book::find($id)->with('authors')->toJSON();
    }

    public function add(Request $request) {
        $title = $request->input('title');

        $book = Book::firstOrCreate(['title' => $title]);

        $book->authors()->detach();
        $book->tags()->detach();

        $authors = $request->input('authors');
        if (!empty($authors)) {
            foreach ($authors as $author) {
                $author = Author::firstOrCreate(['name' => $author]);
                $book->authors()->attach($author->id);
            }
        }

        $tags = $request->input('tags');
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $tag = Tag::firstOrCreate(['txt' => $tag]);
                $book->tags()->attach($tag->id);
            }
        }


        $output = [
            'book' => $book->toArray(),
            'authors' => $book->authors->toArray(),
            'tags'    => $book->tags->toArray(),
        ];

        return response()->json($output);
    }


    public function update(Request $request, $id) {
        $book = Book::find($id);
        $title = $request->input('title');

        $book->title = $title;
        $book->save();

        $authors = $request->input('authors');
        if (!empty($authors)) {
            foreach ($authors as $author) {
                $author = Author::findOrCreate(['name' => $author]);
                $book->authors()->attach($author->id);
            }
        }


        return $book->toJSON();
    }

    public function delete($id) {
        Book::find($id)->delete();
        return response()->json(['status' => "Book $id Deleted"]);
    }

}
