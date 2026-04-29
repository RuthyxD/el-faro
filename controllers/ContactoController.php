<?php
// controllers/ContactoController.php - Controlador para contacto

require_once 'models/Contacto.php';

class ContactoController {
    public function formulario() {
        // Mostrar el formulario de contacto
        require_once 'views/contacto.php';
    }

    public function procesar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar datos
            $nombre = htmlspecialchars($_POST['nombre']);
            $correo = htmlspecialchars($_POST['correo']);
            $mensaje = htmlspecialchars($_POST['mensaje']);

            // Crear objeto Contacto
            $contacto = new Contacto($nombre, $correo, $mensaje);

            // Simular procesamiento (no hay BD)
            // Mostrar resultado
            require_once 'views/resultado_contacto.php';
        } else {
            // Método no permitido, redirigir
            header('Location: index.php?controller=contacto&action=formulario');
        }
    }
}
?>