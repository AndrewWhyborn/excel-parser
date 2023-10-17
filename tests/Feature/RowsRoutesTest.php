<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RowsRoutesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_rows()
    {
        $response = $this->getJson('api/rows');

        $response->assertJsonStructure(["rows" => []]);
    }

    public function test_post_rows_need_auth()
    {
        $response = $this->postJson('api/rows/parse');

        $response->assertUnauthorized();
    }

    public function test_is_post_rows_has_validation()
    {
        $response = $this
            ->withBasicAuth("test@example.com", "testtest")
            ->postJson('api/rows/parse');

        $response->assertUnprocessable();
    }
}
