<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user->roles === 'ADMIN') {
            return redirect()->intended('/home');
        }

        return redirect()->intended('/shop/dashboard');
    }
}
