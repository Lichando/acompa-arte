<?php
namespace app\models;

use \DataBase;
use \Model;
use \Exception;

class InstitucionModel extends Model
{
    protected $table = "instituciones";
    protected $primaryKey = "id";

    // Propiedades completas del modelo
    public $id;
    public $nombre;
    public $direccion;
    public $ciudad;
    public $provincia;
    public $telefono;
    public $email;
    public $tipo;
    public $sector;
    public $activo;
    public $created_at;
    public $updated_at;

    // Constantes para valores predefinidos
    const TIPO_HOSPITAL = 'hospital';
    const TIPO_CLINICA = 'clinica';
    const TIPO_CENTRO_SALUD = 'centro_salud';
    const TIPO_EDUCATIVA = 'educativa';
    const TIPO_OTRO = 'otro';

    const SECTOR_PUBLICO = 'publico';
    const SECTOR_PRIVADO = 'privado';
    const SECTOR_MIXTO = 'mixto';


    public static function getInstitucionPorUsuarioId($userId): ?int
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT * FROM instituciones WHERE usuario_id=:usuario_id;");
        $stmt->bindParam(':usuario_id', $userId);
        $stmt->execute();

        $institucion = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $institucion ? (int) $institucion['id'] : null;
    }

    /**
     * Obtiene una institución por nombre
     */





    public static function findByName($nombre)
    {
        $sql = "SELECT * FROM instituciones WHERE nombre LIKE :nombre LIMIT 1";
        $params = ["nombre" => "%$nombre%"];

        $result = DataBase::query($sql, $params);

        return !empty($result) ? (new static())->loadData($result[0]) : false;
    }
    public static function findById($id)
    {
        $sql = "SELECT * FROM instituciones WHERE id = :id LIMIT 1";
        $params = ["id" => $id];

        $result = DataBase::query($sql, $params);

        return !empty($result) ? (new static())->loadData($result[0]) : false;
    }



    public static function getFamiliasConAsistentes($institucionId)
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
            p.institucion_id = :id
        ORDER BY 
            u.nombre
    ";

        $params = ["id" => $institucionId];

        $result = DataBase::query($sql, $params);

        return !empty($result) ? $result : false;
    }
    public static function getAcompanantesPorInstitucion($institucionId)
    {
        $sql = "
        SELECT DISTINCT 
            a.id, a.nombre, a.apellido, a.email
        FROM 
            pacientes p
        JOIN 
            acompanante a ON p.acompanante_id = a.id
        WHERE 
            p.institucion_id = :institucion_id
        ORDER BY 
            a.nombre, a.apellido
    ";
        $params = ['institucion_id' => $institucionId];
        return DataBase::query($sql, $params);
    }



    /**
     * Crea una nueva institución
     */
    public static function create($data)
    {
        try {
            // Validación de campos obligatorios
            $required = [
                'nombre',
                'direccion',
                'ciudad',
                'provincia',
                'telefono',
                'email',
                'tipo',
                'sector',
                'usuario_id',
                'rol'
            ];

            foreach ($required as $field) {
                if (empty($data[$field]) && $data[$field] !== '0') {
                    throw new Exception("Falta el campo obligatorio: {$field}");
                }
            }

            // Validación de formato email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email inválido");
            }

            // Validación de tipo y sector
            if (!in_array(strtolower($data['tipo']), ['educativa', 'sanitaria'])) {
                throw new Exception("Tipo de institución inválido");
            }

            if (!in_array(strtolower($data['sector']), ['publica', 'privada'])) {
                throw new Exception("Sector inválido");
            }

            // Verificar si el nombre ya existe
            if (self::existeNombre($data['nombre'])) {
                throw new Exception("Ya existe una institución con ese nombre");
            }

            $sql = "INSERT INTO instituciones 
                (nombre, direccion, ciudad, provincia, telefono, email, 
                 tipo, sector, activo, usuario_id) 
                VALUES 
                (:nombre, :direccion, :ciudad, :provincia, :telefono, :email,
                 :tipo, :sector, :activo, :usuario_id)";

            $params = [
                'nombre' => $data['nombre'],
                'direccion' => $data['direccion'],
                'ciudad' => $data['ciudad'],
                'provincia' => $data['provincia'],
                'telefono' => $data['telefono'],
                'email' => $data['email'],
                'tipo' => strtolower($data['tipo']),
                'sector' => strtolower($data['sector']),
                'activo' => 1, // Por defecto se crea como activo
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
            error_log("[InstitucionModel::create] PDOException: " . $ex->getMessage());

            // Manejo específico de errores de duplicado
            if ($ex->getCode() == 23000) {
                return "El nombre o email ya están registrados";
            }

            return "Error de base de datos: " . $ex->getMessage();
        } catch (Exception $ex) {
            error_log("[InstitucionModel::create] Exception: " . $ex->getMessage());
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
            error_log("[InstitucionModel::actualizarRolUsuario] Error al ejecutar la consulta");
            return false;
        }

        if ($affectedRows === 0) {
            error_log("[InstitucionModel::actualizarRolUsuario] No se actualizó ninguna fila. Usuario inexistente o rol igual.");
            return true; // Consideramos éxito si no hubo cambios necesarios
        }

        return true;
    }

    public static function existeNombre($nombre)
    {
        $sql = "SELECT COUNT(*) AS cantidad FROM instituciones WHERE nombre = :nombre";
        $params = ['nombre' => $nombre];
        $result = DataBase::query($sql, $params);

        if ($result && count($result) > 0) {
            $row = $result[0];
            return $row->cantidad; // <- Cambio hecho aquí
        }

        return false;
    }




    /**
     * Obtiene todas las instituciones
     */
    public static function obtenerInstituciones()
    {
        $sql = "SELECT * FROM instituciones WHERE activo = 1 ORDER BY nombre";
        return DataBase::query($sql);
    }

    /**
     * Actualiza una institución
     */
     public static function update($institucionId, $data)
    {
        $db = Database::connection();

        try {
            // Actualiza acompañante
            $stmt = $db->prepare("UPDATE instituciones SET nombre = :nombre, direccion = :direccion, telefono = :telefono WHERE id = :institucionId");
            $stmt->execute([
                ':nombre' => $data['nombre'],
                ':direccion' => $data['direccion'],
                ':telefono' => $data['telefono'],
                ':institucionId' => $institucionId
            ]);

            return true;
        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function darBaja($usuario_id,$institucionId)
    {
        $db = Database::connection();

        try {
            // Desactivar acompañante
            $stmt1 = $db->prepare("UPDATE instituciones SET activo=0 WHERE id = :institucion_id");
            $stmt1->execute([':institucion_id' => $institucionId]);

            // Cambiar el rol a usuario común
            $stmt2 = $db->prepare("UPDATE usuarios SET rol_id = 1 WHERE id = :usuario_id");
            $stmt2->execute([':usuario_id' => $usuario_id]);

            return true;
        } catch (Exception $e) {
            return "Error al dar de baja: " . $e->getMessage();
        }
    }


}