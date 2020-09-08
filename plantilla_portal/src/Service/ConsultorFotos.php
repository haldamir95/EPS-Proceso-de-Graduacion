<?php

namespace App\Service;

use GuzzleHttp\Client;

class ConsultorFotos
{
    private $uriApiMongo;
    private $userApiMongo;
    private $passApiMongo;

    public function __construct()
    {
        $this->uriApiMongo = getenv('URI_API_MONGO');
        $this->userApiMongo = getenv('USER_API_MONGO');
        $this->passApiMongo = getenv('PASS_API_MONGO');
    }

    public function obtenerFoto($carnet)
    {
        try {
            $urlDescarga = $this->obtenerUrlDescarga($carnet);
            if (empty($urlDescarga)) {
                throw new \Exception("No pudo obtenerse URL de descarga.");
            }
            $imagen = $this->enviarPeticion($urlDescarga);
            return $imagen;
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
        return '';
    }

    private function obtenerUrlDescarga($carnet)
    {
        $response = $this->enviarPeticion($this->obtenerUrlBusqueda($carnet));
        $json = json_decode($response);
        if (count($json->_embedded) < 1) {
            $response = $this->enviarPeticion($this->obtenerUrlBusqueda('sinfoto00'));
            $json = json_decode($response);
        }
        $data = 'rh:data';
        return $json->_embedded[0]->_links->$data->href;
    }

    private function obtenerUrlBusqueda($filename)
    {
        return '/ingenieria/fotos.files?filter='.urlencode(json_encode(['filename' => $filename]));
    }

    private function enviarPeticion($url)
    {
        $uriMongo = $this->uriApiMongo;
        $cliente = new Client(['base_uri' => $uriMongo]);
        $respuesta = $cliente->request(
            'GET',
            $url,
            ['auth' => [$this->userApiMongo, $this->passApiMongo]]
        );
        return $respuesta->getBody()->getContents();
    }
}
