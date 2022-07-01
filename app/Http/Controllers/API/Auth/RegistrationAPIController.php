<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Requests\API\Auth\RegistrationAPIRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Response;

class RegistrationAPIController extends AppBaseController
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

        event(new Registered($createUser));

        auth()->login($createUser);

        return $this->sendResponse([
            'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ], __('auth.login'));
    }
}
