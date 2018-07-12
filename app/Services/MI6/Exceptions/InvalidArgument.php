<?php
/**
 * Created by PhpStorm.
 * User: nghaedsharafi
 * Date: 7/12/18
 * Time: 9:50 PM
 */

namespace App\Services\MI6\Exceptions;


/**
 * Class InvalidArgument
 * @package App\Services\MI6\Exceptions
 */
class InvalidArgument extends \RuntimeException
{
    protected $message = 'The %s argument is invalid';

    /**
     * InvalidArgument constructor.
     */
    public function __construct($type)
    {
        $this->message = sprintf($this->message, $type);
    }
}