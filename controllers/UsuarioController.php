<?php
// controllers/UsuarioController.php - Controlador para usuario

require_once 'models/Usuario.php';

class UsuarioController {
    public function registro() {
        // Mostrar el formulario de registro
        require_once 'views/registro.php';
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar datos
            $nombreCompleto = htmlspecialchars($_POST['nombre_completo']);
            $correo = htmlspecialchars($_POST['correo']);
            $contrasena = htmlspecialchars($_POST['contrasena']);

            // Crear objeto Usuario
            $usuario = new Usuario($nombreCompleto, $correo, $contrasena);

            // Simular procesamiento (no hay BD)
            // Mostrar resultado
            require_once 'views/resultado_registro.php';
        } else {
            // Método no permitido, redirigir
            header('Location: index.php?controller=usuario&action=registro');
        }
    }
}
?>