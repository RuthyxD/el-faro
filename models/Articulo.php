<?php
/**
 * models/Articulo.php
 * Modelo para Artículos/Noticias
 * 
 * Utiliza la clase Database para manejar todas las operaciones
 * con la tabla de artículos de forma segura usando PDO.
 */

require_once dirname(dirname(__FILE__)) . '/config/config.php';
require_once 'Database.php';

class Articulo {
    private $id;
    private $titulo;
    private $contenido;
    private $autor;
    private $categoria;
    private $seccion;
    private $imagen;
    private $fecha_creacion;

    // Constructor
    public function __construct($titulo = null, $contenido = null, $autor = null, $categoria = null, $seccion = null, $imagen = null, $id = null, $fecha_creacion = null) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->autor = $autor;
        $this->categoria = $categoria;
        $this->seccion = $seccion;
        $this->imagen = $imagen;
        $this->fecha_creacion = $fecha_creacion;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getSeccion() {
        return $this->seccion;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function getFechaCreacion() {
        return $this->fecha_creacion;
    }

    // Getters para compatibilidad con vistas anteriores
    public function getDescripcion() {
        return $this->contenido;
    }

    public function getFecha() {
        return $this->fecha_creacion;
    }

    // Guardar artículo en BD
    public function guardar() {
        try {
            $db = new Database();
            $connection = $db->conectar();
            
            $query = "INSERT INTO articulos (titulo, contenido, autor, categoria, seccion, imagen) 
                      VALUES (:titulo, :contenido, :autor, :categoria, :seccion, :imagen)";
            
            $stmt = $connection->prepare($query);
            
            // Bind con variables para facilitar debug
            $stmt->bindParam(':titulo', $this->titulo);
            $stmt->bindParam(':contenido', $this->contenido);
            $stmt->bindParam(':autor', $this->autor);
            $stmt->bindParam(':categoria', $this->categoria);
            $stmt->bindParam(':seccion', $this->seccion);
            $stmt->bindParam(':imagen', $this->imagen);
            
            $resultado = $stmt->execute();
            
            // Obtener el ID del artículo insertado
            if ($resultado) {
                $this->id = $connection->lastInsertId();
            }
            
            return $resultado;
        } catch (Exception $e) {
            error_log("Error al guardar artículo: " . $e->getMessage());
            return false;
        }
    }

    // Obtener todos los artículos
    public static function obtenerTodos() {
        try {
            $db = new Database();
            $connection = $db->conectar();
            
            if ($connection === null) {
                error_log("Error: No hay conexión a BD en obtenerTodos()");
                return [];
            }
            
            $query = "SELECT * FROM articulos ORDER BY fecha_creacion DESC";
            $stmt = $connection->prepare($query);
            
            if (!$stmt) {
                error_log("Error: No se pudo preparar la consulta en obtenerTodos()");
                return [];
            }
            
            $stmt->execute();
            
            $articulos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $articulos[] = new Articulo(
                    $row['titulo'],
                    $row['contenido'],
                    $row['autor'],
                    $row['categoria'],
                    $row['seccion'],
                    $row['imagen'] ?? '',
                    $row['id'],
                    $row['fecha_creacion']
                );
            }
            
            error_log("obtenerTodos() retornó " . count($articulos) . " artículos");
            return $articulos;
        } catch (Exception $e) {
            error_log("Error en obtenerTodos(): " . $e->getMessage());
            return [];
        }
    }

    // Obtener artículos por categoría
    public static function obtenerPorCategoria($categoria) {
        try {
            $db = new Database();
            $connection = $db->conectar();
            
            $query = "SELECT * FROM articulos WHERE categoria = :categoria ORDER BY fecha_creacion DESC";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->execute();
            
            $articulos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $articulos[] = new Articulo(
                    $row['titulo'],
                    $row['contenido'],
                    $row['autor'],
                    $row['categoria'],
                    $row['seccion'],
                    $row['imagen'] ?? '',
                    $row['id'],
                    $row['fecha_creacion']
                );
            }
            
            return $articulos;
        } catch (Exception $e) {
            error_log("Error en obtenerPorCategoria(): " . $e->getMessage());
            return [];
        }
    }

    // Obtener artículos por sección
    public static function obtenerPorSeccion($seccion) {
        try {
            $db = new Database();
            $connection = $db->conectar();
            
            $query = "SELECT * FROM articulos WHERE seccion = :seccion ORDER BY fecha_creacion DESC";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':seccion', $seccion);
            $stmt->execute();
            
            $articulos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $articulos[] = new Articulo(
                    $row['titulo'],
                    $row['contenido'],
                    $row['autor'],
                    $row['categoria'],
                    $row['seccion'],
                    $row['imagen'] ?? '',
                    $row['id'],
                    $row['fecha_creacion']
                );
            }
            
            return $articulos;
        } catch (Exception $e) {
            error_log("Error en obtenerPorSeccion(): " . $e->getMessage());
            return [];
        }
    }

    // Obtener un artículo por ID
    public static function obtenerPorId($id) {
        try {
            $db = new Database();
            $connection = $db->conectar();
            
            $query = "SELECT * FROM articulos WHERE id = :id";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Articulo(
                    $row['titulo'],
                    $row['contenido'],
                    $row['autor'],
                    $row['categoria'],
                    $row['seccion'],
                    $row['imagen'] ?? '',
                    $row['id'],
                    $row['fecha_creacion']
                );
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Error en obtenerPorId(): " . $e->getMessage());
            return null;
        }
    }
}
?>