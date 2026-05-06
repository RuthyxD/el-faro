<?php
// setup.php - Script para crear la base de datos y tablas automáticamente

try {
    // Conectar a MySQL sin especificar BD
    $conn = new PDO(
        "mysql:host=localhost;charset=utf8",
        "root",
        ""
    );
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear base de datos
    $conn->exec("CREATE DATABASE IF NOT EXISTS el_faro");
    
    // Seleccionar la BD
    $conn->exec("USE el_faro");

    // Eliminar tablas si existen (para hacer reset limpio)
    $conn->exec("DROP TABLE IF EXISTS contactos");
    $conn->exec("DROP TABLE IF EXISTS articulos");
    $conn->exec("DROP TABLE IF EXISTS usuarios");

    // Crear tabla de Artículos
    $conn->exec("
        CREATE TABLE articulos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(120) NOT NULL,
            contenido TEXT NOT NULL,
            autor VARCHAR(120) NOT NULL,
            categoria VARCHAR(40) NOT NULL,
            seccion VARCHAR(40) NOT NULL,
            imagen VARCHAR(255),
            fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
            fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            KEY idx_articulos_categoria (categoria),
            KEY idx_articulos_seccion (seccion),
            KEY idx_articulos_fecha (fecha_creacion)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Crear tabla de Contactos
    $conn->exec("
        CREATE TABLE contactos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(80) NOT NULL,
            correo VARCHAR(120) NOT NULL,
            mensaje TEXT NOT NULL,
            fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
            estado VARCHAR(20) DEFAULT 'sin_leer',
            KEY idx_contactos_estado (estado)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Crear tabla de Usuarios
    $conn->exec("
        CREATE TABLE usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre_completo VARCHAR(120) NOT NULL,
            correo VARCHAR(120) NOT NULL UNIQUE,
            contrasena VARCHAR(255) NOT NULL,
            fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
            activo BOOLEAN DEFAULT TRUE,
            KEY idx_usuarios_correo (correo)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    echo "<div style='background-color: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px; border: 1px solid #c3e6cb;'>";
    echo "<h2>✅ ¡Éxito!</h2>";
    echo "<p>La base de datos <strong>el_faro</strong> y todas las tablas han sido creadas correctamente.</p>";
    echo "<p>Ya puedes <a href='index.php' style='color: #155724; font-weight: bold;'>ir al inicio</a> del sitio.</p>";
    echo "</div>";

} catch (PDOException $e) {
    echo "<div style='background-color: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; margin: 20px; border: 1px solid #f5c6cb;'>";
    echo "<h2>❌ Error</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Verifica que:</p>";
    echo "<ul>";
    echo "<li>MySQL esté ejecutándose en XAMPP</li>";
    echo "<li>El usuario sea 'root' sin contraseña</li>";
    echo "<li>El puerto sea el default (3306)</li>";
    echo "</ul>";
    echo "</div>";
}
?>
