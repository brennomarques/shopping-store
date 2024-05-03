<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Show the logged user information
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\User
     */
    public function show(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
