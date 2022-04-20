<?php

declare(strict_types=1);

namespace A1comms\GaeSupportLaravel\Auth\Http\Controllers;

use A1comms\GaeSupportLaravel\Auth\Token\Firebase as Token;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cookie;

class Firebase extends BaseController
{
    /**
     * login.
     */
    public function login()
    {
        $cookie = Token::fetchToken(
            env('FIREBASE_PROJECT'),
            request()->input('idToken')
        );

        return response('OK')->cookie(
            config('gaesupport.auth.firebase.cookie_name'),
            $cookie,
            2628000,
            null,
            null,
            true,
            true,
            false,
            'strict'
        );
    }

     /**
     * fetchLoginToken
     *
     * @access public
     */
    public function fetchLoginToken()
    {
        return Token::fetchToken(
            env('FIREBASE_PROJECT'),
            request()->input('idToken')
        );
    }

    /**
     * fetchLoginCookie
     *
     * @access public
     */
    public function fetchLoginCookie($token)
    {
        return response('OK')->cookie(
            config('gaesupport.auth.firebase.cookie_name'), $token, 2628000, null, null, true, true, false, 'strict'
        );
    }

    /**
     * logout.
     */
    public function logout()
    {
        Cookie::queue(
            Cookie::forget(
                config('gaesupport.auth.firebase.cookie_name')
            )
        );

        return redirect(
            config('gaesupport.auth.firebase.logout_redirect')
        );
    }
}
