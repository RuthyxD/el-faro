<?php require_once 'views/layout/header.php'; ?>
<main class="container">
    <section id="registro">
        <h2>Registro de cuenta</h2>
        <p class="text-secondary mb-4">Crea tu cuenta para recibir novedades y participar en la comunidad de El Faro.</p>

        <!-- Mensaje de éxito (inicialmente oculto) -->
        <div id="form-success-message-registro" class="alert alert-success d-none mb-4" role="alert" aria-live="assertive">
            ¡Cuenta creada exitosamente! Ya puedes disfrutar de El Faro.
        </div>

        <!-- Mensaje de error (inicialmente oculto) -->
        <div id="form-error-message-registro" class="alert alert-danger d-none mb-4" role="alert" aria-live="assertive">
            <span id="error-text-registro">Error al crear la cuenta</span>
        </div>

        <form id="form-registro" action="index.php?controller=usuario&action=registrar" method="post" novalidate>
            <div class="row g-3">
                <div class="col-md-6 form-group-wrapper">
                    <label for="nombre_completo" class="form-label">
                        Nombre completo 
                        <span class="text-danger fw-bold" aria-hidden="true">*</span>
                        <span class="visually-hidden">(requerido)</span>
                    </label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="nombre_completo" 
                        name="nombre_completo" 
                        maxlength="120"
                        placeholder="Juan Pérez García"
                        required
                        aria-describedby="nombre-error-registro"
                    >
                    <div class="form-error-message" id="nombre-error-registro">Por favor, ingresa tu nombre completo.</div>
                </div>

                <div class="col-md-6 form-group-wrapper">
                    <label for="correo" class="form-label">
                        Correo electrónico 
                        <span class="text-danger fw-bold" aria-hidden="true">*</span>
                        <span class="visually-hidden">(requerido)</span>
                    </label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="correo" 
                        name="correo"
                        placeholder="tu@ejemplo.com"
                        required
                        aria-describedby="correo-error-registro"
                    >
                    <div class="form-error-message" id="correo-error-registro">Por favor, ingresa un correo electrónico válido.</div>
                </div>

                <div class="col-md-6 form-group-wrapper">
                    <label for="contrasena" class="form-label">
                        Contraseña 
                        <span class="text-danger fw-bold" aria-hidden="true">*</span>
                        <span class="visually-hidden">(requerido)</span>
                        <small>Mínimo 6 caracteres</small>
                    </label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="contrasena" 
                        name="contrasena" 
                        minlength="6"
                        placeholder="••••••••"
                        required
                        aria-describedby="contrasena-error"
                    >
                    <div class="form-error-message" id="contrasena-error">La contraseña debe tener al menos 6 caracteres.</div>
                </div>

                <div class="col-md-6 form-group-wrapper">
                    <label for="contrasena_confirma" class="form-label">
                        Confirmar contraseña 
                        <span class="text-danger fw-bold" aria-hidden="true">*</span>
                        <span class="visually-hidden">(requerido)</span>
                    </label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="contrasena_confirma" 
                        name="contrasena_confirma"
                        minlength="6"
                        placeholder="••••••••"
                        required
                        aria-describedby="contrasena-confirma-error"
                    >
                    <div class="form-error-message" id="contrasena-confirma-error">Las contraseñas no coinciden.</div>
                </div>

                <div class="col-12 form-button-group">
                    <button 
                        type="submit" 
                        class="btn btn-form-submit"
                        id="btn-submit-registro"
                    >
                        <span id="btn-text-registro">Crear cuenta</span>
                    </button>
                </div>
            </div>
        </form>
    </section>
</main>
<?php require_once 'views/layout/footer.php'; ?>
