<?php

namespace App\Services\Auth;

use App\Enums\CmnEnum; 
use App\Traits\Common\RespondsWithHttpStatus; 
use Illuminate\Support\Facades\Password;

class ForgotPasswordService 
{
    use RespondsWithHttpStatus;

    public function forgotPassword($request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? $this->success(__($status))
                    : $this->failure(__($status));
    }

}