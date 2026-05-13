-- ============================================================================
-- database/procedimientos.sql
-- Procedimientos Almacenados para El Faro
-- ============================================================================
-- Este archivo contiene todos los procedimientos almacenados utilizados
-- por la aplicación "El Faro". Los procedimientos proporcionan una capa
-- adicional de seguridad y mantenibilidad en las operaciones de base de datos.
-- ============================================================================

USE el_faro;

-- ============================================================================
-- PROCEDIMIENTOS PARA ARTÍCULOS
-- ============================================================================

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_obtener_articulos;

-- Obtener todos los artículos
DELIMITER //
CREATE PROCEDURE sp_obtener_articulos()
BEGIN
    SELECT 
        id,
        titulo,
        contenido,
        autor,
        categoria,
        seccion,
        imagen,
        fecha_creacion,
        fecha_actualizacion
    FROM articulos
    ORDER BY fecha_creacion DESC;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_obtener_articulos_por_seccion;

-- Obtener artículos por sección
DELIMITER //
CREATE PROCEDURE sp_obtener_articulos_por_seccion(
    IN p_seccion VARCHAR(40)
)
BEGIN
    SELECT 
        id,
        titulo,
        contenido,
        autor,
        categoria,
        seccion,
        imagen,
        fecha_creacion,
        fecha_actualizacion
    FROM articulos
    WHERE seccion = p_seccion
    ORDER BY fecha_creacion DESC;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_obtener_articulos_por_categoria;

-- Obtener artículos por categoría
DELIMITER //
CREATE PROCEDURE sp_obtener_articulos_por_categoria(
    IN p_categoria VARCHAR(40)
)
BEGIN
    SELECT 
        id,
        titulo,
        contenido,
        autor,
        categoria,
        seccion,
        imagen,
        fecha_creacion,
        fecha_actualizacion
    FROM articulos
    WHERE categoria = p_categoria
    ORDER BY fecha_creacion DESC;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_obtener_articulo_por_id;

-- Obtener un artículo por ID
DELIMITER //
CREATE PROCEDURE sp_obtener_articulo_por_id(
    IN p_id INT
)
BEGIN
    SELECT 
        id,
        titulo,
        contenido,
        autor,
        categoria,
        seccion,
        imagen,
        fecha_creacion,
        fecha_actualizacion
    FROM articulos
    WHERE id = p_id;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_insertar_articulo;

-- Insertar un nuevo artículo
DELIMITER //
CREATE PROCEDURE sp_insertar_articulo(
    IN p_titulo VARCHAR(120),
    IN p_contenido TEXT,
    IN p_autor VARCHAR(120),
    IN p_categoria VARCHAR(40),
    IN p_seccion VARCHAR(40),
    IN p_imagen VARCHAR(255)
)
BEGIN
    INSERT INTO articulos (titulo, contenido, autor, categoria, seccion, imagen)
    VALUES (p_titulo, p_contenido, p_autor, p_categoria, p_seccion, p_imagen);
    
    SELECT LAST_INSERT_ID() AS id;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_actualizar_articulo;

-- Actualizar un artículo existente
DELIMITER //
CREATE PROCEDURE sp_actualizar_articulo(
    IN p_id INT,
    IN p_titulo VARCHAR(120),
    IN p_contenido TEXT,
    IN p_autor VARCHAR(120),
    IN p_categoria VARCHAR(40),
    IN p_seccion VARCHAR(40),
    IN p_imagen VARCHAR(255)
)
BEGIN
    UPDATE articulos
    SET 
        titulo = p_titulo,
        contenido = p_contenido,
        autor = p_autor,
        categoria = p_categoria,
        seccion = p_seccion,
        imagen = p_imagen,
        fecha_actualizacion = CURRENT_TIMESTAMP
    WHERE id = p_id;
END//
DELIMITER ;

-- ============================================================================
-- PROCEDIMIENTOS PARA USUARIOS
-- ============================================================================

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_obtener_usuarios;

-- Obtener todos los usuarios activos
DELIMITER //
CREATE PROCEDURE sp_obtener_usuarios()
BEGIN
    SELECT 
        id,
        nombre_completo,
        correo,
        fecha_registro,
        activo
    FROM usuarios
    WHERE activo = TRUE
    ORDER BY fecha_registro DESC;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_obtener_usuario_por_id;

-- Obtener un usuario por ID
DELIMITER //
CREATE PROCEDURE sp_obtener_usuario_por_id(
    IN p_id INT
)
BEGIN
    SELECT 
        id,
        nombre_completo,
        correo,
        fecha_registro,
        activo
    FROM usuarios
    WHERE id = p_id;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_obtener_usuario_por_correo;

-- Obtener un usuario por correo
DELIMITER //
CREATE PROCEDURE sp_obtener_usuario_por_correo(
    IN p_correo VARCHAR(120)
)
BEGIN
    SELECT 
        id,
        nombre_completo,
        correo,
        contrasena,
        fecha_registro,
        activo
    FROM usuarios
    WHERE correo = p_correo;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_insertar_usuario;

-- Insertar un nuevo usuario
DELIMITER //
CREATE PROCEDURE sp_insertar_usuario(
    IN p_nombre_completo VARCHAR(120),
    IN p_correo VARCHAR(120),
    IN p_contrasena VARCHAR(255)
)
BEGIN
    INSERT INTO usuarios (nombre_completo, correo, contrasena)
    VALUES (p_nombre_completo, p_correo, p_contrasena);
    
    SELECT LAST_INSERT_ID() AS id;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_verificar_correo_existente;

-- Verificar si un correo ya existe
DELIMITER //
CREATE PROCEDURE sp_verificar_correo_existente(
    IN p_correo VARCHAR(120)
)
BEGIN
    SELECT COUNT(*) AS existe FROM usuarios WHERE correo = p_correo;
END//
DELIMITER ;

-- ============================================================================
-- PROCEDIMIENTOS PARA CONTACTOS
-- ============================================================================

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_obtener_contactos;

-- Obtener todos los contactos
DELIMITER //
CREATE PROCEDURE sp_obtener_contactos()
BEGIN
    SELECT 
        id,
        nombre,
        correo,
        mensaje,
        fecha_registro,
        estado
    FROM contactos
    ORDER BY fecha_registro DESC;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_obtener_contacto_por_id;

-- Obtener un contacto por ID
DELIMITER //
CREATE PROCEDURE sp_obtener_contacto_por_id(
    IN p_id INT
)
BEGIN
    SELECT 
        id,
        nombre,
        correo,
        mensaje,
        fecha_registro,
        estado
    FROM contactos
    WHERE id = p_id;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_insertar_contacto;

-- Insertar un nuevo contacto
DELIMITER //
CREATE PROCEDURE sp_insertar_contacto(
    IN p_nombre VARCHAR(80),
    IN p_correo VARCHAR(120),
    IN p_mensaje TEXT
)
BEGIN
    INSERT INTO contactos (nombre, correo, mensaje)
    VALUES (p_nombre, p_correo, p_mensaje);
    
    SELECT LAST_INSERT_ID() AS id;
END//
DELIMITER ;

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_marcar_contacto_leido;

-- Marcar un contacto como leído
DELIMITER //
CREATE PROCEDURE sp_marcar_contacto_leido(
    IN p_id INT
)
BEGIN
    UPDATE contactos
    SET estado = 'leido'
    WHERE id = p_id;
END//
DELIMITER ;

-- ============================================================================
-- PROCEDIMIENTOS PARA ESTADÍSTICAS
-- ============================================================================

-- Eliminar procedimiento anterior si existe
DROP PROCEDURE IF EXISTS sp_obtener_estadisticas;

-- Obtener estadísticas generales del sitio
DELIMITER //
CREATE PROCEDURE sp_obtener_estadisticas()
BEGIN
    SELECT 
        (SELECT COUNT(*) FROM articulos) AS total_articulos,
        (SELECT COUNT(*) FROM usuarios WHERE activo = TRUE) AS total_usuarios,
        (SELECT COUNT(*) FROM contactos) AS total_contactos,
        (SELECT COUNT(*) FROM contactos WHERE estado = 'sin_leer') AS contactos_sin_leer;
END//
DELIMITER ;

-- ============================================================================
-- FIN DE PROCEDIMIENTOS ALMACENADOS
-- ============================================================================
