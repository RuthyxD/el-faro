<?php require_once 'views/layout/header.php'; ?>
<main class="container">
    <section id="registro">
        <h2>Registro de cuenta</h2>
        <p class="text-secondary mb-2">Crea tu cuenta para recibir novedades y participar en la comunidad de El Faro.</p>
        <p class="text-danger small fw-bold mb-3">* Campos obligatorios.</p>

        <form action="index.php?controller=usuario&action=registrar" method="post" novalidate>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre_completo" class="form-label">Nombre completo <span class="text-danger fw-bold ms-1" aria-hidden="true">*</span></label>
                    <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" maxlength="120" required>
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo electrónico <span class="text-danger fw-bold ms-1" aria-hidden="true">*</span></label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>
                <div class="col-md-6">
                    <label for="contrasena" class="form-label">Contraseña <span class="text-danger fw-bold ms-1" aria-hidden="true">*</span></label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" minlength="6" required>
                </div>
                <div class="col-12 d-flex gap-3 flex-wrap align-items-center">
                    <button type="submit" class="btn btn-primary rounded-pill fw-bold px-4">Registrar cuenta</button>
                </div>
            </div>
        </form>
    </section>
</main>
<?php require_once 'views/layout/footer.php'; ?>
