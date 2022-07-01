<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Requests\API\Auth\ResetPasswordAPIRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Str;
use Response;

class ResetPasswordAPIController extends AppBaseController
{
    /**
     * @param ResetPasswordAPIRequest $request
     * @return mixed
     */
    public function __invoke(ResetPasswordAPIRequest $request)
    {
        Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $this->sendResponse([true], __('passwords.reset'));
    }
}
