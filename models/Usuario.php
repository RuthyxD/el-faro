<?php
// models/Usuario.php - Modelo para Usuario

class Usuario {
    private $nombreCompleto;
    private $correo;
    private $contrasena;

    // Constructor
    public function __construct($nombreCompleto, $correo, $contrasena) {
        $this->nombreCompleto = $nombreCompleto;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
    }

    // Getters
    public function getNombreCompleto() {
        return $this->nombreCompleto;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getContrasena() {
        return $this->contrasena;
    }
}
?>