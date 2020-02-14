<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function authors() {
        return $this->belongsToMany('App\\Author', 'author_book');
    }

    public function tags() {
        return $this->belongsToMany('App\\Tag', 'book_tag');
    }
}
