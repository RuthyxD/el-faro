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
            $nombre = htmlspecialchars(trim($_POST['nombre']));
            $correo = htmlspecialchars(trim($_POST['correo']));
            $mensaje = htmlspecialchars(trim($_POST['mensaje']));

            // Crear objeto Contacto
            $contacto = new Contacto($nombre, $correo, $mensaje);

            // Guardar en la BD
            if ($contacto->guardar()) {
                $exito = true;
                $mensaje_resultado = "¡Tu mensaje ha sido enviado correctamente! Nos pondremos en contacto pronto.";
            } else {
                $exito = false;
                $mensaje_resultado = "Error al enviar el mensaje. Intenta de nuevo.";
            }

            // Mostrar resultado
            require_once 'views/resultado_contacto.php';
        } else {
            // Método no permitido, redirigir
            header('Location: index.php?controller=contacto&action=formulario');
        }
    }
}
?>