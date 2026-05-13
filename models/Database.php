<?php
/**
 * models/Database.php
 * Clase de conexión y manejo de base de datos usando PDO
 * 
 * Esta clase proporciona métodos reutilizables para:
 * - Conectarse a la base de datos MySQL
 * - Preparar consultas SQL
 * - Ejecutar sentencias preparadas
 * - Obtener resultados de consultas
 * - Manejar excepciones de PDO
 */

require_once dirname(dirname(__FILE__)) . '/config/config.php';

class Database {
    private $conn;
    private $stmt;

    /**
     * Conecta a la base de datos usando PDO
     * 
     * @return PDO Conexión a la base de datos
     * @throws PDOException Si ocurre un error de conexión
     */
    public function conectar() {
        $this->conn = null;

        try {
            // Construir DSN (Data Source Name)
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            
            // Crear conexión PDO
            $this->conn = new PDO(
                $dsn,
                DB_USER,
                DB_PASS
            );

            // Configurar modo de error para PDO
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Configurar para devolver arrays asociativos por defecto
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            if (SHOW_ERRORS) {
                echo "Error de conexión: " . $e->getMessage();
                die();
            }
            throw new PDOException("Error al conectar a la base de datos");
        }

        return $this->conn;
    }

    /**
     * Prepara una consulta SQL
     * 
     * @param string $query Consulta SQL a preparar
     * @return void
     */
    public function query($query) {
        try {
            if (!$this->conn) {
                $this->conectar();
            }
            $this->stmt = $this->conn->prepare($query);
        } catch(PDOException $e) {
            if (SHOW_ERRORS) {
                echo "Error en la consulta: " . $e->getMessage();
                die();
            }
            throw new PDOException("Error al preparar la consulta");
        }
    }

    /**
     * Vincula un valor a un parámetro con nombre
     * 
     * @param string $param Nombre del parámetro (ej: ':id')
     * @param mixed $value Valor a vincular
     * @param int $type Tipo de dato PDO (opcional)
     * @return void
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        try {
            $this->stmt->bindValue($param, $value, $type);
        } catch(PDOException $e) {
            if (SHOW_ERRORS) {
                echo "Error al vincular parámetro: " . $e->getMessage();
                die();
            }
            throw new PDOException("Error al vincular parámetro");
        }
    }

    /**
     * Ejecuta la consulta preparada
     * 
     * @return bool True si la ejecución fue exitosa, false en caso contrario
     */
    public function execute() {
        try {
            return $this->stmt->execute();
        } catch(PDOException $e) {
            if (SHOW_ERRORS) {
                echo "Error al ejecutar la consulta: " . $e->getMessage();
                die();
            }
            throw new PDOException("Error al ejecutar la consulta");
        }
    }

    /**
     * Retorna múltiples registros como array
     * 
     * @return array Array con los resultados
     */
    public function resultSet() {
        try {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            if (SHOW_ERRORS) {
                echo "Error al obtener resultados: " . $e->getMessage();
                die();
            }
            throw new PDOException("Error al obtener resultados");
        }
    }

    /**
     * Retorna un único registro como array asociativo
     * 
     * @return array|false Array con el registro o false si no hay resultados
     */
    public function single() {
        try {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            if (SHOW_ERRORS) {
                echo "Error al obtener un registro: " . $e->getMessage();
                die();
            }
            throw new PDOException("Error al obtener un registro");
        }
    }

    /**
     * Retorna la cantidad de filas afectadas por la última consulta
     * 
     * @return int Número de filas afectadas
     */
    public function rowCount() {
        try {
            return $this->stmt->rowCount();
        } catch(PDOException $e) {
            if (SHOW_ERRORS) {
                echo "Error al contar filas: " . $e->getMessage();
                die();
            }
            throw new PDOException("Error al contar filas");
        }
    }

    /**
     * Retorna el ID del último registro insertado
     * 
     * @return string ID del último registro insertado
     */
    public function lastInsertId() {
        try {
            return $this->conn->lastInsertId();
        } catch(PDOException $e) {
            if (SHOW_ERRORS) {
                echo "Error al obtener último ID: " . $e->getMessage();
                die();
            }
            throw new PDOException("Error al obtener último ID");
        }
    }

    /**
     * Obtiene la conexión actual
     * 
     * @return PDO Conexión a la base de datos
     */
    public function getConnection() {
        if (!$this->conn) {
            $this->conectar();
        }
        return $this->conn;
    }

    /**
     * Cierra la conexión a la base de datos
     * 
     * @return void
     */
    public function desconectar() {
        $this->conn = null;
    }
}
?>

