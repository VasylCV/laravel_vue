<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Requests\API\Auth\ForgotPasswordAPIRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AppBaseController;
use Response;

class ForgotPasswordAPIController extends AppBaseController
{
    /**
     * @param ForgotPasswordAPIRequest $request
     * @return mixed
     */
    public function __invoke(ForgotPasswordAPIRequest $request)
    {
        Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $this->sendResponse([true], __('passwords.sent'));
    }
}
