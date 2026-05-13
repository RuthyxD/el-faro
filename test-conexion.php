<?php
/**
 * test-conexion.php
 * Script de prueba para verificar la configuración y conexión de BD
 * 
 * Uso: Abre este archivo en el navegador: http://localhost/el-faro-php/test-conexion.php
 */

require_once 'config/config.php';
require_once 'models/Database.php';

// Estilos CSS simples para la prueba
$css = "
    body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
    .container { max-width: 800px; margin: 0 auto; }
    .test { padding: 10px; margin: 10px 0; border-left: 4px solid #ccc; }
    .success { border-left-color: #4CAF50; background-color: #f1f8f6; }
    .error { border-left-color: #f44336; background-color: #fef5f5; }
    .info { border-left-color: #2196F3; background-color: #f3f9fe; }
    .test-title { font-weight: bold; margin-bottom: 5px; }
    code { background-color: #f4f4f4; padding: 2px 5px; border-radius: 3px; }
    h1 { color: #333; border-bottom: 2px solid #2196F3; padding-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin: 10px 0; }
    table td { padding: 8px; border: 1px solid #ddd; }
    table tr:nth-child(even) { background-color: #f9f9f9; }
    .label { font-weight: bold; color: #666; }
";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Conexión - El Faro</title>
    <style><?php echo $css; ?></style>
</head>
<body>
    <div class="container">
        <h1>🧪 Prueba de Configuración y Conexión - El Faro</h1>
        
        <h2>1. Verificación de Configuración</h2>
        
        <div class="test info">
            <div class="test-title">📁 Constantes Definidas</div>
            <table>
                <tr>
                    <td class="label">DB_HOST:</td>
                    <td><?php echo DB_HOST; ?></td>
                </tr>
                <tr>
                    <td class="label">DB_NAME:</td>
                    <td><?php echo DB_NAME; ?></td>
                </tr>
                <tr>
                    <td class="label">DB_USER:</td>
                    <td><?php echo DB_USER; ?></td>
                </tr>
                <tr>
                    <td class="label">DB_CHARSET:</td>
                    <td><?php echo DB_CHARSET; ?></td>
                </tr>
                <tr>
                    <td class="label">APP_ENV:</td>
                    <td><?php echo APP_ENV; ?></td>
                </tr>
            </table>
        </div>

        <h2>2. Prueba de Conexión a BD</h2>
        
        <?php
        try {
            $db = new Database();
            $conn = $db->conectar();
            
            if ($conn) {
                echo '<div class="test success">';
                echo '<div class="test-title">✅ Conexión Exitosa</div>';
                echo '<p>Conexión a <strong>' . DB_NAME . '@' . DB_HOST . '</strong> establecida correctamente.</p>';
                echo '</div>';
            }
        } catch (Exception $e) {
            echo '<div class="test error">';
            echo '<div class="test-title">❌ Error de Conexión</div>';
            echo '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<p><strong>Solución:</strong> Verifica las credenciales en <code>config/config.php</code></p>';
            echo '</div>';
        }
        ?>

        <h2>3. Prueba de Operaciones de BD</h2>

        <?php
        try {
            $db = new Database();
            
            // Prueba 1: Contar artículos
            $db->query("SELECT COUNT(*) as total FROM articulos");
            $result = $db->single();
            
            echo '<div class="test success">';
            echo '<div class="test-title">✅ Tabla Artículos</div>';
            echo '<table>';
            echo '<tr><td class="label">Total de artículos:</td><td>' . $result['total'] . '</td></tr>';
            echo '</table>';
            echo '</div>';
        } catch (Exception $e) {
            echo '<div class="test error">';
            echo '<div class="test-title">❌ Error en Tabla Artículos</div>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '</div>';
        }

        try {
            $db = new Database();
            
            // Prueba 2: Contar usuarios
            $db->query("SELECT COUNT(*) as total FROM usuarios");
            $result = $db->single();
            
            echo '<div class="test success">';
            echo '<div class="test-title">✅ Tabla Usuarios</div>';
            echo '<table>';
            echo '<tr><td class="label">Total de usuarios:</td><td>' . $result['total'] . '</td></tr>';
            echo '</table>';
            echo '</div>';
        } catch (Exception $e) {
            echo '<div class="test error">';
            echo '<div class="test-title">❌ Error en Tabla Usuarios</div>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '</div>';
        }

        try {
            $db = new Database();
            
            // Prueba 3: Contar contactos
            $db->query("SELECT COUNT(*) as total FROM contactos");
            $result = $db->single();
            
            echo '<div class="test success">';
            echo '<div class="test-title">✅ Tabla Contactos</div>';
            echo '<table>';
            echo '<tr><td class="label">Total de contactos:</td><td>' . $result['total'] . '</td></tr>';
            echo '</table>';
            echo '</div>';
        } catch (Exception $e) {
            echo '<div class="test error">';
            echo '<div class="test-title">❌ Error en Tabla Contactos</div>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '</div>';
        }
        ?>

        <h2>4. Verificación de Procedimientos Almacenados</h2>

        <?php
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $stmt = $conn->prepare("
                SELECT ROUTINE_NAME 
                FROM INFORMATION_SCHEMA.ROUTINES 
                WHERE ROUTINE_SCHEMA = :db_name 
                AND ROUTINE_TYPE = 'PROCEDURE'
            ");
            $stmt->bindValue(':db_name', DB_NAME);
            $stmt->execute();
            
            $procedimientos = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (count($procedimientos) > 0) {
                echo '<div class="test success">';
                echo '<div class="test-title">✅ Procedimientos Almacenados Encontrados</div>';
                echo '<table>';
                echo '<tr><td class="label">Total de procedimientos:</td><td>' . count($procedimientos) . '</td></tr>';
                echo '<tr><td colspan="2"><strong>Procedimientos detectados:</strong><ul>';
                
                foreach ($procedimientos as $proc) {
                    echo '<li><code>' . htmlspecialchars($proc) . '</code></li>';
                }
                
                echo '</ul></td></tr>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<div class="test error">';
                echo '<div class="test-title">⚠️ No se encontraron procedimientos</div>';
                echo '<p><strong>Solución:</strong> Importa <code>database/procedimientos.sql</code> en phpMyAdmin</p>';
                echo '</div>';
            }
        } catch (Exception $e) {
            echo '<div class="test error">';
            echo '<div class="test-title">❌ Error al verificar procedimientos</div>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '</div>';
        }
        ?>

        <h2>5. Información del Sistema</h2>

        <div class="test info">
            <div class="test-title">ℹ️ Información PHP</div>
            <table>
                <tr>
                    <td class="label">Versión PHP:</td>
                    <td><?php echo phpversion(); ?></td>
                </tr>
                <tr>
                    <td class="label">Extensión PDO:</td>
                    <td><?php echo extension_loaded('pdo') ? '✅ Instalada' : '❌ No instalada'; ?></td>
                </tr>
                <tr>
                    <td class="label">Controlador PDO MySQL:</td>
                    <td><?php echo extension_loaded('pdo_mysql') ? '✅ Instalada' : '❌ No instalada'; ?></td>
                </tr>
                <tr>
                    <td class="label">Sistema Operativo:</td>
                    <td><?php echo php_uname('s'); ?></td>
                </tr>
            </table>
        </div>

        <h2>6. Resumen</h2>

        <div class="test info">
            <div class="test-title">📋 Checklist</div>
            <ul>
                <li>✅ <code>config/config.php</code> - Constantes de configuración</li>
                <li>✅ <code>models/Database.php</code> - Clase PDO mejorada</li>
                <li>✅ <code>models/Articulo.php</code> - Modelo de artículos</li>
                <li>✅ <code>models/Usuario.php</code> - Modelo de usuarios</li>
                <li>✅ <code>models/Contacto.php</code> - Modelo de contactos</li>
                <li>✅ <code>database/procedimientos.sql</code> - Procedimientos almacenados</li>
                <li>✅ <code>README_SEMANA8.md</code> - Documentación técnica</li>
            </ul>
            
            <p style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #ccc;">
                <strong>🎉 ¡Configuración completada!</strong><br>
                Si todas las pruebas fueron exitosas, tu proyecto está listo para usar. 
                <a href="index.php">Ir al sitio principal</a>
            </p>
        </div>
    </div>
</body>
</html>
