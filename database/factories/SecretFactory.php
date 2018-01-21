<?php

use App\Secret;
use Carbon\Carbon;

$factory->define(Secret::class, function () {
    return [
        'public_id' => 'secret',
        'message' => 'this-is-a-secret',
        'expires_in' => Carbon::now()->addDay()
    ];
});