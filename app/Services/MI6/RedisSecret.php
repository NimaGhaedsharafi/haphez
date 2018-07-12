<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 11:39 PM
 */

namespace App\Services\MI6;


use Carbon\Carbon;

class RedisSecret implements SecretService
{

    /**
     * @param string $message
     * @param Carbon $expiresIn
     * @return string PublicId
     */
    public function store(string $message, Carbon $expiresIn): string
    {
        // TODO: Implement store() method.
    }

    /**
     * @param string $publicId
     * @return string Message
     */
    public function get(string $publicId): string
    {
        // TODO: Implement get() method.
    }
}