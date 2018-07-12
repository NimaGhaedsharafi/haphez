<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 6:50 PM
 */

namespace Tests\Unit;

use App\Services\MI6\CacheSecret;
use App\Services\MI6\Exceptions\InvalidArgument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheTest extends TestCase
{

    public function test_create_a_secret()
    {
        /** @var CacheSecret $service */
        $service = new CacheSecret();
        $publicId = $service->store('my secret', Carbon::tomorrow());

        $this->assertNotEmpty($publicId);
        $this->assertTrue(Cache::has($publicId));
    }

    public function test_get_a_secret()
    {
        /** @var CacheSecret $service */
        $service = new CacheSecret();
        $publicId = $service->store('my secret', Carbon::tomorrow());

        $this->assertEquals('my secret', $service->get($publicId));
    }

    public function test_empty_string_should_not_be_stored_and_throw_exception()
    {
        /** @var CacheSecret $service */
        $service = new CacheSecret();

        $this->expectException(InvalidArgument::class);
        $service->store('', Carbon::tomorrow());
    }

    public function test_passed_time_can_not_be_set_as_expiration_date()
    {
        /** @var CacheSecret $service */
        $service = new CacheSecret();

        $this->expectException(InvalidArgument::class);
        $service->store('secret', Carbon::yesterday());
    }
}