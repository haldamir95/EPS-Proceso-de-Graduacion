<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class PortalUserProvider implements UserProviderInterface
{
    private $ssoHelper;

    public function __construct(SSOHelper $ssoHelper)
    {
        $this->ssoHelper = $ssoHelper;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        return $this->obtenerUsuarioDesdeSSO($username);
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException  if the user is not supported
     * @throws UsernameNotFoundException if the user is not found
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof Usuario) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        return $this->obtenerUsuarioDesdeSSO($user->getUsername());
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return Usuario::class === $class;
    }

    /**
     * Obtiene el usuario desde el SSO
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    private function obtenerUsuarioDesdeSSO($carnet)
    {
        $username = '';
        $uniqueIdentifiers = $this->ssoHelper->obtenerParametroSSOArreglo('uniqueIdentifier');
        foreach ($uniqueIdentifiers as $uniqueIdentifier) {
            if ($uniqueIdentifier === $carnet) {
                $username = $uniqueIdentifier;
            }
        }
        if (!empty($username)) {
            $usuario = new Usuario($username);
            $nombre = $this->ssoHelper->obtenerParametroSSO('givenName');
            $apellido = $this->ssoHelper->obtenerParametroSSO('sn');
            $usuario->setNombre($nombre);
            $usuario->setApellido($apellido);
            return $usuario;
        }
        throw new UsernameNotFoundException (
            "No se encontró sesión para el usuario."
        );
    }
}
