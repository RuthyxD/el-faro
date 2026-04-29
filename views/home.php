<?php require_once 'views/layout/header.php'; ?>
<div class="container">
    <div class="section-directory" aria-label="Acceso rápido a secciones">
        <h2>Secciones del sitio</h2>
        <p>Acceso directo a los apartados principales para navegar sin perder contexto.</p>
        <div class="section-links">
            <a href="#inicio"><small class="fw-bold text-secondary">01</small> Inicio</a>
            <a href="#deporte"><small class="fw-bold text-secondary">02</small> Deporte</a>
            <a href="#negocios"><small class="fw-bold text-secondary">03</small> Negocios</a>
            <a href="#nuevo-articulo"><small class="fw-bold text-secondary">04</small> Publicar</a>
            <a href="index.php?controller=contacto&action=formulario"><small class="fw-bold text-secondary">05</small> Contacto</a>
        </div>
    </div>
</div>

<div class="container">
    <section id="recientes" aria-labelledby="recientes-title">
        <div class="d-flex align-items-end justify-content-between gap-3 mb-3">
            <div>
                <h2 id="recientes-title">Últimas publicaciones</h2>
                <p class="text-secondary mb-0">Vista destacada de los artículos más recientes para que lo nuevo se vea primero.</p>
            </div>
        </div>
        <?php
        $imagenesRecientes = [
            'assets/media/opcion1.jpg',
            'assets/media/deporte1.jpg',
            'assets/media/cafeteria1.jpg'
        ];
        $recientes = [];
        foreach ($articulos as $index => $articulo) {
            $recientes[] = [
                'titulo' => $articulo->getTitulo(),
                'categoria' => $articulo->getCategoria(),
                'descripcion' => $articulo->getDescripcion(),
                'imagen' => $imagenesRecientes[$index] ?? 'assets/media/opcion3.png',
                'seccion' => 'Inicio'
            ];
        }
        ?>

        <div id="recent-articles-view" aria-live="polite"></div>
        <div id="recent-articles-mini" class="row g-3 mt-1" aria-label="Otras publicaciones"></div>
        <script type="application/json" id="recent-articles-data"><?php echo json_encode($recientes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>
    </section>
</div>

<main class="container">
    <section id="inicio">
        <h2>Sección de artículos de noticias <span class="badge rounded-pill text-primary-emphasis bg-primary-subtle ms-2" data-section-count="inicio">(Artículos: <?php echo count($articulos); ?>)</span></h2>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mt-2" id="inicio-grid">
            <?php
            $imagenesInicio = [
                'assets/media/opcion1.jpg',
                'assets/media/opcion2.jpg',
                'assets/media/opcion3.png'
            ];
            foreach ($articulos as $index => $articulo):
                $imagen = $imagenesInicio[$index] ?? 'assets/media/opcion3.png';
            ?>
                <article class="card h-100 border-0 overflow-hidden" data-article-card>
                    <img src="<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo htmlspecialchars($articulo->getTitulo()); ?>">
                    <div class="card-body d-flex flex-column" data-article-content>
                        <span class="badge rounded-pill text-uppercase align-self-start mb-2" data-category-badge><?php echo htmlspecialchars($articulo->getCategoria()); ?></span>
                        <h3><?php echo htmlspecialchars($articulo->getTitulo()); ?></h3>
                        <p><?php echo htmlspecialchars($articulo->getDescripcion()); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="mt-4">
            <div id="multimedia-wrap" class="row g-4">
                <div class="col-lg-7">
                    <div class="p-3 rounded-4 h-100" data-media-item>
                        <h3>🎬 Video destacado</h3>
                        <video controls>
                            <source src="assets/media/noticia-video-web.mp4" type="video/mp4">
                            Tu navegador no soporta la reproducción de video en HTML5.
                        </video>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="p-3 rounded-4 h-100" data-media-item>
                        <h3>🎙️ Audio informativo</h3>
                        <img id="audio-cover" src="assets/media/imagen-audio.png" alt="Imagen de contexto para audio informativo">
                        <audio controls>
                            <source src="assets/media/audio.mp3" type="audio/mpeg">
                            Tu navegador no soporta la reproducción de audio en HTML5.
                        </audio>
                        <p class="mt-2"><strong>Informativos:</strong> resumen diario con los temas más relevantes de actualidad nacional.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="deporte">
        <h2>Sección de deporte <span class="badge rounded-pill text-primary-emphasis bg-primary-subtle ms-2" data-section-count="deporte">(Artículos: 3)</span></h2>

        <div class="row g-4 mt-2">
            <div class="col-lg-8">
                <article class="card h-100 border-0 overflow-hidden" data-article-card>
                    <img src="assets/media/deporte1.jpg" alt="Equipo local celebrando campeonato regional">
                    <div class="card-body d-flex flex-column" data-article-content>
                        <span class="badge rounded-pill text-uppercase align-self-start mb-2" data-category-badge>Fútbol</span>
                        <h3>Con final dramática, el equipo local se queda con el título regional</h3>
                        <p>El triunfo se definió en los últimos minutos y desató una celebración masiva en la comuna. Jugadores e hinchas destacaron el trabajo de toda la temporada y el apoyo de la comunidad.</p>
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <div id="deporte-grid" class="d-flex flex-column gap-4">
                    <article class="card h-100 border-0 overflow-hidden" data-article-card>
                        <img src="assets/media/deporte2corrida-familiar.jpg" alt="Participantes en corrida familiar comunitaria">
                        <div class="card-body d-flex flex-column" data-article-content>
                            <span class="badge rounded-pill text-uppercase align-self-start mb-2" data-category-badge>Atletismo</span>
                            <h3>Corrida familiar reúne a cientos de vecinos en jornada deportiva</h3>
                            <p>Actividad que combinó deporte, recreación y vida saludable para todas las edades.</p>
                        </div>
                    </article>
                    <article class="card h-100 border-0 overflow-hidden" data-article-card>
                        <img src="assets/media/deporte3habilidades-deportivas.jpg" alt="Estudiantes en entrenamiento de habilidades deportivas">
                        <div class="card-body d-flex flex-column" data-article-content>
                            <span class="badge rounded-pill text-uppercase align-self-start mb-2" data-category-badge>Formación deportiva</span>
                            <h3>Escuela abre taller formativo de básquetbol para estudiantes</h3>
                            <p>El nuevo taller buscará fortalecer habilidades técnicas, trabajo en equipo y disciplina.</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section id="negocios">
        <h2>Sección de Negocios <span class="badge rounded-pill text-primary-emphasis bg-primary-subtle ms-2" data-section-count="negocios">(Artículos: 3)</span></h2>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mt-2" id="negocios-grid">
            <article class="card h-100 border-0 overflow-hidden" data-article-card>
                <img src="assets/media/cafeteria1.jpg" alt="Cafetería local mejorando su servicio a domicilio">
                <div class="card-body d-flex flex-column" data-article-content>
                    <span class="badge rounded-pill text-uppercase align-self-start mb-2" data-category-badge>Emprendimiento</span>
                    <h3>Cafetería local amplía su servicio a domicilio</h3>
                    <p>La cafetería sumó reparto propio y promociones semanales para ampliar cobertura en la comuna.</p>
                </div>
            </article>
            <article class="card h-100 border-0 overflow-hidden" data-article-card>
                <img src="assets/media/tienda-digital2.jpg" alt="Jóvenes emprendedores en tienda digital de artesanías">
                <div class="card-body d-flex flex-column" data-article-content>
                    <span class="badge rounded-pill text-uppercase align-self-start mb-2" data-category-badge>Innovación</span>
                    <h3>Jóvenes lanzan tienda digital de productos artesanales</h3>
                    <p>El proyecto opera con catálogo en línea, pagos digitales y despachos programados.</p>
                </div>
            </article>
            <article class="card h-100 border-0 overflow-hidden" data-article-card>
                <img src="assets/media/capacitacion3.jpeg" alt="Participantes en capacitación para pequeñas empresas">
                <div class="card-body d-flex flex-column" data-article-content>
                    <span class="badge rounded-pill text-uppercase align-self-start mb-2" data-category-badge>Negocios</span>
                    <h3>Capacitación gratuita apoyará a pequeñas empresas</h3>
                    <p>Talleres prácticos de gestión, ventas y marketing digital para dueños de pymes.</p>
                </div>
            </article>
        </div>
    </section>

    <section id="nuevo-articulo">
        <h2>Publicar nuevo artículo</h2>
        <p class="text-secondary mb-2">Completa el formulario para agregar un artículo en la sección que corresponda.</p>
        <p class="text-danger small fw-bold mb-3">* Campos obligatorios.</p>

        <form id="form-nuevo-articulo" novalidate>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="articulo-titulo" class="form-label">Título <span class="text-danger fw-bold ms-1" aria-hidden="true">*</span></label>
                    <input id="articulo-titulo" name="titulo" type="text" class="form-control" maxlength="120" required>
                </div>

                <div class="col-md-6">
                    <label for="articulo-categoria" class="form-label">Categoría <span class="text-danger fw-bold ms-1" aria-hidden="true">*</span></label>
                    <input id="articulo-categoria" name="categoria" type="text" class="form-control" maxlength="40" placeholder="Ej: Actualidad" required>
                </div>

                <div class="col-md-6">
                    <label for="articulo-seccion" class="form-label">Sección destino <span class="text-danger fw-bold ms-1" aria-hidden="true">*</span></label>
                    <select id="articulo-seccion" name="seccion" class="form-select" required>
                        <option value="">Selecciona una sección</option>
                        <option value="inicio">Inicio</option>
                        <option value="deporte">Deporte</option>
                        <option value="negocios">Negocios</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="articulo-imagen" class="form-label">URL de imagen (opcional)</label>
                    <input id="articulo-imagen" name="imagen" type="url" class="form-control" placeholder="https://...">
                </div>

                <div class="col-12">
                    <label for="articulo-resumen" class="form-label">Descripción <span class="text-danger fw-bold ms-1" aria-hidden="true">*</span></label>
                    <p class="small fw-bold text-secondary mb-2">Mínimo 20 y máximo 500 caracteres.</p>
                    <textarea id="articulo-resumen" name="resumen" class="form-control" minlength="20" maxlength="500" required></textarea>
                    <p id="contador-descripcion" class="small fw-bold text-primary text-end mt-2">0/500</p>
                </div>

                <div class="col-12 d-flex gap-3 flex-wrap align-items-center">
                    <button class="btn btn-primary rounded-pill fw-bold px-4" type="submit">Agregar artículo</button>
                    <p id="mensaje-articulo" class="mb-0 fw-semibold" aria-live="polite"></p>
                </div>
            </div>
        </form>
    </section>
</main>
<?php require_once 'views/layout/footer.php'; ?>
