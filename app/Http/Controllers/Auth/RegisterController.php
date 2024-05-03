<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\RegisterValidator;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
        $input['password'] = bcrypt($input['password']);
        User::create($input);

        Log::info('User register successfully' . __METHOD__);

        return $this->sendResponse('User register successfully.', Response::HTTP_OK);
    }
}
