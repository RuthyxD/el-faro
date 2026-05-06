<?php require_once 'views/layout/header.php'; ?>
<main class="container">
    <section id="usuarios">
        <h2>Usuarios Registrados</h2>
        <p class="text-secondary mb-3">Listado de todos los usuarios registrados en el sistema.</p>

        <?php if (empty($usuarios)): ?>
            <div class="alert alert-info" role="alert">
                No hay usuarios registrados aún.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>Fecha de Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario->getId()); ?></td>
                                <td><?php echo htmlspecialchars($usuario->getNombreCompleto()); ?></td>
                                <td><?php echo htmlspecialchars($usuario->getCorreo()); ?></td>
                                <td>
                                    <?php 
                                    $fecha = $usuario->getFechaRegistro();
                                    echo date('d/m/Y H:i', strtotime($fecha));
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <p class="text-secondary mt-3">
                <strong>Total de usuarios:</strong> <?php echo count($usuarios); ?>
            </p>
        <?php endif; ?>

        <div class="mt-4">
            <a href="index.php" class="btn btn-primary rounded-pill fw-bold px-4">Volver al inicio</a>
            <a href="index.php?controller=usuario&action=registro" class="btn btn-secondary rounded-pill fw-bold px-4">Nuevo registro</a>
        </div>
    </section>
</main>
<?php require_once 'views/layout/footer.php'; ?>
