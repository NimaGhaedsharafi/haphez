<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 11:39 PM
 */

namespace App\Services\MI6;


use App\Services\MI6\Exceptions\InvalidArgument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class CacheSecret implements SecretService
{

    /**
     * @param string $message
     * @param Carbon $expiresIn
     * @return string PublicId
     */
    public function store(string $message, Carbon $expiresIn): string
    {
        if (strlen($message) == 0) {
            throw new InvalidArgument('message');
        }

        if ($expiresIn->isPast()) {
            throw new InvalidArgument('expiration');
        }

        $publicId = str_random(16);
        Cache::put($publicId, $message, $expiresIn->diffInMinutes(Carbon::now()));

        return $publicId;
    }

    /**
     * @param string $publicId
     * @return string Message
     */
    public function get(string $publicId): string
    {
        return Cache::get($publicId, null);
    }
}