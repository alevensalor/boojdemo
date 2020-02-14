<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $hidden = ['pivot'];


    public function books() {
        return $this->belongsToMany('App\\Book', 'book_tag');
    }
}
