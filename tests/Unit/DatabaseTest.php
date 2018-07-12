<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 6:50 PM
 */

namespace Tests\Unit;


use App\Secret;
use App\Services\MI6\DatabaseSecret;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Services\MI6\Exceptions\NotFound;

class DatabaseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_a_secret()
    {
        /** @var DatabaseSecret $service */
        $service = new DatabaseSecret();
        $publicId = $service->store('my secret', Carbon::tomorrow());

        $this->assertNotEmpty($publicId);
        $this->assertDatabaseHas((new Secret())->getTable(), ['public_id' => $publicId]);
    }

    /**
     * @throws \Exception
     */
    public function test_get_a_secret()
    {
        /** @var DatabaseSecret $service */
        $service = new DatabaseSecret();
        $publicId = $service->store('my secret', Carbon::tomorrow());

        $this->assertNotEmpty($publicId);

        $this->assertEquals('my secret', $service->get($publicId));
    }

    /**
     * @throws \Exception
     */
    public function test_get_an_expired_secret_should_throw_exception()
    {
        /** @var DatabaseSecret $service */
        $service = new DatabaseSecret();
        $publicId = $service->store('my secret', Carbon::now()->subDay());

        $this->assertNotEmpty($publicId);
        $this->expectException(NotFound::class);
        $service->get($publicId);
    }

    /**
     * @throws \Exception
     */
    public function test_get_a_random_secret_should_throw_exception()
    {
        /** @var DatabaseSecret $service */
        $service = new DatabaseSecret();
        $this->expectException(NotFound::class);
        $service->get('gibberish');
    }


    /**
     * @throws \Exception
     */
    public function test_it_is_available_just_once()
    {
        /** @var DatabaseSecret $service */
        $service = new DatabaseSecret();

        // let's store and get it together
        $service->get($publicId = $service->store('my secret', Carbon::tomorrow()));

        $this->expectException(NotFound::class);
        $service->get($publicId);
    }

    /**
     * @throws \Exception
     */
    public function test_keep_secrets_log_if_it_is_needed()
    {
        // set keep logs true
        config(['secret.keep_logs' => true]);

        /** @var DatabaseSecret $service */
        $service = new DatabaseSecret();

        // let's store and get it together
        $service->get($publicId = $service->store('my secret', Carbon::tomorrow()));

        // but it should be at the database and delete_at should not be null
        $secret = Secret::withTrashed()->where('public_id', $publicId)->first();
        $this->assertNotNull($secret);
        $this->assertNotNull($secret->deleted_at);
    }
}