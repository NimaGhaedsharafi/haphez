<?php

namespace Tests\Feature;

use App\Secret;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecretTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     */
    public function store_secret_should_work_fine()
    {
        $this->disableExceptionHandler();
        
        $data = [
            'message' => 'something-sort-of-secret'
        ];

        $response = $this->json('POST', route('secret.store'), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas((new Secret())->getTable(), $data);

        $response->assertJsonStructure([
            'url'
        ]);
    }

    /**
     * @test
     */
    public function store_should_not_work_on_empty_message()
    {
        $data = [
            'message' => ''
        ];

        $response = $this->json('POST', route('secret.store'), $data);
        $response->assertStatus(422);

        $this->assertDatabaseMissing((new Secret())->getTable(), $data);
    }

    /**
     * @test
     */
    public function store_secret_should_set_public_id()
    {
        $this->disableExceptionHandler();

        $data = [
            'message' => 'something-sort-of-secret'
        ];

        $response = $this->json('POST', route('secret.store'), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas((new Secret())->getTable(), $data);

        $secret = Secret::first();
        $this->assertNotEquals('', $secret->public_id);
    }

    /**
     * @test
     */
    public function get_secret_should_work_fine()
    {
        factory(Secret::class)->create();

        $response = $this->json('GET', route('secret.get', 'secret'));
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message', 'expires_in'
        ]);
    }
}
