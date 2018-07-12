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
        /** @var SecretService $service */
        $service = app(SecretService::class);

        
        $message = $service->get(trim($publicId));
        return [
            'message' => $message,
        ];
    }
}
