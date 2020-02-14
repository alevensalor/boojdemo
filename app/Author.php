<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Author extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $hidden = ['pivot'];


    public function books() {
        return $this->belongsToMany('App\\Book', 'author_book');
    }
}
