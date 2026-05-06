<?php
// Script para agregar artículos de muestra con las imágenes disponibles

require_once 'models/Database.php';

try {
    $db = new Database();
    $conexion = $db->conectar();
    
    // Artículos de muestra
    $articulos = [
        [
            'titulo' => 'Corrida familiar: Una actividad para toda la familia',
            'contenido' => 'Participa en nuestra próxima corrida familiar y disfruta de una mañana llena de ejercicio y diversión. Apto para todas las edades.',
            'autor' => 'Admin',
            'categoria' => 'Deportes',
            'seccion' => 'deporte',
            'imagen' => 'assets/media/deporte2corrida-familiar.jpg'
        ],
        [
            'titulo' => 'Desarrollo de habilidades deportivas en jóvenes',
            'contenido' => 'Conoce los programas de entrenamiento diseñados para desarrollar habilidades deportivas en los jóvenes de nuestra comunidad.',
            'autor' => 'Admin',
            'categoria' => 'Entrenamientos',
            'seccion' => 'deporte',
            'imagen' => 'assets/media/deporte3habilidades-deportivas.jpg'
        ],
        [
            'titulo' => 'Transformación digital: La tienda en línea del futuro',
            'contenido' => 'Descubre cómo las empresas están revolucionando sus modelos de negocio con plataformas digitales innovadoras.',
            'autor' => 'Admin',
            'categoria' => 'Tecnología',
            'seccion' => 'negocios',
            'imagen' => 'assets/media/tienda-digital2.jpg'
        ],
        [
            'titulo' => 'Capacitación empresarial: Inversión en talento humano',
            'contenido' => 'La capacitación continua es clave para el crecimiento empresarial. Conoce nuestros programas de desarrollo profesional.',
            'autor' => 'Admin',
            'categoria' => 'Recursos Humanos',
            'seccion' => 'negocios',
            'imagen' => 'assets/media/capacitacion3.jpeg'
        ],
        [
            'titulo' => 'Bienvenida a El Faro: Tu portal de información',
            'contenido' => 'El Faro es tu fuente confiable de noticias, deportes y negocios. Estamos comprometidos con traerte la mejor información actualizada.',
            'autor' => 'Admin',
            'categoria' => 'Noticias',
            'seccion' => 'inicio',
            'imagen' => 'assets/media/opcion1.jpg'
        ],
        [
            'titulo' => 'Cafetería comunitaria abre sus puertas',
            'contenido' => 'Un nuevo espacio de encuentro y convivencia en nuestra comunidad. Visita nuestra cafetería y disfruta del mejor ambiente.',
            'autor' => 'Admin',
            'categoria' => 'Comunidad',
            'seccion' => 'inicio',
            'imagen' => 'assets/media/cafeteria1.jpg'
        ]
    ];
    
    $sqlInsert = "INSERT INTO articulos (titulo, contenido, autor, categoria, seccion, imagen, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conexion->prepare($sqlInsert);
    
    $insertados = 0;
    foreach ($articulos as $articulo) {
        try {
            $stmt->execute([
                $articulo['titulo'],
                $articulo['contenido'],
                $articulo['autor'],
                $articulo['categoria'],
                $articulo['seccion'],
                $articulo['imagen']
            ]);
            $insertados++;
        } catch (Exception $e) {
            error_log("Error insertando artículo: " . $e->getMessage());
        }
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; text-align: center;'>";
    echo "<h3>✓ Éxito</h3>";
    echo "<p>Se agregaron <strong>$insertados artículos de muestra</strong> con las imágenes disponibles.</p>";
    echo "<p><a href='index.php?controller=home&action=index' style='color: #155724; text-decoration: underline;'>Ver artículos →</a></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; text-align: center;'>";
    echo "<h3>✗ Error</h3>";
    echo "<p>Error al agregar artículos: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}
?>
