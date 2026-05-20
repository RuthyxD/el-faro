(() => {
    const dateElement = document.getElementById("current-date");
    const timeElement = document.getElementById("current-time");

    function renderDateTime() {
        if (!dateElement || !timeElement) {
            return;
        }

        const now = new Date();

        dateElement.textContent = new Intl.DateTimeFormat("es-CL", {
            weekday: "long",
            day: "2-digit",
            month: "long",
            year: "numeric"
        }).format(now);

        timeElement.textContent = new Intl.DateTimeFormat("es-CL", {
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
            hour12: false
        }).format(now);
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#39;");
    }

    /**
     * Trunca un texto a una longitud máxima
     * @param {string} text - Texto a truncar
     * @param {number} maxLength - Longitud máxima
     * @returns {string} Texto truncado con "..."
     */
    function truncateText(text, maxLength = 100) {
        if (!text || text.length <= maxLength) return text;
        return text.substring(0, maxLength).trim() + '...';
    }

    /**
     * Inicializa los botones "Leer más" de las tarjetas de artículos
     */
    function initializeArticleButtons() {
        const buttons = document.querySelectorAll('[data-article-button]');
        buttons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const card = this.closest('[data-article-card]');
                if (card) {
                    const title = card.querySelector('h3')?.textContent || 'Artículo';
                    const desc = card.querySelector('[data-article-desc]')?.textContent || '';
                    const author = card.querySelector('[data-article-meta] strong')?.textContent || 'Redactor';
                    const date = card.querySelector('[data-article-date]')?.textContent || 'N/A';
                    
                    // Mostrar alerta con información del artículo
                    alert(`📰 ${title}\n\n${desc}\n\nAutor: ${author} | Fecha: ${date}`);
                }
            });
        });
    }

    /**
     * Aplica truncado de texto en las descripciones de artículos
     */
    function applyTextTruncation() {
        const descriptions = document.querySelectorAll('[data-article-desc]');
        descriptions.forEach(el => {
            const originalText = el.textContent;
            el.textContent = truncateText(originalText, 100);
            el.title = originalText; // Mostrar texto completo en tooltip
        });
    }

    /**
     * Valida el campo de nombre
     */
    function validateName(field) {
        const value = field.value.trim();
        const isValid = value.length > 0 && value.length <= 120;
        return isValid;
    }

    /**
     * Valida el campo de email
     */
    function validateEmail(field) {
        const value = field.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(value);
    }

    /**
     * Valida el campo de mensaje
     */
    function validateMessage(field) {
        const value = field.value.trim();
        return value.length >= 10 && value.length <= 600;
    }

    /**
     * Valida el campo de contraseña
     */
    function validatePassword(field) {
        const value = field.value;
        return value.length >= 6;
    }

    /**
     * Actualiza el estado visual de un campo de formulario
     */
    function updateFieldState(field, isValid) {
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else if (field.value.trim() !== '') {
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');
        } else {
            field.classList.remove('is-invalid');
            field.classList.remove('is-valid');
        }
    }

    /**
     * Maneja la validación en tiempo real del formulario de contacto
     */
    function setupContactFormValidation() {
        const form = document.getElementById('form-contacto');
        if (!form) return;

        const nombreField = document.getElementById('contacto-nombre');
        const correoField = document.getElementById('contacto-email');
        const mensajeField = document.getElementById('contacto-mensaje');
        const submitBtn = document.getElementById('btn-submit-contacto');

        // Validación en tiempo real
        if (nombreField) {
            nombreField.addEventListener('blur', () => {
                const isValid = validateName(nombreField);
                updateFieldState(nombreField, isValid);
            });
            nombreField.addEventListener('input', () => {
                if (nombreField.classList.contains('is-invalid')) {
                    const isValid = validateName(nombreField);
                    updateFieldState(nombreField, isValid);
                }
            });
        }

        if (correoField) {
            correoField.addEventListener('blur', () => {
                const isValid = validateEmail(correoField);
                updateFieldState(correoField, isValid);
            });
            correoField.addEventListener('input', () => {
                if (correoField.classList.contains('is-invalid')) {
                    const isValid = validateEmail(correoField);
                    updateFieldState(correoField, isValid);
                }
            });
        }

        if (mensajeField) {
            mensajeField.addEventListener('blur', () => {
                const isValid = validateMessage(mensajeField);
                updateFieldState(mensajeField, isValid);
            });
            mensajeField.addEventListener('input', () => {
                if (mensajeField.classList.contains('is-invalid')) {
                    const isValid = validateMessage(mensajeField);
                    updateFieldState(mensajeField, isValid);
                }
                // Actualizar contador
                updateContactCounter();
            });
        }

        // Envío del formulario
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            // Validar todos los campos
            const isNombreValid = validateName(nombreField);
            const isCorreoValid = validateEmail(correoField);
            const isMensajeValid = validateMessage(mensajeField);

            updateFieldState(nombreField, isNombreValid);
            updateFieldState(correoField, isCorreoValid);
            updateFieldState(mensajeField, isMensajeValid);

            if (!isNombreValid || !isCorreoValid || !isMensajeValid) {
                return;
            }

            // Deshabilitar botón y mostrar estado de carga
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...';
            }

            // Enviar formulario
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.text())
            .then(data => {
                // Mostrar mensaje de éxito
                const successMsg = document.getElementById('form-success-message');
                const errorMsg = document.getElementById('form-error-message');
                
                if (successMsg) {
                    successMsg.classList.remove('d-none');
                    errorMsg.classList.add('d-none');
                }

                // Limpiar formulario
                form.reset();
                nombreField.classList.remove('is-valid');
                correoField.classList.remove('is-valid');
                mensajeField.classList.remove('is-valid');
                updateContactCounter();

                // Volver a habilitar botón
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Enviar mensaje';
                }

                // Ocultar mensaje de éxito después de 5 segundos
                setTimeout(() => {
                    if (successMsg) {
                        successMsg.classList.add('d-none');
                    }
                }, 5000);
            })
            .catch(error => {
                const errorMsg = document.getElementById('form-error-message');
                if (errorMsg) {
                    document.getElementById('error-text').textContent = 'Error al enviar el formulario. Por favor, intenta de nuevo.';
                    errorMsg.classList.remove('d-none');
                }

                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Enviar mensaje';
                }
            });
        });
    }

    /**
     * Maneja la validación en tiempo real del formulario de registro
     */
    function setupRegistrationFormValidation() {
        const form = document.getElementById('form-registro');
        if (!form) return;

        const nombreField = document.getElementById('nombre_completo');
        const correoField = document.getElementById('correo');
        const passwordField = document.getElementById('contrasena');
        const passwordConfirmField = document.getElementById('contrasena_confirma');
        const submitBtn = document.getElementById('btn-submit-registro');

        // Validación en tiempo real
        if (nombreField) {
            nombreField.addEventListener('blur', () => {
                const isValid = validateName(nombreField);
                updateFieldState(nombreField, isValid);
            });
            nombreField.addEventListener('input', () => {
                if (nombreField.classList.contains('is-invalid')) {
                    const isValid = validateName(nombreField);
                    updateFieldState(nombreField, isValid);
                }
            });
        }

        if (correoField) {
            correoField.addEventListener('blur', () => {
                const isValid = validateEmail(correoField);
                updateFieldState(correoField, isValid);
            });
            correoField.addEventListener('input', () => {
                if (correoField.classList.contains('is-invalid')) {
                    const isValid = validateEmail(correoField);
                    updateFieldState(correoField, isValid);
                }
            });
        }

        if (passwordField) {
            passwordField.addEventListener('blur', () => {
                const isValid = validatePassword(passwordField);
                updateFieldState(passwordField, isValid);
            });
            passwordField.addEventListener('input', () => {
                if (passwordField.classList.contains('is-invalid')) {
                    const isValid = validatePassword(passwordField);
                    updateFieldState(passwordField, isValid);
                }
            });
        }

        if (passwordConfirmField) {
            passwordConfirmField.addEventListener('blur', () => {
                const isValid = passwordField.value === passwordConfirmField.value && passwordConfirmField.value.length >= 6;
                updateFieldState(passwordConfirmField, isValid);
            });
            passwordConfirmField.addEventListener('input', () => {
                if (passwordConfirmField.classList.contains('is-invalid')) {
                    const isValid = passwordField.value === passwordConfirmField.value && passwordConfirmField.value.length >= 6;
                    updateFieldState(passwordConfirmField, isValid);
                }
            });
        }

        // Envío del formulario
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            // Validar todos los campos
            const isNombreValid = validateName(nombreField);
            const isCorreoValid = validateEmail(correoField);
            const isPasswordValid = validatePassword(passwordField);
            const isPasswordConfirmValid = passwordField.value === passwordConfirmField.value && passwordConfirmField.value.length >= 6;

            updateFieldState(nombreField, isNombreValid);
            updateFieldState(correoField, isCorreoValid);
            updateFieldState(passwordField, isPasswordValid);
            updateFieldState(passwordConfirmField, isPasswordConfirmValid);

            if (!isNombreValid || !isCorreoValid || !isPasswordValid || !isPasswordConfirmValid) {
                return;
            }

            // Deshabilitar botón y mostrar estado de carga
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creando cuenta...';
            }

            // Enviar formulario
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.text())
            .then(data => {
                // Mostrar mensaje de éxito
                const successMsg = document.getElementById('form-success-message-registro');
                const errorMsg = document.getElementById('form-error-message-registro');
                
                if (successMsg) {
                    successMsg.classList.remove('d-none');
                    errorMsg.classList.add('d-none');
                }

                // Limpiar formulario
                form.reset();
                nombreField.classList.remove('is-valid');
                correoField.classList.remove('is-valid');
                passwordField.classList.remove('is-valid');
                passwordConfirmField.classList.remove('is-valid');

                // Volver a habilitar botón
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Crear cuenta';
                }

                // Redirigir después de 2 segundos
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 2000);
            })
            .catch(error => {
                const errorMsg = document.getElementById('form-error-message-registro');
                if (errorMsg) {
                    document.getElementById('error-text-registro').textContent = 'Error al crear la cuenta. Por favor, intenta de nuevo.';
                    errorMsg.classList.remove('d-none');
                }

                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Crear cuenta';
                }
            });
        });
    }

    const contactMessageField = document.getElementById("contacto-mensaje");
    const contactCounter = document.getElementById("contador-contacto-mensaje");
    const articleForm = document.getElementById("form-nuevo-articulo");
    const articleMessage = document.getElementById("mensaje-articulo");
    const articleTitleField = document.getElementById("articulo-titulo");
    const articleCategoryField = document.getElementById("articulo-categoria");
    const articleSectionField = document.getElementById("articulo-seccion");
    const articleSummaryField = document.getElementById("articulo-resumen");
    const articleSummaryCounter = document.getElementById("contador-descripcion");
    const recentArticlesView = document.getElementById("recent-articles-view");
    const recentMiniList = document.getElementById("recent-articles-mini");
    const recentArticlesData = document.getElementById("recent-articles-data");
    const ARTICLE_SUMMARY_MIN = 20;
    const ARTICLE_SUMMARY_MAX = 500;

    let recentArticles = [];
    if (recentArticlesData) {
        try {
            const parsed = JSON.parse(recentArticlesData.textContent || "[]");
            if (Array.isArray(parsed)) {
                recentArticles = parsed;
            }
        } catch (_) {
            recentArticles = [];
        }
    }

    function updateContactCounter() {
        if (contactMessageField && contactCounter) {
            contactCounter.textContent = `${contactMessageField.value.length}/600`;
        }
    }

    function setMessage(element, text, type) {
        if (!element) {
            return;
        }
        element.textContent = text;
        element.classList.remove("text-danger", "text-success");
        if (type === "error") {
            element.classList.add("text-danger");
        } else if (type === "success") {
            element.classList.add("text-success");
        }
    }

    function setFieldInvalidState(field, isInvalid) {
        field.classList.toggle("is-invalid", isInvalid);
        field.setAttribute("aria-invalid", isInvalid ? "true" : "false");
    }

    function updateArticleSummaryCounter() {
        if (!articleSummaryField || !articleSummaryCounter) {
            return;
        }
        const totalLength = articleSummaryField.value.length;
        const summaryLength = articleSummaryField.value.trim().length;
        articleSummaryCounter.textContent = `${totalLength}/${ARTICLE_SUMMARY_MAX}`;
        articleSummaryCounter.classList.toggle("text-danger", summaryLength > 0 && summaryLength < ARTICLE_SUMMARY_MIN);
        articleSummaryCounter.classList.toggle("text-primary", !(summaryLength > 0 && summaryLength < ARTICLE_SUMMARY_MIN));
    }

    function updateArticleCounts() {
        document.querySelectorAll("[data-section-count]").forEach((countNode) => {
            const sectionId = countNode.getAttribute("data-section-count");
            const section = sectionId ? document.getElementById(sectionId) : null;
            const total = section ? section.querySelectorAll("article[data-article-card]").length : 0;
            countNode.textContent = `(Artículos: ${total})`;
        });
    }

    function renderRecentArticles() {
        if (!recentArticlesView || !recentMiniList) {
            return;
        }

        if (recentArticles.length === 0) {
            recentArticlesView.innerHTML = '<div class="alert alert-light border rounded-4 mb-0">Aún no hay publicaciones recientes para destacar.</div>';
            recentMiniList.innerHTML = "";
            return;
        }

        recentArticlesView.innerHTML = `
            <div id="recentArticlesCarousel" class="carousel slide border rounded-4 overflow-hidden bg-white shadow-sm" data-recent-carousel data-bs-ride="carousel" data-bs-interval="6000">
                <div class="carousel-indicators">
                    ${recentArticles.map((_, index) => `
                        <button type="button" data-bs-target="#recentArticlesCarousel" data-bs-slide-to="${index}" class="${index === 0 ? "active" : ""}" ${index === 0 ? 'aria-current="true"' : ""} aria-label="Artículo ${index + 1}"></button>
                    `).join("")}
                </div>
                <div class="carousel-inner">
                    ${recentArticles.map((article, index) => `
                        <div class="carousel-item ${index === 0 ? "active" : ""}">
                            <article class="row g-0" data-recent-slide>
                                <div class="col-lg-7 position-relative" data-recent-slide-image>
                                    ${article.imagen ? `<img src="${escapeHtml(article.imagen)}" alt="${escapeHtml(article.titulo)}">` : ""}
                                </div>
                                <div class="col-lg-5 d-flex align-items-center" data-recent-slide-body>
                                    <div>
                                        <span class="badge rounded-pill fw-bold" data-recent-tag>${index === 0 ? "Más reciente" : "Reciente"} · ${escapeHtml(article.seccion || "Publicación")}</span>
                                        <span class="badge rounded-pill fw-bold" data-recent-time>${escapeHtml(article.categoria || "")}</span>
                                        <h3>${escapeHtml(article.titulo || "")}</h3>
                                        <p>${escapeHtml(article.descripcion || "")}</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    `).join("")}
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#recentArticlesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#recentArticlesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        `;

        const miniArticles = recentArticles.slice(1);
        recentMiniList.innerHTML = miniArticles.map((article) => `
            <article class="col-md-6">
                <div class="card border-0 shadow-sm h-100" data-recent-mini-card>
                    <div class="row g-0 align-items-center">
                        <div class="col-4">
                            ${article.imagen ? `<img src="${escapeHtml(article.imagen)}" class="img-fluid rounded-start" alt="${escapeHtml(article.titulo || "")}">` : ""}
                        </div>
                        <div class="col-8">
                            <div class="card-body p-2">
                                <h4 class="h6 fw-bold mb-1">${escapeHtml(article.titulo || "")}</h4>
                                <p class="small mb-0">${escapeHtml(article.categoria || "")} · ${escapeHtml(article.seccion || "Publicación")}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        `).join("");
    }

    function createArticleElement(title, category, summary, imageUrl) {
        const article = document.createElement("article");
        article.className = "card h-100 border-0 overflow-hidden";
        article.setAttribute("data-article-card", "");

        if (imageUrl) {
            const image = document.createElement("img");
            image.src = imageUrl;
            image.alt = title;
            image.addEventListener("error", () => image.remove());
            article.appendChild(image);
        }

        const content = document.createElement("div");
        content.className = "card-body d-flex flex-column";
        content.setAttribute("data-article-content", "");

        const badge = document.createElement("span");
        badge.className = "badge rounded-pill text-uppercase align-self-start mb-2";
        badge.setAttribute("data-category-badge", "");
        badge.textContent = category;

        const heading = document.createElement("h3");
        heading.textContent = title;

        const paragraph = document.createElement("p");
        paragraph.textContent = summary;

        content.appendChild(badge);
        content.appendChild(heading);
        content.appendChild(paragraph);
        article.appendChild(content);
        return article;
    }

    function validateArticleFields() {
        if (!articleTitleField || !articleCategoryField || !articleSectionField || !articleSummaryField) {
            return { valid: false, message: "No se pudo inicializar el formulario." };
        }

        const title = articleTitleField.value.trim();
        const category = articleCategoryField.value.trim();
        const section = articleSectionField.value.trim();
        const summary = articleSummaryField.value.trim();

        const checks = [
            { field: articleTitleField, valid: title.length > 0 },
            { field: articleCategoryField, valid: category.length > 0 },
            { field: articleSectionField, valid: section.length > 0 },
            { field: articleSummaryField, valid: summary.length > 0 }
        ];

        checks.forEach((item) => setFieldInvalidState(item.field, !item.valid));
        if (checks.some((item) => !item.valid)) {
            return { valid: false, message: "Falta completar los campos obligatorios marcados en rojo." };
        }

        if (summary.length < ARTICLE_SUMMARY_MIN) {
            setFieldInvalidState(articleSummaryField, true);
            return { valid: false, message: `La descripción debe tener al menos ${ARTICLE_SUMMARY_MIN} caracteres.` };
        }

        return { valid: true, message: "" };
    }

    function addRecentArticle(title, category, summary, imageUrl, sectionKey) {
        const sectionLabels = {
            inicio: "Inicio",
            deporte: "Deporte",
            negocios: "Negocios"
        };

        recentArticles.unshift({
            titulo: title,
            categoria: category,
            descripcion: summary,
            imagen: imageUrl || "assets/media/opcion3.png",
            seccion: sectionLabels[sectionKey] || "Publicación"
        });
        recentArticles.splice(4);
        renderRecentArticles();
    }

    renderDateTime();
    updateContactCounter();
    renderRecentArticles();
    updateArticleSummaryCounter();
    updateArticleCounts();
    applyTextTruncation();
    initializeArticleButtons();
    setupContactFormValidation();
    setupRegistrationFormValidation();
    window.setInterval(renderDateTime, 1000);

    if (contactMessageField) {
        contactMessageField.addEventListener("input", updateContactCounter);
    }

    if (articleSummaryField) {
        articleSummaryField.addEventListener("input", updateArticleSummaryCounter);
    }

    if (articleForm) {
        articleForm.addEventListener("submit", (event) => {
            event.preventDefault();
            console.log("📋 Evento submit del formulario disparado");

            const validationResult = validateArticleFields();
            console.log("✓ Validación:", validationResult);
            
            if (!validationResult.valid) {
                setMessage(articleMessage, validationResult.message, "error");
                console.error("❌ Validación fallida:", validationResult.message);
                return;
            }

            const formData = new FormData(articleForm);
            const title = String(formData.get("titulo") || "").trim();
            const category = String(formData.get("categoria") || "").trim();
            const sectionKey = String(formData.get("seccion") || "").trim();
            const summary = String(formData.get("resumen") || "").trim();
            const imageUrl = String(formData.get("imagen") || "").trim();
            const autor = String(formData.get("autor") || "Anónimo").trim();

            console.log("📝 Datos del formulario:", {
                title, category, sectionKey, summary, imageUrl, autor
            });

            // Desactivar el botón mientras se envía
            const submitButton = articleForm.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = "Publicando...";
            }

            const params = new URLSearchParams({
                titulo: title,
                categoria: category,
                seccion: sectionKey,
                resumen: summary,
                imagen: imageUrl,
                autor: autor
            });

            console.log("🚀 Enviando solicitud POST a: index.php?controller=articulo&action=crear");
            console.log("📤 Parámetros:", params.toString());

            // Enviar datos al servidor
            fetch("index.php?controller=articulo&action=crear", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: params.toString()
            })
            .then(response => {
                console.log("📬 Respuesta recibida. Status:", response.status);
                console.log("Content-Type:", response.headers.get("content-type"));
                
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status} ${response.statusText}`);
                }
                return response.text(); // Primero obtener como texto
            })
            .then(text => {
                console.log("📋 Texto de respuesta recibido:", text);
                
                // Intentar parsear como JSON
                try {
                    const data = JSON.parse(text);
                    console.log("✅ JSON parseado:", data);
                    
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = "Agregar artículo";
                    }
                    
                    if (data.exito) {
                        console.log("✅ Éxito: Artículo guardado en BD");
                        
                        // Agregar el artículo visualmente
                        const sectionsMap = {
                            inicio: document.getElementById("inicio-grid"),
                            deporte: document.getElementById("deporte-grid"),
                            negocios: document.getElementById("negocios-grid")
                        };

                        const destination = sectionsMap[sectionKey];
                        if (destination) {
                            destination.insertBefore(createArticleElement(title, category, summary, imageUrl), destination.firstChild);
                            addRecentArticle(title, category, summary, imageUrl, sectionKey);
                            updateArticleCounts();
                            console.log("🎨 Artículo agregado al DOM");
                        }

                        articleForm.reset();
                        updateArticleSummaryCounter();
                        setMessage(articleMessage, "✅ ¡Artículo publicado y guardado en BD!", "success");
                        
                        // Limpiar mensaje de éxito después de 3 segundos
                        setTimeout(() => {
                            setMessage(articleMessage, "", "");
                        }, 3000);
                    } else {
                        console.error("❌ Error del servidor:", data.mensaje);
                        setMessage(articleMessage, data.mensaje || "Error al publicar el artículo.", "error");
                    }
                } catch (parseError) {
                    console.error("❌ Error al parsear JSON:", parseError);
                    console.error("Respuesta original:", text);
                    setMessage(articleMessage, "Error: La respuesta del servidor no es JSON válido.", "error");
                }
            })
            .catch(error => {
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = "Agregar artículo";
                }
                console.error("❌ Error en la solicitud:", error);
                setMessage(articleMessage, "Error al enviar el formulario: " + error.message, "error");
            });
        });
    }
})();
