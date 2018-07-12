<?php

namespace App\Http\Controllers;

use App\Secret;
use App\Services\MI6\SecretService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SecretController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        /** @var SecretService $service */
        $service = app(SecretService::class);
        $publicId = $service->store($request->input('message'), Carbon::now()->addDay($request->input('expires_in', 1)));

        return [
            'url' => $publicId
        ];
    }

    /**
     * @param $publicId
     * @return array
     */
    public function get($publicId)
    {
        $secret = Secret::where('public_id', trim($publicId))->first();

        if ($secret === null || $secret->expires_in->isPast()) {
            return response(['error' => 'secret not found or is expired'], 404);
        }

        // it should be set as deleted after read
        $secret->delete();

        return [
            'message' => $secret->message,
            'expires_in' => $secret->expires_in
        ];
    }
}
