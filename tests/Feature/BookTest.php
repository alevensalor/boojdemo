<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /*
     * Fetch all books
     */
    public function testGetAllRaw() {
        $response = $this->get('/books');
        $response->assertStatus(200);
    }

    /* Exercise the 'search' option in the books API */
    public function searchBooks() {
        $response = $this->get('/books?search=foo');
        $response->assertStatus(200);
    }
}
