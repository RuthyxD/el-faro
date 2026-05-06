<?php
// controllers/HomeController.php - Controlador para la página de inicio

require_once 'models/Articulo.php';

class HomeController {
    public function index() {
        // Obtener artículos desde la BD
        $articulos = Articulo::obtenerTodos();
        
        // Si la BD está vacía, mostrar artículos de ejemplo
        if (empty($articulos)) {
            $articulos = [
                new Articulo(
                    "Gobierno anuncia nuevas medidas de seguridad.",
                    "La autoridad informó nuevas acciones para reforzar la seguridad ciudadana en distintas regiones del país.",
                    "Redactor",
                    "Actualidad",
                    "inicio",
                    "",
                    null,
                    date('Y-m-d H:i:s')
                ),
                new Articulo(
                    "Equipo chileno obtiene importante triunfo internacional.",
                    "El equipo nacional logró una destacada participación en el campeonato, generando orgullo entre sus seguidores.",
                    "Redactor",
                    "Deportes",
                    "deporte",
                    "",
                    null,
                    date('Y-m-d H:i:s')
                ),
                new Articulo(
                    "Festival cultural reúne a cientos de familias.",
                    "La actividad contó con música, teatro y muestras gastronómicas para promover la participación ciudadana.",
                    "Redactor",
                    "Cultura",
                    "inicio",
                    "",
                    null,
                    date('Y-m-d H:i:s')
                )
            ];
        }

        // Incluir la vista de inicio
        require_once 'views/home.php';
    }
}
?>