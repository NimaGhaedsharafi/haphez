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
            'message'
        ]);
    }

    /**
     * @test
     */
    public function get_expired_secret_should_not_found()
    {
        factory(Secret::class)->states('expired')->create();

        $response = $this->json('GET', route('secret.get', 'secret'));
        $response->assertStatus(404);

        $response->assertJsonStructure([
            'error'
        ]);
    }

    /**
     * @test
     */
    public function invalid_public_id_respond_as_not_found()
    {
        $response = $this->json('GET', route('secret.get', 'secret'));
        $response->assertStatus(404);

        $response->assertJsonStructure([
            'error'
        ]);
    }

    /**
     * @test
     */
    public function get_secret_should_set_delete_the_secret_after_read()
    {
        factory(Secret::class)->create();

        $response = $this->json('GET', route('secret.get', 'secret'));
        $response->assertStatus(200);

        $this->assertNull(Secret::where('public_id', 'secret')->first());
    }

    /**
     * @test
     */
    public function set_expires_in_should_be_set()
    {
        $data = [
            'message' => 'something-sort-of-secret',
            'expires_in' => 1,
        ];

        $response = $this->json('POST', route('secret.store'), $data);
        $response->assertStatus(200);

        /** @var Secret $secret */
        $secret = Secret::first();

        $this->assertEquals(0, Carbon::now()->addDay()->diffInSeconds($secret->expires_in));
    }
}
