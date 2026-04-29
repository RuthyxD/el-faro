<?php
// models/Articulo.php - Modelo para Artículo o Noticia

class Articulo {
    private $titulo;
    private $categoria;
    private $descripcion;
    private $fecha;

    // Constructor
    public function __construct($titulo, $categoria, $descripcion, $fecha) {
        $this->titulo = $titulo;
        $this->categoria = $categoria;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
    }

    // Getters
    public function getTitulo() {
        return $this->titulo;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getFecha() {
        return $this->fecha;
    }
}
?>