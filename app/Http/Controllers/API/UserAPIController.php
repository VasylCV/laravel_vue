<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\User\UpdateUserAPIRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * @return mixed
     */
    public function getUser(): mixed
    {
        if(auth("sanctum")->check()){

            return $this->sendResponse(auth("sanctum")->user(), __('app.data'));
        }

        return $this->sendError(__('app.error.noFound'));
    }

    /**
     * @param UpdateUserAPIRequest $request
     * @return mixed
     */
    public function update(UpdateUserAPIRequest $request): mixed
    {
        $input = $request->all();

        $user = $request->user();

        if (!$user) {
            return $this->sendError(__('auth.error'), 401);
        }
        /** @var User $user */
        $user = $this->userRepository->find($user->id);

        if (empty($user)) {
            return $this->sendError(__('app.error.noFound'));
        }

        $user = $this->userRepository->update($input, $user->id);

        return $this->sendResponse($user->toArray(), __('app.updated'));
    }
}
