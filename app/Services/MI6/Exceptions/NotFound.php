<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 7:18 PM
 */

namespace App\Services\MI6\Exceptions;


/**
 * Class NotFound
 * @package App\Services\MI6\Exceptions
 */
class NotFound extends \RuntimeException
{
    protected $message = 'The secret not found or expired';
}