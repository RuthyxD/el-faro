<?php
// controllers/HomeController.php - Controlador para la página de inicio

require_once 'models/Articulo.php';

class HomeController {
    public function index() {
        // Crear artículos de ejemplo
        $articulos = [
            new Articulo("Gobierno anuncia nuevas medidas de seguridad.", "Actualidad", "La autoridad informó nuevas acciones para reforzar la seguridad ciudadana en distintas regiones del país.", "2026-04-28"),
            new Articulo("Equipo chileno obtiene importante triunfo internacional.", "Deportes", "El equipo nacional logró una destacada participación en el campeonato, generando orgullo entre sus seguidores.", "2026-04-28"),
            new Articulo("Festival cultural reúne a cientos de familias.", "Cultura", "La actividad contó con música, teatro y muestras gastronómicas para promover la participación ciudadana.", "2026-04-28")
        ];

        // Incluir la vista de inicio
        require_once 'views/home.php';
    }
}
?>