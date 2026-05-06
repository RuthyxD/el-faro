-- Artículos de muestra con las imágenes disponibles en assets/media

INSERT INTO `articulos` (`titulo`, `contenido`, `autor`, `categoria`, `seccion`, `imagen`, `fecha_creacion`) VALUES

-- Sección Deporte
('Corrida familiar: Una actividad para toda la familia', 'Participa en nuestra próxima corrida familiar y disfruta de una mañana llena de ejercicio y diversión. Apto para todas las edades.', 'Admin', 'Deportes', 'deporte', 'assets/media/deporte2corrida-familiar.jpg', NOW()),
('Desarrollo de habilidades deportivas en jóvenes', 'Conoce los programas de entrenamiento diseñados para desarrollar habilidades deportivas en los jóvenes de nuestra comunidad.', 'Admin', 'Entrenamientos', 'deporte', 'assets/media/deporte3habilidades-deportivas.jpg', NOW()),

-- Sección Negocios
('Transformación digital: La tienda en línea del futuro', 'Descubre cómo las empresas están revolucionando sus modelos de negocio con plataformas digitales innovadoras.', 'Admin', 'Tecnología', 'negocios', 'assets/media/tienda-digital2.jpg', NOW()),
('Capacitación empresarial: Inversión en talento humano', 'La capacitación continua es clave para el crecimiento empresarial. Conoce nuestros programas de desarrollo profesional.', 'Admin', 'Recursos Humanos', 'negocios', 'assets/media/capacitacion3.jpeg', NOW()),

-- Sección Inicio/Noticias
('Bienvenida a El Faro: Tu portal de información', 'El Faro es tu fuente confiable de noticias, deportes y negocios. Estamos comprometidos con traerte la mejor información actualizada.', 'Admin', 'Noticias', 'inicio', 'assets/media/opcion1.jpg', NOW()),
('Cafetería comunitaria abre sus puertas', 'Un nuevo espacio de encuentro y convivencia en nuestra comunidad. Visita nuestra cafetería y disfruta del mejor ambiente.', 'Admin', 'Comunidad', 'inicio', 'assets/media/cafeteria1.jpg', NOW());
