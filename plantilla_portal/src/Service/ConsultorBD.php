<?php

namespace App\Service;

use Doctrine\DBAL\Driver\Connection;

class ConsultorBD
{
    const INGENIERIA2 = 1;
    const GESTION_AUTENTICACION = 2;

    protected $connectionIngenieria;
    protected $connectionGestionAutenticacion;

    public function __construct(
        Connection $connectionIngenieria,
        Connection $connectionGestionAutenticacion
    ) {
        $this->connectionIngenieria = $connectionIngenieria;
        $this->connectionGestionAutenticacion = $connectionGestionAutenticacion;
    }

    public function empezarTransaccion($base = self::INGENIERIA2)
    {
      $this->seleccionarConexion($base)->beginTransaction();
    }

    public function commit($base = self::INGENIERIA2)
    {
      $this->seleccionarConexion($base)->commit();
    }

    public function rollback($base = self::INGENIERIA2)
    {
      $this->seleccionarConexion($base)->rollback();
    }

    public function ejecutarSentencia($consulta, $parametros = [], $base = self::INGENIERIA2)
    {
        $connection = $this->seleccionarConexion($base);
        return $connection->executeUpdate($consulta, $parametros);
    }

    public function obtenerUnaFila($consulta, $parametros = [], $base = self::INGENIERIA2)
    {
        $connection = $this->seleccionarConexion($base);
        return $connection->fetchAssoc($consulta, $parametros);
    }

    public function obtenerTodasFilas($consulta, $parametros = [], $base = self::INGENIERIA2)
    {
        $connection = $this->seleccionarConexion($base);
        return $connection->fetchAll($consulta, $parametros);
    }

    private function seleccionarConexion($base)
    {
        switch ($base) {
            case self::INGENIERIA2:
                return $this->connectionIngenieria;
            case self::GESTION_AUTENTICACION:
                return $this->connectionGestionAutenticacion;
            default:
                throw new \Exception("No se encuentra la base de datos especificada", 1);
        }
    }
}
