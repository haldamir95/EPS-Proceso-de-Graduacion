<?php

namespace App\Model;

class ModeloSeguridad{

    public function __construct()
    {
    }

    public function desencriptaCarrera($codificado, $iv){
        $llave = "e8LmcwV6b6"; //Debe ser la misma de donde se encripta (dashboar-academico)
        $method = "aes-256-cbc";
        $data_decrypted = openssl_decrypt($codificado, $method, $llave, OPENSSL_RAW_DATA , $iv);
        $carrera = explode("|", $data_decrypted)[0]; //Se envia junto la carrera el carnet, ej. 05|200815460
        return $carrera;
    }
}