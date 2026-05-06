<?php
// controllers/ArticuloController.php - Controlador para artículos

require_once 'models/Articulo.php';

class ArticuloController {
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Sanitizar datos
                $titulo = htmlspecialchars(trim($_POST['titulo'] ?? ''));
                $contenido = htmlspecialchars(trim($_POST['resumen'] ?? ''));
                $autor = htmlspecialchars(trim($_POST['autor'] ?? 'Anónimo'));
                $categoria = htmlspecialchars(trim($_POST['categoria'] ?? ''));
                $seccion = htmlspecialchars(trim($_POST['seccion'] ?? ''));
                // La URL de imagen NO debe escaparse, solo usar trim()
                $imagen = trim($_POST['imagen'] ?? '');

                // Validar que los campos obligatorios no estén vacíos
                if (empty($titulo) || empty($contenido) || empty($categoria) || empty($seccion)) {
                    header('Content-Type: application/json');
                    echo json_encode(['exito' => false, 'mensaje' => 'Faltan campos obligatorios.']);
                    exit;
                }

                // Crear objeto Articulo
                $articulo = new Articulo($titulo, $contenido, $autor, $categoria, $seccion, $imagen);

                // Guardar en la BD
                if ($articulo->guardar()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'exito' => true, 
                        'mensaje' => 'Artículo publicado correctamente y guardado en la BD.'
                    ]);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['exito' => false, 'mensaje' => 'Error al guardar el artículo en la BD.']);
                }
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode(['exito' => false, 'mensaje' => 'Error: ' . $e->getMessage()]);
            }
        } else {
            header('Location: index.php');
        }
    }

    public function obtenerPorSeccion($seccion) {
        try {
            $articulos = Articulo::obtenerPorSeccion($seccion);
            header('Content-Type: application/json');
            
            $data = [];
            foreach ($articulos as $articulo) {
                $data[] = [
                    'id' => $articulo->getId(),
                    'titulo' => $articulo->getTitulo(),
                    'contenido' => $articulo->getContenido(),
                    'autor' => $articulo->getAutor(),
                    'categoria' => $articulo->getCategoria(),
                    'imagen' => $articulo->getImagen(),
                    'fecha_creacion' => $articulo->getFechaCreacion()
                ];
            }
            
            echo json_encode($data);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>