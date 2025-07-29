<?php
namespace app\models;

use \DataBase;
use \Model;
use \Exception;
use \DateTime;

class ObraSocialModel extends Model
{
    protected $table = "obras_sociales";
    protected $primaryKey = "id";

    // Propiedades del modelo
    public $id;
    public $nombre;
    public $cuit;
    public $ambito;
    public $direccion;
    public $ciudad;
    public $provincia;
    public $telefono;
    public $email;
    public $web;
    public $cobertura_terapeutas;
    public $observaciones;
    public $activa;
    public $created_at;
    public $updated_at;

    // Constantes para valores predefinidos
    const AMBITO_NACIONAL = 'nacional';
    const AMBITO_PROVINCIAL = 'provincial';
    const AMBITO_MUNICIPAL = 'municipal';
    const AMBITO_PRIVADO = 'privado';

    /**
     * Obtiene una obra social por nombre (búsqueda exacta)
     */
    public static function findByName($nombre, $exactMatch = true)
    {
        $model = new static();
        $sql = "SELECT * FROM {$model->table} WHERE ";
        $sql .= $exactMatch ? "nombre = :nombre" : "nombre LIKE :nombre";
        $sql .= " LIMIT 1";

        $params = ["nombre" => $exactMatch ? $nombre : "%$nombre%"];
        $result = DataBase::query($sql, $params);

        return $result && count($result) > 0 ? $model->loadData($result[0]) : false;
    }

    /**
     * Crea una nueva obra social
     */
    public static function create(array $data)
    {
        try {
            // Validación básica
            if (empty($data['nombre'])) {
                throw new Exception("El nombre es obligatorio");
            }

            if (!empty($data['cuit']) && !self::validateCuit($data['cuit'])) {
                throw new Exception("El CUIT no es válido");
            }

            $currentDate = (new DateTime())->format('Y-m-d H:i:s');

            // Usar self::$table en lugar de $model->table
            $sql = "INSERT INTO " . self::$table . " 
                (nombre, cuit, ambito, direccion, ciudad, provincia, 
                 telefono, email, web, cobertura_terapeutas, observaciones, 
                 activa, created_at, updated_at) 
                VALUES 
                (:nombre, :cuit, :ambito, :direccion, :ciudad, :provincia, 
                 :telefono, :email, :web, :cobertura_terapeutas, :observaciones, 
                 :activa, :created_at, :updated_at)";

            $params = [
                'nombre' => $data['nombre'],
                'cuit' => $data['cuit'] ?? null,
                'ambito' => $data['ambito'] ?? self::AMBITO_PRIVADO,
                'direccion' => $data['direccion'] ?? null,
                'ciudad' => $data['ciudad'] ?? null,
                'provincia' => $data['provincia'] ?? null,
                'telefono' => $data['telefono'] ?? null,
                'email' => $data['email'] ?? null,
                'web' => $data['web'] ?? null,
                'cobertura_terapeutas' => $data['cobertura_terapeutas'] ?? false,
                'observaciones' => $data['observaciones'] ?? null,
                'activa' => $data['activa'] ?? true,
                'created_at' => $currentDate,
                'updated_at' => $currentDate
            ];

            $success = DataBase::query($sql, $params);

            if (!$success) {
                throw new Exception("Error al crear la obra social");
            }

            return $success;

        } catch (Exception $e) {
            error_log("ObraSocialModel::create() - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene todas las obras sociales activas
     */
    public static function getAll(bool $activasOnly = true)
    {
        $model = new static();
        $sql = "SELECT * FROM {$model->table}";

        if ($activasOnly) {
            $sql .= " WHERE activa = 1";
        }

        $sql .= " ORDER BY nombre";

        return DataBase::query($sql);
    }

    /**
     * Valida un CUIT (formato básico)
     */
    public static function validateCuit(string $cuit): bool
    {
        // Eliminar guiones y espacios
        $cuit = preg_replace('/[-\s]/', '', $cuit);

        // Validar formato básico (11 dígitos)
        if (!preg_match('/^\d{11}$/', $cuit)) {
            return false;
        }

        // Extraer partes del CUIT
        $xy = substr($cuit, 0, 2);  // Tipo (27, 30, etc.)
        $numero = substr($cuit, 2, 8);
        $digito_verificador = substr($cuit, 10, 1);

        // Validar tipo (primeros dos dígitos)
        $tiposValidos = [
            '20',
            '23',
            '24',
            '27',
            '30',
            '33',
            '34' // Tipos de CUIT válidos
        ];

        if (!in_array($xy, $tiposValidos)) {
            return false;
        }

        // Cálculo del dígito verificador
        $multiplicadores = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];
        $cuitParaDV = $xy . $numero;
        $suma = 0;

        for ($i = 0; $i < 10; $i++) {
            $suma += $multiplicadores[$i] * $cuitParaDV[$i];
        }

        $resto = $suma % 11;
        $digitoCalculado = 11 - $resto;

        // Casos especiales
        if ($digitoCalculado == 11) {
            $digitoCalculado = 0;
        } elseif ($digitoCalculado == 10) {
            $digitoCalculado = 9;
        }

        // Comparar con el dígito recibido
        return ($digitoCalculado == $digito_verificador);
    }

    /**
     * Actualiza una obra social
     */
    public function actualizarObra(array $data): bool
    {
        $updates = [];
        $params = ['id' => $this->id];

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $updates[] = "$key = :$key";
                $params[$key] = $value;
            }
        }

        if (empty($updates)) {
            return false;
        }

        $params['updated_at'] = date('Y-m-d H:i:s');
        $updates[] = "updated_at = :updated_at";

        $sql = "UPDATE {$this->table} SET " . implode(', ', $updates) . " WHERE id = :id";
        return (bool) DataBase::query($sql, $params);
    }
}