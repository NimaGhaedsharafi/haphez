<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 6:50 PM
 */

namespace Tests\Unit;

use App\Services\MI6\CacheSecret;
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
}