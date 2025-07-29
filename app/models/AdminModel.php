<?php
namespace app\models;

use \DataBase;
use \Model;
use \Exception;

class AdminModel extends Model
{
    protected $table = "administrador";
    protected $primaryKey = "id";

    public $id;
    public $usuario_id;
    public $nivel_acceso;
    public $departamento;
    public $permisos_especiales;
    public $firma_electronica;

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

    public static function create($data)
    {
        $sql = "INSERT INTO administrador 
                (usuario_id, nivel_acceso, departamento) 
                VALUES 
                (:usuario_id, :nivel_acceso, :departamento)";

        $params = [
            'usuario_id' => $data['usuario_id'],
            'nivel_acceso' => $data['nivel_acceso'],
            'departamento' => $data['departamento'] ?? null
        ];

        try {
            return DataBase::query($sql, $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public static function TotalInstituciones()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM instituciones";
            $result = DataBase::query($sql);

            // Manejar tanto arrays como objetos
            return is_object($result[0]) ? $result[0]->total : ($result[0]['total'] ?? 0);

        } catch (Exception $e) {
            error_log("Error en TotalInstituciones: " . $e->getMessage());
            return 0;
        }
    }

    public static function PacientesActivos()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM pacientes WHERE activo = 1";
            $result = DataBase::query($sql);
            return is_object($result[0]) ? $result[0]->total : ($result[0]['total'] ?? 0);
        } catch (Exception $e) {
            error_log("Error en PacientesActivos: " . $e->getMessage());
            return 0;
        }
    }

    public static function AcompanantesActivos()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM acompanantes WHERE activo = 1";  // Corregido: tabla acompanantes
            $result = DataBase::query($sql);
            return is_object($result[0]) ? $result[0]->total : ($result[0]['total'] ?? 0);
        } catch (Exception $e) {
            error_log("Error en AcompanantesActivos: " . $e->getMessage());
            return 0;
        }
    }

    // Para obtener pacientes con nombre de institución
    public static function ListaPacientes()
    {
        $db = Database::connection();
        $query = "SELECT p.*, i.nombre as institucion_nombre 
              FROM pacientes p
              LEFT JOIN instituciones i ON p.institucion_id = i.id";
        $stmt = $db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function ListaInstituciones()
    {
        $db = Database::Connection();
        $stmt = $db->query("SELECT * FROM instituciones");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }



    public static function ListaAcompanantes()
    {
        $db = Database::connection();
        $query = "SELECT a.*, 
                  u.nombre as usuario_nombre, 
                  u.apellido as usuario_apellido,
                  u.email as usuario_email
                  FROM acompanantes a
                  LEFT JOIN usuarios u ON a.usuario_id = u.id";

        $stmt = $db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    // En AdminModel.php
    public static function ListaInstitucionesRecientes()
    {
        $db = Database::connection();
        $stmt = $db->query("SELECT * FROM instituciones ORDER BY fecha_registro DESC LIMIT 5");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Retorna como array asociativo
    }


    public static function ListaPacientesRecientes()
    {
        $db = Database::Connection();
        $query = "SELECT p.*, i.nombre as institucion_nombre 
              FROM pacientes p
              LEFT JOIN instituciones i ON p.institucion_id = i.id
              ORDER BY p.fecha_registro DESC 
              LIMIT 5";

        $stmt = $db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }




}