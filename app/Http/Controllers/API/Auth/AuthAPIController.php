<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Requests\API\Auth\RegistrationAPIRequest;
use App\Http\Requests\API\Auth\AuthAPIRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use Response;

class AuthAPIController extends AppBaseController
{
    /**
     * @param AuthAPIRequest $authRequest
     * @return Response
     */
    public function login(AuthAPIRequest $authRequest): mixed
    {
        $attr = $authRequest->validate($authRequest->rules());

        if (!Auth::attempt($attr)) {
            return $this->sendError(__('auth.failed'), 401);
        }

        return $this->sendResponse([
            'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ], __('app.login'));
    }

    /**
     * @return mixed
     */
    public function logout(): mixed
    {
        auth()->user()->tokens()->delete();

        return $this->sendResponse([], __('auth.logout'));
    }
}
