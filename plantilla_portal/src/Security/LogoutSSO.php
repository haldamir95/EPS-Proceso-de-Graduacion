<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutSSO implements LogoutSuccessHandlerInterface
{
    public function onLogoutSuccess(Request $request)
    {
        if (getEnv('MODO_SSO') === 'false') {
            return new RedirectResponse('/');
        }
        return new RedirectResponse('https://proxy.ingenieria.usac.edu.gt/autenticacion/XUI/#logout/&goto='. urlencode('https://dashboard-academico.ingenieria.usac.edu.gt/login'));
    }
}
