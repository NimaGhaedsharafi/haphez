<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Secret
 * @package App
 * @property int $id
 * @property string $message
 * @property string $public_id
 * @property \Carbon\Carbon $expires_in
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Secret extends Model
{
    use SoftDeletes;

    protected $dates = [
        'expires_in'
    ];
}
