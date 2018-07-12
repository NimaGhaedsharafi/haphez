<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 6:47 PM
 */

namespace App\Services\MI6;


use App\Secret;
use App\Services\MI6\Exceptions\NotFound;
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
    public function store(string $message, Carbon $expiresIn) : string 
    {
        if (strlen($message) == 0) {
            throw new InvalidArgument();
        }
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
     * @throws \Exception
     */
    public function get(string $publicId) : string
    {
        /** @var Secret $secret */
        $secret = Secret::where('public_id', trim($publicId))->first();

        if ($secret === null || $secret->expires_in->isPast()) {
            throw new NotFound();
        }

        // it should be delete after view!
        if (config('secret.keep_logs')) {
            $secret->delete();
        } else {
            $secret->forceDelete();
        }

        return $secret->message;
    }
}