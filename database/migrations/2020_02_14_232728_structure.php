<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Structure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title', 100);
        });

        Schema::create('authors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name', 100);
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('txt', 20);
        });

        Schema::create('author_book', function (Blueprint $table) {
            $table->bigInteger('book_id');
            $table->bigInteger('author_id');
        });

        Schema::create('book_tag', function (Blueprint $table) {
            $table->bigInteger('book_id');
            $table->bigInteger('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('author_book');
        Schema::dropIfExists('book_tag');
    }
}
