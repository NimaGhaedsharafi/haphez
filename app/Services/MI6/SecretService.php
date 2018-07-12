<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 6:40 PM
 */

namespace App\Services\MI6;

use Carbon\Carbon;

interface SecretService
{
    /**
     * @param string $message
     * @param Carbon $expiresIn
     * @return string PublicId
     */
    public function store(string $message, Carbon $expiresIn);
}