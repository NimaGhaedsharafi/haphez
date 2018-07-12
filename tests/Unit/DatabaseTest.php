<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 6:50 PM
 */

namespace Tests\Unit;


use App\Services\MI6\DatabaseSecret;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    public function test_create_a_secret()
    {
        $service = new DatabaseSecret();
    }
}