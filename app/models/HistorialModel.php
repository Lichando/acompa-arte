<?php
namespace app\models;

use \DataBase;
use \Model;
use \Exception;

class HistorialModel
{
    public static function obtenerPorPaciente($paciente_id)
    {
        $sql = "SELECT * FROM historial_medico WHERE paciente_id = :paciente_id ORDER BY fecha DESC";
        return DataBase::query($sql, ['paciente_id' => $paciente_id]);
    }

    public static function crear($data)
    {
        $sql = "INSERT INTO historial_medico (paciente_id, fecha, descripcion) VALUES (:paciente_id, :fecha, :descripcion)";
        return DataBase::execute($sql, $data);
    }
}
