<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\RegisterValidator;
use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegisterController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param RegisterValidator $request
     * @return JsonResponse
     */
    public function store(RegisterValidator $request): JsonResponse
    {

        $input = $request->all();
        $response = User::create(
            [
                'name' => $input['name'],
                'email' => $input['email'],
                'password'  => bcrypt($input['password']),
            ]
        );

        Log::info('User register successfully' . __METHOD__);
        Mail::to($response->email)->send(new Welcome($response));

        return $this->sendResponse('User register successfully.', Response::HTTP_OK);
    }
}
