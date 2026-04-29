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

            const validationResult = validateArticleFields();
            if (!validationResult.valid) {
                setMessage(articleMessage, validationResult.message, "error");
                return;
            }

            const formData = new FormData(articleForm);
            const title = String(formData.get("titulo") || "").trim();
            const category = String(formData.get("categoria") || "").trim();
            const sectionKey = String(formData.get("seccion") || "").trim();
            const summary = String(formData.get("resumen") || "").trim();
            const imageUrl = String(formData.get("imagen") || "").trim();

            const sectionsMap = {
                inicio: document.getElementById("inicio-grid"),
                deporte: document.getElementById("deporte-grid"),
                negocios: document.getElementById("negocios-grid")
            };

            const destination = sectionsMap[sectionKey];
            if (!destination) {
                setMessage(articleMessage, "No se encontró la sección seleccionada.", "error");
                return;
            }

            destination.appendChild(createArticleElement(title, category, summary, imageUrl));
            addRecentArticle(title, category, summary, imageUrl, sectionKey);
            updateArticleCounts();
            articleForm.reset();
            updateArticleSummaryCounter();
            setMessage(articleMessage, "Listo, el artículo se agregó correctamente.", "success");
        });
    }
})();
