<?php
namespace app\models;

use \DataBase;
use \Model;
use \Exception;
class AcompananteModel extends Model
{
    protected $table = "acompanantes";
    protected $primaryKey = "id";
    public $id;
    public $usuario_id;
    public $nombre;
    public $apellido;
    public $dni;
    public $telefono;


    public static function findById($id)
    {
        $sql = "SELECT * FROM acompanantes WHERE id = :id LIMIT 1";
        $params = ["id" => $id];

        $result = DataBase::query($sql, $params);

        return !empty($result) ? (new static())->loadData($result[0]) : false;
    }

    public static function getAcompanantesPorInstitucion($institucion_id)
    {
        $sql = "
            SELECT a.*, u.nombre, u.apellido, u.email
            FROM acompanantes a
            JOIN usuarios u ON a.usuario_id = u.id
            JOIN pacientes p ON p.acompanante_id = a.id
            WHERE p.institucion_id = :institucion_id
            GROUP BY a.id
        ";
        $params = ["institucion_id" => $institucion_id];

        return DataBase::query($sql, $params);
    }
    public static function getAsistentesDisponibles($id)
    {
        $sql = "SELECT * FROM acompanantes WHERE id = :id AND disponible = 1 LIMIT 1";
        $params = ["id" => $id];

        $result = DataBase::query($sql, $params);

        return !empty($result) ? (new static())->loadData($result[0]) : false;
    }





    public static function findByUsuarioId($usuario_id)
    {
        $sql = "
        SELECT a.*, u.nombre,u.apellido
        FROM acompanantes a
        INNER JOIN usuarios u ON a.usuario_id = u.id
        WHERE a.usuario_id = :usuario_id
        LIMIT 1
    ";
        $params = ["usuario_id" => $usuario_id];

        $result = DataBase::query($sql, $params);

        return !empty($result) ? (new static())->loadData($result[0]) : false;
    }



    public static function getFamilias($acompanante_id)
    {
        $sql = "
        SELECT 
            u.nombre AS nombre_tutor, 
            p.nombre AS nombre_paciente,
            u.apellido AS apellido_tutor, 
            p.apellido AS apellido_paciente,
            p.tipo_condicion AS condicion
        FROM 
            pacientes p
        JOIN 
            usuarios u ON p.usuario_id = u.id
        WHERE 
            p.acompanante_id = :id
        ORDER BY 
            u.nombre
    ";

        $params = ["id" => $acompanante_id];

        $result = DataBase::query($sql, $params);

        return !empty($result) ? $result : false;
    }



    /**
     * Crea un nuevo acompañante
     */
    public static function create($data)
    {
        try {
            // Validación de campos obligatorios
            $required = [
                'dni',
                'telefono',
                'usuario_id',
                'tipo_condicion',
                'rol'
            ];

            foreach ($required as $field) {
                if (empty($data[$field]) && $data[$field] !== '0') {
                    throw new Exception("Falta el campo obligatorio: {$field}");
                }
            }

            // Validación de formato DNI
            if (!preg_match('/^\d{7,8}$/', $data['dni'])) {
                throw new Exception("DNI inválido (debe tener 7 u 8 dígitos)");
            }

            // Validación de formato teléfono
            if (!preg_match('/^[\d\s\-\(\)]{6,20}$/', $data['telefono'])) {
                throw new Exception("Teléfono inválido (6-20 caracteres)");
            }

            // Verificar si el DNI ya existe (única verificación de existencia como en PacienteModel)
            if (self::existeDni($data['dni'])) {
                throw new Exception("El DNI ya está registrado");
            }

            $sql = "INSERT INTO acompanantes 
                (usuario_id, dni, telefono,tipo_condicion) 
                VALUES 
                (:usuario_id, :dni, :telefono,:tipo_condicion)";

            $params = [
                'usuario_id' => $data['usuario_id'],
                'dni' => $data['dni'],
                'telefono' => $data['telefono'],
                'tipo_condicion' => $data['tipo_condicion']
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
            error_log("[AcompananteModel::create] PDOException: " . $ex->getMessage());

            // Manejo específico de errores de duplicado
            if ($ex->getCode() == 23000) {
                return "El DNI o usuario ya están registrados";
            }

            return "Error de base de datos: " . $ex->getMessage();
        } catch (Exception $ex) {
            error_log("[AcompananteModel::create] Exception: " . $ex->getMessage());
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
            error_log("[AcompananteModel::actualizarRolUsuario] Error al ejecutar la consulta");
            return false;
        }

        if ($affectedRows === 0) {
            error_log("[AcompananteModel::actualizarRolUsuario] No se actualizó ninguna fila. Usuario inexistente o rol igual.");
            return true; // Consideramos éxito si no hubo cambios necesarios
        }

        return true;
    }

    public static function existeDni($dni): bool
    {
        $sql = "SELECT COUNT(*) as count FROM acompanantes WHERE dni = :dni";
        $result = DataBase::query($sql, ['dni' => $dni]);

        // Solución rápida - funciona para ambos casos (array u objeto)
        if (is_object($result[0])) {
            return $result[0]->count > 0;  // Acceso como objeto
        } else {
            return $result[0]['count'] > 0; // Acceso como array
        }
    }


    /**
     * Obtiene todas las instituciones
     */
    public static function MisInstituciones()
    {
        $sql = "SELECT * FROM instituciones WHERE activo = 1 ORDER BY nombre";
        return DataBase::query($sql);
    }
    public static function update($usuarioId, $data)
    {
        $db = Database::connection();

        try {
            // Actualiza acompañante
            $stmt = $db->prepare("UPDATE acompanantes SET dni = :dni, telefono = :telefono WHERE usuario_id = :usuario_id");
            $stmt->execute([
                ':dni' => $data['dni'],
                ':telefono' => $data['telefono'],
                ':usuario_id' => $usuarioId
            ]);

            // Actualiza usuarios
            $stmt2 = $db->prepare("UPDATE usuarios SET nombre = :nombre, apellido = :apellido WHERE id = :usuario_id");
            $stmt2->execute([
                ':nombre' => $data['nombre'],
                ':apellido' => $data['apellido'],
                ':usuario_id' => $usuarioId
            ]);

            return true;
        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }


    public static function darBaja($usuario_id)
    {
        $db = Database::connection();

        try {
            // Desactivar acompañante
            $stmt1 = $db->prepare("UPDATE acompanantes SET activo=0 WHERE usuario_id = :usuario_id");
            $stmt1->execute([':usuario_id' => $usuario_id]);

            // Cambiar el rol a usuario común
            $stmt2 = $db->prepare("UPDATE usuarios SET rol_id = 1 WHERE id = :usuario_id");
            $stmt2->execute([':usuario_id' => $usuario_id]);

            return true;
        } catch (Exception $e) {
            return "Error al dar de baja: " . $e->getMessage();
        }
    }



}