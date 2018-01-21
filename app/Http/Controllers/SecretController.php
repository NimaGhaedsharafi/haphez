<?php

namespace App\Http\Controllers;

use App\Secret;
use Illuminate\Http\Request;

class SecretController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        $secret = new Secret();
        $secret->message = $request->input('message');
        $secret->public_id = 'random';
        $secret->save();

        return [
            'url' => $secret->public_id
        ];
    }
}
