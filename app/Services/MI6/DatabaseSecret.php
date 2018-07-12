<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 6:47 PM
 */

namespace App\Services\MI6;


use App\Secret;
use Carbon\Carbon;

/**
 * Class DatabaseSecret
 * @package App\Services\MI6
 * This class stores secrets in database
 */
class DatabaseSecret implements SecretService
{

    /**
     * @param string $message
     * @param Carbon $expiresIn
     * @return string PublicId
     */
    public function store(string $message, Carbon $expiresIn)
    {
        $secret = new Secret();
        $secret->message = $message;
        $secret->expires_in = $expiresIn;
        $secret->public_id = str_random(16);
        $secret->save();

        return $secret->public_id;
    }

    /**
     * @param string $publicId
     * @return string Message
     */
    public function get(string $publicId)
    {
        $secret = Secret::where('public_id', trim($publicId))->first();

        return $secret->message;
    }
}