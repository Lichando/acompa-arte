<?php
/**
 * Conexión con la Base de Datos utilizando PDO
 */
class DataBase
{
    private static $host = "localhost";
    private static $dbname = "sistema_terapeutico";
    private static $dbuser = "root";
    private static $dbpass = "";

    private static $dbh = null; // Database handler
    private static $error;

    // Obtener una instancia de la conexión PDO
    public static function connection()
    {
        if (self::$dbh === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname;
            $opciones = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            try {
                self::$dbh = new PDO($dsn, self::$dbuser, self::$dbpass, $opciones);
                self::$dbh->exec('SET NAMES utf8');
                self::$dbh->exec('SET time_zone = "-03:00";');
            } catch (PDOException $e) {
                self::$error = $e->getMessage();
                throw new Exception("Error de conexión: " . self::$error);
            }
        }
        return self::$dbh;
    }

    // Ejecutar una consulta con parámetros
    public static function query($sql, $params = [])
    {
        $statement = self::prepareAndExecute($sql, $params);
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Ejecutar un SQL que no requiere obtener resultados
    public static function execute($sql, $params = [])
    {
        $stmt = self::prepareAndExecute($sql, $params);
        if ($stmt === false) {
            return false;  // O podrías lanzar excepción, según tu manejo de errores
        }
        return $stmt->rowCount();
    }


    // Obtener el número de registros afectados
    public static function rowCount($sql, $params = [])
    {
        return self::prepareAndExecute($sql, $params)->rowCount();
    }

    // Obtener nombres de columnas de una tabla
    public static function getColumnsNames($table)
    {
        $sql = "SELECT column_name FROM information_schema.columns WHERE table_name = :table";
        return self::query($sql, ['table' => $table]);
    }

    // Ejecutar una transacción
    public static function ejecutar($sql)
    {
        $dbh = self::connection();
        try {
            $dbh->beginTransaction();
            $statement = $dbh->prepare($sql);
            $statement->execute();
            $dbh->commit();
            return ['state' => true, 'notification' => 'Operación exitosa'];
        } catch (PDOException $e) {
            $dbh->rollBack();
            return ['state' => false, 'notification' => $e->errorInfo[2] ?? 'Error desconocido'];
        }
    }

    // Preparar y ejecutar una consulta con manejo de excepciones
    private static function prepareAndExecute($sql, $params = [])
    {
        $statement = self::connection()->prepare($sql);
        try {
            $statement->execute($params);
        } catch (PDOException $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
        return $statement;
    }

    public static function getRecord(string $sql, array $params = []): ?array
    {
        try {
            $stmt = self::executeStatement($sql, $params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Database getRecord error: " . $e->getMessage());
            return null;
        }
    }

    public static function getRecords(string $sql, array $params = []): array
    {
        try {
            $stmt = self::executeStatement($sql, $params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log("Database getRecords error: " . $e->getMessage());
            return [];
        }
    }
    private static function executeStatement(string $sql, array $params = []): PDOStatement
    {
        $pdo = self::connection();
        $stmt = $pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(is_int($key) ? $key + 1 : ":$key", $value, $paramType);
        }

        $stmt->execute();
        return $stmt;
    }
    public static function beginTransaction()
    {
        $conn = self::connection();
        return $conn->beginTransaction();
    }

    public static function commit()
    {
        $conn = self::connection();
        return $conn->commit();
    }

    public static function rollBack()
    {
        $conn = self::connection();
        return $conn->rollBack();
    }
}

