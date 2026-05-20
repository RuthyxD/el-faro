<?php require_once 'views/layout/header.php'; ?>
<main class="container">
    <section id="contacto">
        <h2>Formulario de contacto</h2>
        <p class="text-secondary mb-4">Envíanos dudas, comentarios o sugerencias sobre los contenidos del diario. Nos encantaría escucharte.</p>

        <!-- Mensaje de éxito (inicialmente oculto) -->
        <div id="form-success-message" class="alert alert-success d-none mb-4" role="alert" aria-live="assertive">
            ¡Mensaje enviado exitosamente! Nos pondremos en contacto pronto.
        </div>

        <!-- Mensaje de error (inicialmente oculto) -->
        <div id="form-error-message" class="alert alert-danger d-none mb-4" role="alert" aria-live="assertive">
            <span id="error-text">Error al enviar el formulario</span>
        </div>

        <form id="form-contacto" action="index.php?controller=contacto&action=procesar" method="post" novalidate>
            <div class="row g-3">
                <div class="col-md-6 form-group-wrapper">
                    <label for="contacto-nombre" class="form-label">
                        Nombre completo 
                        <span class="text-danger fw-bold" aria-hidden="true">*</span>
                        <span class="visually-hidden">(requerido)</span>
                    </label>
                    <input 
                        id="contacto-nombre" 
                        name="nombre" 
                        type="text" 
                        class="form-control" 
                        maxlength="80"
                        placeholder="Juan Pérez"
                        required
                        aria-describedby="nombre-error"
                    >
                    <div class="form-error-message" id="nombre-error">Por favor, ingresa tu nombre completo.</div>
                </div>

                <div class="col-md-6 form-group-wrapper">
                    <label for="contacto-email" class="form-label">
                        Correo electrónico 
                        <span class="text-danger fw-bold" aria-hidden="true">*</span>
                        <span class="visually-hidden">(requerido)</span>
                    </label>
                    <input 
                        id="contacto-email" 
                        name="correo" 
                        type="email" 
                        class="form-control"
                        placeholder="juan@ejemplo.com"
                        required
                        aria-describedby="correo-error"
                    >
                    <div class="form-error-message" id="correo-error">Por favor, ingresa un correo válido.</div>
                </div>

                <div class="col-12 form-group-wrapper">
                    <label for="contacto-mensaje" class="form-label">
                        Mensaje 
                        <span class="text-danger fw-bold" aria-hidden="true">*</span>
                        <span class="visually-hidden">(requerido)</span>
                    </label>
                    <p class="small text-secondary mb-2">Mínimo 10 y máximo 600 caracteres.</p>
                    <textarea 
                        id="contacto-mensaje" 
                        name="mensaje" 
                        class="form-control" 
                        minlength="10" 
                        maxlength="600" 
                        rows="5"
                        placeholder="Escribe tu mensaje aquí..."
                        required
                        aria-describedby="mensaje-error contador-contacto-mensaje"
                    ></textarea>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="form-error-message" id="mensaje-error">El mensaje debe tener entre 10 y 600 caracteres.</div>
                        <p id="contador-contacto-mensaje" class="char-counter normal mb-0">0/600</p>
                    </div>
                </div>

                <div class="col-12 form-button-group">
                    <button 
                        class="btn btn-form-submit" 
                        type="submit"
                        id="btn-submit-contacto"
                    >
                        <span id="btn-text">Enviar mensaje</span>
                    </button>
                </div>
            </div>
        </form>
    </section>
</main>
<?php require_once 'views/layout/footer.php'; ?>
