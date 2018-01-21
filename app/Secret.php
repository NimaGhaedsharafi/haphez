<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Secret
 * @package App
 */
class Secret extends Model
{
    use SoftDeletes;

    protected $dates = [
        'expires_in'
    ];
}
