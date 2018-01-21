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
        $secret->public_id = str_random(16);
        $secret->save();

        return [
            'url' => $secret->public_id
        ];
    }

    /**
     * @param $publicId
     * @return array
     */
    public function get($publicId)
    {
        $secret = Secret::where('public_id', trim($publicId))->first();

        if ($secret->expires_in->isPast()) {
            return response(['error' => 'secret not found or is expired'], 404);
        }

        return [
            'message' => $secret->message,
            'expires_in' => $secret->expires_in
        ];
    }
}
