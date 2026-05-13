<?php
/**
 * models/Contacto.php
 * Modelo para Mensajes de Contacto
 * 
 * Utiliza la clase Database para manejar todas las operaciones
 * con la tabla de contactos de forma segura usando PDO.
 */

require_once dirname(dirname(__FILE__)) . '/config/config.php';
require_once 'Database.php';

class Contacto {
    private $id;
    private $nombre;
    private $correo;
    private $mensaje;
    private $fecha_registro;
    private $estado;

    // Constructor
    public function __construct($nombre = null, $correo = null, $mensaje = null, $id = null, $fecha_registro = null, $estado = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->mensaje = $mensaje;
        $this->fecha_registro = $fecha_registro;
        $this->estado = $estado ?? 'sin_leer';
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

    public function getEstado() {
        return $this->estado;
    }

    // Guardar contacto en BD
    public function guardar() {
        try {
            $db = new Database();
            $connection = $db->conectar();
            
            $query = "INSERT INTO contactos (nombre, correo, mensaje) 
                      VALUES (:nombre, :correo, :mensaje)";
            
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':correo', $this->correo);
            $stmt->bindParam(':mensaje', $this->mensaje);
            
            $resultado = $stmt->execute();
            
            if ($resultado) {
                $this->id = $connection->lastInsertId();
            }
            
            return $resultado;
        } catch (Exception $e) {
            error_log("Error al guardar contacto: " . $e->getMessage());
            return false;
        }
    }

    // Obtener todos los contactos
    public static function obtenerTodos() {
        $db = new Database();
        $connection = $db->conectar();
        
        $query = "SELECT * FROM contactos ORDER BY fecha_registro DESC";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        
        $contactos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contactos[] = new Contacto(
                $row['nombre'],
                $row['correo'],
                $row['mensaje'],
                $row['id'],
                $row['fecha_registro'],
                $row['estado']
            );
        }
        
        return $contactos;
    }

    // Obtener un contacto por ID
    public static function obtenerPorId($id) {
        $db = new Database();
        $connection = $db->conectar();
        
        $query = "SELECT * FROM contactos WHERE id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Contacto(
                $row['nombre'],
                $row['correo'],
                $row['mensaje'],
                $row['id'],
                $row['fecha_registro'],
                $row['estado']
            );
        }
        
        return null;
    }

    // Marcar como leído
    public function marcarLeido() {
        $db = new Database();
        $connection = $db->conectar();
        
        $query = "UPDATE contactos SET estado = 'leido' WHERE id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }
}
?>