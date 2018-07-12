<?php

namespace Tests\Feature;

use App\Secret;
use Carbon\Carbon;
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
    public function get_secret_should_work_fine()
    {
        factory(Secret::class)->create();

        $this->json('GET', route('secret.get', 'secret'))
        ->assertStatus(200)
        ->assertJsonStructure([
            'message'
        ]);
    }

    /**
     * @test
     */
    public function get_expired_secret_should_not_found()
    {
        factory(Secret::class)->states('expired')->create();

        $this->json('GET', route('secret.get', 'secret'))
            ->assertStatus(404);
    }

    /**
     * @test
     */
    public function invalid_public_id_respond_as_not_found()
    {
        $this->json('GET', route('secret.get', 'secret'))
            ->assertStatus(404);
    }
}
