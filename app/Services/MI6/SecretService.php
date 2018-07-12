<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 6:40 PM
 */

namespace App\Services\MI6;

use Carbon\Carbon;

/**
 * Interface SecretService
 * @package App\Services\MI6
 * This service keeps message storage abstract in controller
 */
interface SecretService
{
    /**
     * @param string $message
     * @param Carbon $expiresIn
     * @return string PublicId
     */
    public function store(string $message, Carbon $expiresIn);


    /**
     * @param string $publicId
     * @return string Message
     */
    public function get(string $publicId);
}