<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Auth\VerificationAPIRequest;
use App\Http\Requests\API\Auth\VerificationResendAPIRequest;
use App\Models\User;
use Response;

class VerificationAPIController extends AppBaseController
{
    /**
     * @param VerificationAPIRequest $request
     * @return mixed
     */
    public function verify(VerificationAPIRequest $request)
    {
        $user = User::findOrFail($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return $this->sendError(__('verified.already'));
        }

        if (!hash_equals((string) $request->route('id'), (string) $user->getKey())
            || !hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return $this->sendError(__('verified.error'), 500);
        }

        if ($user->markEmailAsVerified()) {
            return $this->sendResponse([true], __('verified.success'));
        }

        return $this->sendResponse(['verified' => true], __('verified.success'));
    }

    /**
     * @param VerificationResendAPIRequest $request
     * @return mixed
     */
    public function resend(VerificationResendAPIRequest $request)
    {
        $user = User::find($request->id);

        if (!$user)  return $this->sendError(__('verified.error'), 500);

        if ($user->hasVerifiedEmail()) {
            return $this->sendError(__('verified.already'));
        }

        $user->sendEmailVerificationNotification();

        return $this->sendResponse(['resend' => true], __('verified.resend'));
    }
}
