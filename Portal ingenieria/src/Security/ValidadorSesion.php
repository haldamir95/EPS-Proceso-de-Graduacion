<?php

namespace App\Security;

use App\Model\ModeloSeguridad;

class ValidadorSesion
{
    const NOMBRE_SITIO = 'Sistema Padrones Electorales';
    private $modelo;

    public function __construct(ModeloSeguridad $modelo)
    {
        $this->modelo = $modelo;
    }

    public function obtenerRolUnidad($rol, $unidad)
    {
        $nombres = $this->modelo->obtenerNombresRolUnidad($rol, $unidad);
        $rol = str_replace (' ' , '_' , strtoupper($nombres['rol']));
        $unidad = str_replace (' ' , '' , strtoupper($nombres['unidad']));
        return 'ROLE_' . $rol . '_' . $unidad;
    }

    public function validarSesionSitio($idusuario, $rol, $unidad)
    {
        $permiso = $this->modelo->validarPermiso(
            $idusuario,
            $rol,
            $unidad,
            self::NOMBRE_SITIO
        );
        if ($permiso!== false) {
            return $permiso['count'] > 0;
        }
        return false;
    }

    public function validarUsuarioContrasenia($usuario, $contrasenia)
    {
        $resultado = $this->modelo->validarUsuarioContrasenia(
            $usuario,
            $contrasenia
        );
        if ($resultado !== false) {
            return $resultado['count'] > 0;
        }
        return false;
    }
}
