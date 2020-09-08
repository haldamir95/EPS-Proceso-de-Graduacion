<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class Usuario implements UserInterface
{
    private $roles;
    private $username;
    private $password;
    private $salt;
    private $nombre;
    private $apellido;

    public function __construct($username)
    {
        $this->username = $username;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {

    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }
}
