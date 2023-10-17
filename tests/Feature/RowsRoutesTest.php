<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RowsRoutesTest extends TestCase
{
    use DatabaseTransactions;

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

    public function test_is_post_rows_auth_checks_real_user()
    {
        $testUsername = 'test@auth.com';
        $testPassword = 'testauth';

        User::factory()->create([
            'name' => 'Test Auth',
            'email' => $testUsername,
            'password' => Hash::make($testPassword),
        ]);

        $response = $this
            ->withBasicAuth($testUsername, "WRONG_PASSWORD")
            ->postJson('api/rows/parse');

        $response->assertUnauthorized();
    }

    public function test_is_post_rows_has_validation()
    {
        $testUsername = 'test@auth.com';
        $testPassword = 'testauth';

        User::factory()->create([
            'name' => 'Test Auth',
            'email' => $testUsername,
            'password' => Hash::make($testPassword),
        ]);

        $response = $this
            ->withBasicAuth($testUsername, $testPassword)
            ->postJson('api/rows/parse');

        $response->assertUnprocessable();
    }
}
