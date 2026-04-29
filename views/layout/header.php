<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Faro - Periódico Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php
    $controllerActual = $_GET['controller'] ?? 'home';
    $actionActual = $_GET['action'] ?? 'index';
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="assets/media/logo.png" alt="Logo El Faro">
                El Faro
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link <?php echo $controllerActual === 'home' ? 'active' : ''; ?>" href="index.php#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#deporte">Deporte</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#negocios">Negocios</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#nuevo-articulo">Publicar</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $controllerActual === 'usuario' && $actionActual === 'registro' ? 'active' : ''; ?>" href="index.php?controller=usuario&action=registro">Registro</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $controllerActual === 'contacto' && $actionActual === 'formulario' ? 'active' : ''; ?>" href="index.php?controller=contacto&action=formulario">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="site-hero">
        <img src="assets/media/logo.png" alt="Logotipo del periódico El Faro">
        <p>Periódico digital con noticias de actualidad, deporte y negocios</p>
        <div id="datetime-box" class="datetime-display mx-auto" aria-live="polite">
            <span id="current-date" class="datetime-date">--</span>
            <span id="current-time" class="datetime-time">--:--:--</span>
        </div>
    </header>

    <div class="container-fluid px-0">
        <div class="alert mb-0 rounded-0" data-top-alert role="alert">
            <div class="container">
                <strong>📰 Bienvenido a El Faro:</strong> tu fuente confiable de noticias locales, deportes y negocios.
            </div>
        </div>
    </div>
