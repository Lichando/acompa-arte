<?php
namespace app\models;

use \DataBase;
use \Model;
use \Exception;

class UserModel extends Model
{
    protected $table = "usuarios";
    protected $primaryKey = "id";
    protected $secondaryKey = "email";

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $contrasena;
    public $fecha_nacimiento;
    public $fecha_alta;
    public $fecha_baja;
    public $genero;
    public $rol_id;
    public $ultimo_acceso;
    public $activo;

    public static function findEmail($email)
    {
        $model = new static();
        $sql = "SELECT * FROM {$model->table} WHERE {$model->secondaryKey} = :email LIMIT 1";
        $params = ["email" => $email];
        $result = DataBase::query($sql, $params);

        if ($result && count($result) > 0) {
            return $model->loadData($result[0]);
        }
        return false;
    }

    public static function findId($id)
    {
        $model = new static();
        $sql = "SELECT * FROM {$model->table} WHERE {$model->primaryKey} = :id LIMIT 1";
        $params = ["id" => $id];
        $result = DataBase::query($sql, $params);

        if ($result && count($result) > 0) {
            return $model->loadData($result[0]);
        }
        return false;
    }

    public static function getFamiliares($usuarioId)
    {
        $sql = "SELECT * FROM pacientes WHERE usuario_id = ?";
        return DataBase::query($sql, [$usuarioId]);
    }


    public static function usuarioNew($data)
    {
        $sql = "INSERT INTO usuarios 
        (nombre, apellido, email, contrasena, fecha_nacimiento, genero, rol_id, activo) 
        VALUES 
        (:nombre, :apellido, :email, :contrasena, :fecha_nacimiento, :genero, :rol_id, :activo)";

        $params = [
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],
            'contrasena' => $data['contrasena'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'genero' => $data['genero'],
            'rol_id' => $data['rol_id'] ?? 1,
            'activo' => $data['activo'] ?? 1
        ];

        try {
            // Ejecutar la consulta
            $result = DataBase::query($sql, $params);

            // Verificar directamente el resultado
            // Asumiendo que DataBase::query() retorna true/false
            return $result !== false;

        } catch (Exception $e) {
            error_log("Error en usuarioNew: " . $e->getMessage());
            return false;
        }
    }


    protected function loadData($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }
}