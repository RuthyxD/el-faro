<?php require_once 'views/layout/header.php'; ?>
<main class="container">
    <section id="contacto">
        <h2>Formulario de contacto</h2>
        <p class="text-secondary mb-2">Envíanos dudas, comentarios o sugerencias sobre los contenidos del diario.</p>
        <p class="text-danger small fw-bold mb-3">* Campos obligatorios.</p>

        <form id="form-contacto" action="index.php?controller=contacto&action=procesar" method="post" novalidate>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="contacto-nombre" class="form-label">Nombre completo <span class="text-danger fw-bold ms-1" aria-hidden="true">*</span></label>
                    <input id="contacto-nombre" name="nombre" type="text" class="form-control" maxlength="80" required>
                </div>

                <div class="col-md-6">
                    <label for="contacto-email" class="form-label">Correo electrónico <span class="text-danger fw-bold ms-1" aria-hidden="true">*</span></label>
                    <input id="contacto-email" name="correo" type="email" class="form-control" required>
                </div>

                <div class="col-12">
                    <label for="contacto-mensaje" class="form-label">Mensaje <span class="text-danger fw-bold ms-1" aria-hidden="true">*</span></label>
                    <p class="small fw-bold text-secondary mb-2">Mínimo 10 y máximo 600 caracteres.</p>
                    <textarea id="contacto-mensaje" name="mensaje" class="form-control" minlength="10" maxlength="600" rows="5" required></textarea>
                    <p id="contador-contacto-mensaje" class="small fw-bold text-primary text-end mt-2">0/600</p>
                </div>

                <div class="col-12 d-flex gap-3 flex-wrap align-items-center">
                    <button class="btn btn-primary rounded-pill fw-bold px-4" type="submit">Enviar mensaje</button>
                </div>
            </div>
        </form>
    </section>
</main>
<?php require_once 'views/layout/footer.php'; ?>
