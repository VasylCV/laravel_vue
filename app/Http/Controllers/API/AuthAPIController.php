<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Auth\RegistrationAPIRequest;
use App\Http\Requests\API\Auth\AuthAPIRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use Response;

class AuthAPIController extends AppBaseController
{
    /** @var UserRepository  */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegistrationAPIRequest $authRequest
     * @return mixed
     */
    public function registration(RegistrationAPIRequest $registrationRequest): mixed
    {
        $param = $registrationRequest->all();

        if (isset($param['password'])) {
            $param['password'] = Hash::make($param['password']);
        }

        $createUser = $this->userRepository->create($param);

        if (!$createUser) {
            return $this->sendError(__('app.error.save'), 500);
        }

        auth()->login($createUser);

        return $this->sendResponse([
            'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ], __('auth.login'));
    }

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
