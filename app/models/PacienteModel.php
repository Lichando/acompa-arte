<?php
namespace app\models;

use \DataBase;
use \Model;
use \Exception;

class PacienteModel extends Model
{
    protected $table = "pacientes";
    protected $primaryKey = "id";

    public $id;
    public $usuario_id;

    public $nombre;

    public $apellido;
    public $dni;
    public $fecha_de_nacimiento;
    public $edad;
    public $direccion;
    public $institucion_id;
    public $tiene_obra_social;
    public $obra_social_id;
    public $acompanante_id;
    public $tipo_condicion;
    public $descripcion;
    public $numero_cud;
    public $fecha_registro;

    public static function findByUserId($usuario_id)
    {
        $model = new static();
        $sql = "SELECT * FROM {$model->table} WHERE usuario_id = :usuario_id LIMIT 1";
        $params = ["usuario_id" => $usuario_id];
        $result = DataBase::query($sql, $params);

        if ($result && count($result) > 0) {
            return $model->loadData($result[0]);
        }
        return false;
    }

    public static function findById($id)
    {
        $sql = "SELECT * FROM pacientes WHERE id = ?";
        $resultado = DataBase::query($sql, [$id]);
        if (count($resultado) > 0) {
            return $resultado[0];  // Retorna el primer objeto (paciente)
        }
        return false;  // No se encontró paciente
    }



    public function getPacientesByUserId($userId)
    {
        $sql = "SELECT * FROM pacientes WHERE usuario_id = ?";
        return DataBase::query($sql, [$userId]);
    }

    public static function getAcompanantesPorInstitucion($institucionId)
    {
        $sql = "
                SELECT 

            p.nombre AS paciente_nombre,
            p.apellido AS paciente_apellido,
            u.nombre AS acompanante_nombre,
            u.apellido AS acompanante_apellido,
            a.dni AS acompanante_dni

        FROM 
            pacientes p
        LEFT JOIN 
            acompanantes a ON p.acompanante_id = a.id
        LEFT JOIN 
            usuarios u ON a.usuario_id = u.id
        WHERE 
            p.institucion_id = :institucion_id;
            ";

        $params = ['institucion_id' => $institucionId];

        return DataBase::query($sql, $params);
    }



    public static function getPacientesPorInstitucion($institucionId)
    {
        $sql = "
        SELECT 
            p.*, 
            u.nombre AS nombre_tutor,
            u.apellido AS apellido_tutor
        FROM pacientes p
        LEFT JOIN usuarios u ON p.usuario_id = u.id
        WHERE p.institucion_id = :institucion_id
    ";

        $params = ['institucion_id' => $institucionId];

        return DataBase::query($sql, $params);
    }

    public static function getPacientesConAcompanantes($institucionId)
    {
        $sql = "
       SELECT 
            a.id,
        ua.nombre AS acompanante_nombre,
        ua.apellido AS acompanante_apellido,
            a.dni AS acompanante_dni,
            p.nombre AS paciente_nombre,
            p.apellido AS paciente_apellido,
            u.nombre AS nombre_tutor,
            u.apellido AS apellido_tutor
        FROM pacientes p
        LEFT JOIN acompanantes a ON p.acompanante_id = a.id
        LEFT JOIN usuarios ua ON a.usuario_id = ua.id 
        LEFT JOIN usuarios u ON p.usuario_id = u.id
        WHERE p.institucion_id = :institucion_id

    ";

        $params = ['institucion_id' => $institucionId];

        return DataBase::query($sql, $params);
    }

    public static function getAcompanantesPorCondicion( $tipoCondicion)
    {
        $sql = "
        SELECT 
            a.id AS acompanante_id,
            ua.nombre AS acompanante_nombre,
            ua.apellido AS acompanante_apellido,
            a.dni AS acompanante_dni,
            a.tipo_condicion AS acompanante_condicion
        FROM acompanantes a
        INNER JOIN usuarios ua ON a.usuario_id = ua.id
        WHERE a.disponible = 1
          AND a.tipo_condicion = :tipo_condicion
    ";

        $params = [
            'tipo_condicion' => $tipoCondicion,
        ];

        return DataBase::query($sql, $params);
    }









    public static function create($data)
    {
        try {
            // Validación de campos obligatorios
            $required = [
                'nombre',
                'apellido',
                'dni',
                'fecha_de_nacimiento',
                'edad',
                'direccion',
                'institucion_id',
                'tipo_condicion',
                'descripcion',
                'fecha_registro',
                'usuario_id',
                'rol'
            ];

            foreach ($required as $field) {
                if (empty($data[$field]) && $data[$field] !== '0') {  // permite 0 si corresponde
                    throw new Exception("Falta el campo obligatorio: {$field}");
                }
            }

            $sql = "INSERT INTO pacientes 
        (nombre, apellido, dni, fecha_de_nacimiento, edad, direccion, 
         institucion_id, tiene_obra_social, obra_social_id,
         tipo_condicion, descripcion, numero_cud, fecha_registro, usuario_id) 
        VALUES 
        (:nombre, :apellido, :dni, :fecha_de_nacimiento, :edad, :direccion, 
         :institucion_id, :tiene_obra_social, :obra_social_id,
         :tipo_condicion, :descripcion, :numero_cud, :fecha_registro, :usuario_id)";

            $params = [
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'dni' => $data['dni'],
                'fecha_de_nacimiento' => $data['fecha_de_nacimiento'],
                'edad' => $data['edad'],
                'direccion' => $data['direccion'],
                'institucion_id' => $data['institucion_id'] ?: null,
                'tiene_obra_social' => $data['tiene_obra_social'],
                'obra_social_id' => $data['tiene_obra_social'] ? $data['obra_social_id'] : null,
                'tipo_condicion' => $data['tipo_condicion'],
                'descripcion' => $data['descripcion'],
                'numero_cud' => $data['numero_cud'] ?: null,
                'fecha_registro' => $data['fecha_registro'],
                'usuario_id' => $data['usuario_id']
            ];

            $result = DataBase::execute($sql, $params);

            if (!$result) {
                throw new Exception("Error al ejecutar la consulta de inserción");
            }

            if (!self::actualizarRolUsuario($data['usuario_id'], $data['rol'])) {
                throw new Exception("Error al actualizar rol de usuario");
            }

            return true;

        } catch (\PDOException $ex) {
            error_log("[PacienteModel::create] PDOException: " . $ex->getMessage());
            return "Error de base de datos: " . $ex->getMessage();
        } catch (Exception $ex) {
            error_log("[PacienteModel::create] Exception: " . $ex->getMessage());
            return "Error: " . $ex->getMessage();
        }
    }




    private static function actualizarRolUsuario($usuario_id, $rol)
    {
        $sql = "UPDATE usuarios SET rol_id = :rol WHERE id = :usuario_id";
        $affectedRows = DataBase::execute($sql, [
            'usuario_id' => $usuario_id,
            'rol' => $rol
        ]);

        if ($affectedRows === false) {
            // Hubo un error en la consulta
            error_log("[PacienteModel::actualizarRolUsuario] Error al ejecutar la consulta");
            return false;
        }

        // Si no se actualizó ninguna fila, puede ser que el usuario no exista o ya tenía ese rol.
        // Si querés considerar esto como éxito, devolvé true igual, sino false.
        if ($affectedRows === 0) {
            error_log("[PacienteModel::actualizarRolUsuario] No se actualizó ninguna fila. Usuario inexistente o rol igual.");
            // Decidir si considerarlo error o no:
            return true; // <-- Para que no dé error si ya tenía ese rol
        }

        return true; // Actualización exitosa
    }


    public static function existeDni($dni): bool
    {
        $sql = "SELECT COUNT(*) as count FROM pacientes WHERE dni = :dni";
        $result = DataBase::query($sql, ['dni' => $dni]);
        return $result[0]['count'] > 0;
    }
}
