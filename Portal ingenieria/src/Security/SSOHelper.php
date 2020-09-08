<?php
namespace App\Security;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie;

class SSOHelper
{
    const SSO_COOKIE = 'iPlanetDirectoryPro';
    const AMLB_COOKIE = 'amlbcookie';
    const DOMINIO = 'ingenieria.usac.edu.gt';
    const BASE_URI = 'https://proxy.ingenieria.usac.edu.gt/autenticacion/';
    const METODO = 'POST';
    private $cookieJar;

    public function __construct()
    {
        $this->cookieJar = new Cookie\CookieJar();
    }

    public function obtenerRegistroAcademicoSSO()
    {
        try {
            $displayName = $this->obtenerParametroSSO("displayName");
            $identificadores = explode('_', $displayName);
            $registroAcademico = '';
            foreach ($identificadores as $identificador ) {
                $posicion = strpos($identificador, 'ra:');
                if ($posicion !== false) {
                    $posicionSeparador = strpos($identificador, '&');
                    $registroAcademico = substr($identificador, $posicion + 3 , $posicionSeparador - 3 );
                    break;
                }
            }
            return $registroAcademico;
        } catch (\Exception $e) {
            return '';
        }
    }

    public function obtenerParametroSSO(
        $parametro,
        $baseUri = self::BASE_URI,
        $metodo = self::METODO
    ) {
        try {
            $response = $this->enviarPeticion($parametro, $baseUri, $metodo);
            $json = json_decode($response);
            return $json->attributes[0]->values[0];
        } catch (\Exception $e) {
            return '';
        }
    }

    public function obtenerParametroSSOArreglo(
        $parametro,
        $baseUri = self::BASE_URI,
        $metodo = self::METODO
    ) {
        try {
            $response = $this->enviarPeticion($parametro, $baseUri, $metodo);
            $json = json_decode($response);
            return $json->attributes[0]->values;
        } catch (\Exception $e) {
            return '';
        }
    }

    public function getURLLogout($goto){
        return "https://proxy.ingenieria.usac.edu.gt/autenticacion/XUI/#logout/&goto=" . urlencode($goto);
    }

    private function enviarPeticion($parametro, $baseUri, $metodo)
    {
        $cliente = new Client(['base_uri' => $baseUri]);
        $this->cargarCookie(self::SSO_COOKIE);
        $this->cargarCookie(self::AMLB_COOKIE);
        $respuesta = $cliente->request(
            $metodo,
            'identity/json/attributes',
            [
                'form_params' => ['attributenames' => $parametro],
                'cookies' => $this->cookieJar
            ]
        );
        return $respuesta->getBody()->getContents();
    }

    private function cargarCookie($nombre, $dominio = self::DOMINIO)
    {
        if (isset($_COOKIE[$nombre])) {
            $cookie = new \GuzzleHttp\Cookie\SetCookie();
            $cookie->setName($nombre);
            $cookie->setValue($_COOKIE[$nombre]);
            $cookie->setDomain($dominio);
            $this->cookieJar->setCookie($cookie);
        }
    }
}
