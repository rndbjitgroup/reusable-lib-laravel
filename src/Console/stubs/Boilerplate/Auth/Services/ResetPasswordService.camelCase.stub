<?php

namespace App\Services\Auth;

use App\Enums\CmnEnum; 
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordService 
{
    use RespondsWithHttpStatus;

    public function resetPassword($request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'passwordConfirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? $this->success(__($status))
                    : $this->failure(['email' => __($status)]);
    }

}