<?php require_once 'views/layout/header.php'; ?>
<main class="container">
    <section class="result-wrap">
        <div class="result-card">
            <h2 class="mb-3">Mensaje enviado</h2>
            <p class="mb-2">Gracias por contactarnos, <strong><?php echo htmlspecialchars($contacto->getNombre()); ?></strong>.</p>
            <p class="mb-2"><strong>Correo:</strong> <?php echo htmlspecialchars($contacto->getCorreo()); ?></p>
            <p class="mb-3"><strong>Mensaje:</strong> <?php echo htmlspecialchars($contacto->getMensaje()); ?></p>
            <a class="btn btn-primary" href="index.php">Volver al inicio</a>
        </div>
    </section>
</main>
<?php require_once 'views/layout/footer.php'; ?>
