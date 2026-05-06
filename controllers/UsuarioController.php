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
            $nombreCompleto = htmlspecialchars(trim($_POST['nombre_completo']));
            $correo = htmlspecialchars(trim($_POST['correo']));
            $contrasena = trim($_POST['contrasena']);

            // Crear objeto Usuario
            $usuario = new Usuario($nombreCompleto, $correo, $contrasena);

            // Guardar en la BD
            if ($usuario->guardar()) {
                $exito = true;
                $mensaje_resultado = "¡Registro completado correctamente! Ya puedes iniciar sesión.";
            } else {
                $exito = false;
                $mensaje_resultado = "Error en el registro. El correo ya puede estar registrado o hubo un problema.";
            }

            // Mostrar resultado
            require_once 'views/resultado_registro.php';
        } else {
            // Método no permitido, redirigir
            header('Location: index.php?controller=usuario&action=registro');
        }
    }

    public function listar() {
        // Obtener todos los usuarios
        $usuarios = Usuario::obtenerTodos();

        // Mostrar vista de usuarios
        require_once 'views/usuarios.php';
    }
}
?>