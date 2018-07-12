<?php

namespace Tests\Feature;

use App\Secret;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

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

        $response->assertJsonStructure([
            'url'
        ]);
    }

    /**
     * @test
     */
    public function get_secret_should_work_fine()
    {
        $response = json_decode($this->json('POST', route('secret.store'), ['message' => 'something-sort-of-secret'])
            ->assertStatus(200)->getContent());

        $this->json('GET', route('secret.get', $response->url))
            ->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function get_expired_secret_should_not_be_found()
    {
        $response = json_decode($this->json('POST', route('secret.store'), ['message' => 'something-sort-of-secret'])
            ->assertStatus(200)->getContent());
        // 2 days later
        Carbon::setTestNow(Carbon::now()->addDays(2));

        $this->json('GET', route('secret.get', $response->url))
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
