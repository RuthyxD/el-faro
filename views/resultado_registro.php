<?php require_once 'views/layout/header.php'; ?>
<main class="container">
    <section class="result-wrap">
        <div class="result-card">
            <h2 class="mb-3">Registro exitoso</h2>
            <p class="mb-2"><strong>Usuario:</strong> <?php echo htmlspecialchars($usuario->getNombreCompleto()); ?></p>
            <p class="mb-2"><strong>Correo:</strong> <?php echo htmlspecialchars($usuario->getCorreo()); ?></p>
            <p class="mb-3"><strong>Contraseña:</strong> recibida correctamente.</p>
            <a class="btn btn-primary" href="index.php">Ir a portada</a>
        </div>
    </section>
</main>
<?php require_once 'views/layout/footer.php'; ?>
