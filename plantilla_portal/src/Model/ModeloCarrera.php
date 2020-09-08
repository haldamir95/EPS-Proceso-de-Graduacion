<?php

namespace App\Model;

use App\Service\ConsultorBD;

class ModeloCarrera{
    private $consultor;

    public function __construct(ConsultorBD $consultor)
    {
        $this->consultor = $consultor;
    }

    public function existeCarreraEstudiante($carnet, $carrera){
        $consulta = "   SELECT carrera
                        FROM estudiantecarrera 
                        WHERE usuarioid = :usuario
                        AND carrera = :carrera";
        $parametros = ['usuario' => $carnet,
                        'carrera' => $carrera];
        $data = $this->consultor->obtenerUnaFila($consulta, $parametros);

        return (\is_array($data)) && (\count($data) > 0) ? true: false;
    }
}