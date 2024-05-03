<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     * @param LoginValidator $request
     * @return JsonResponse
     */
    public function store(LoginValidator $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $token = [
                'access_token' => $request->user()->createToken('token')->plainTextToken,
            ];
            return $this->sendResponse($token, Response::HTTP_OK);
        }

        return $this->sendError(['error' => 'Unauthorised'], Response::HTTP_NOT_FOUND);
    }
}
