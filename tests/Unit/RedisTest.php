<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 6:50 PM
 */

namespace Tests\Unit;


use App\Secret;
use App\Services\MI6\RedisSecret;
use Carbon\Carbon;
use Tests\TestCase;
use App\Services\MI6\Exceptions\NotFound;
use App\Services\MI6\Exceptions\InvalidArgument;

class RedisTest extends TestCase
{

    public function test_create_a_secret()
    {
        /** @var RedisSecret $service */
        $service = new RedisSecret();
        $publicId = $service->store('my secret', Carbon::tomorrow());

        $this->assertNotEmpty($publicId);
    }
}