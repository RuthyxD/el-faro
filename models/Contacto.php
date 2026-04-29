<?php
// models/Contacto.php - Modelo para Contacto

class Contacto {
    private $nombre;
    private $correo;
    private $mensaje;

    // Constructor
    public function __construct($nombre, $correo, $mensaje) {
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->mensaje = $mensaje;
    }

    // Getters
    public function getNombre() {
        return $this->nombre;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getMensaje() {
        return $this->mensaje;
    }
}
?>