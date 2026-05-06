<?php
// models/Usuario.php - Modelo para Usuario

require_once 'Database.php';

class Usuario {
    private $id;
    private $nombreCompleto;
    private $correo;
    private $contrasena;
    private $fecha_registro;
    private $activo;

    // Constructor
    public function __construct($nombreCompleto = null, $correo = null, $contrasena = null, $id = null, $fecha_registro = null, $activo = null) {
        $this->id = $id;
        $this->nombreCompleto = $nombreCompleto;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->fecha_registro = $fecha_registro;
        $this->activo = $activo ?? true;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNombreCompleto() {
        return $this->nombreCompleto;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

    public function getActivo() {
        return $this->activo;
    }

    // Guardar usuario en BD
    public function guardar() {
        try {
            $db = new Database();
            $connection = $db->conectar();
            
            // Verificar si el correo ya existe
            $queryCheck = "SELECT id FROM usuarios WHERE correo = :correo";
            $stmtCheck = $connection->prepare($queryCheck);
            $stmtCheck->bindParam(':correo', $this->correo);
            $stmtCheck->execute();
            
            if ($stmtCheck->rowCount() > 0) {
                return false; // El correo ya existe
            }
            
            // Hash de la contraseña
            $contrasena_hash = password_hash($this->contrasena, PASSWORD_BCRYPT);
            
            $query = "INSERT INTO usuarios (nombre_completo, correo, contrasena) 
                      VALUES (:nombre_completo, :correo, :contrasena)";
            
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':nombre_completo', $this->nombreCompleto);
            $stmt->bindParam(':correo', $this->correo);
            $stmt->bindParam(':contrasena', $contrasena_hash);
            
            $resultado = $stmt->execute();
            
            if ($resultado) {
                $this->id = $connection->lastInsertId();
            }
            
            return $resultado;
        } catch (Exception $e) {
            error_log("Error al guardar usuario: " . $e->getMessage());
            return false;
        }
    }

    // Obtener todos los usuarios
    public static function obtenerTodos() {
        $db = new Database();
        $connection = $db->conectar();
        
        $query = "SELECT id, nombre_completo, correo, fecha_registro, activo FROM usuarios WHERE activo = TRUE ORDER BY fecha_registro DESC";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        
        $usuarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuarios[] = new Usuario(
                $row['nombre_completo'],
                $row['correo'],
                null, // No incluir contraseña en el listado
                $row['id'],
                $row['fecha_registro'],
                $row['activo']
            );
        }
        
        return $usuarios;
    }

    // Obtener un usuario por ID
    public static function obtenerPorId($id) {
        $db = new Database();
        $connection = $db->conectar();
        
        $query = "SELECT id, nombre_completo, correo, fecha_registro, activo FROM usuarios WHERE id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Usuario(
                $row['nombre_completo'],
                $row['correo'],
                null,
                $row['id'],
                $row['fecha_registro'],
                $row['activo']
            );
        }
        
        return null;
    }

    // Obtener un usuario por correo
    public static function obtenerPorCorreo($correo) {
        $db = new Database();
        $connection = $db->conectar();
        
        $query = "SELECT id, nombre_completo, correo, contrasena, fecha_registro, activo FROM usuarios WHERE correo = :correo";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Usuario(
                $row['nombre_completo'],
                $row['correo'],
                $row['contrasena'],
                $row['id'],
                $row['fecha_registro'],
                $row['activo']
            );
        }
        
        return null;
    }

    // Verificar contraseña
    public function verificarContrasena($contrasena) {
        return password_verify($contrasena, $this->contrasena);
    }
}
?>