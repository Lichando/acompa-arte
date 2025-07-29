<?php
namespace app\models;

use \DataBase;
use \Model;
use \Exception;
class SeguimientoModel
{
    public static function obtenerPorPaciente($paciente_id)
    {
        $sql = "SELECT * FROM seguimiento WHERE paciente_id = :paciente_id ORDER BY fecha DESC";
        return DataBase::query($sql, ['paciente_id' => $paciente_id]);
    }

    public static function crear($data)
    {
        $sql = "INSERT INTO seguimiento (paciente_id, acompanante_id, institucion_id, fecha, estado, observaciones)
                VALUES (:paciente_id, :acompanante_id, :institucion_id, :fecha, :estado, :observaciones)";
        return DataBase::execute($sql, $data);
    }
}

