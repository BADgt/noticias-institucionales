
<?php if (isset($_SESSION['usuario_id'])): ?>
    <div class="p-5 rounded-5 bg-white shadow-sm border border-light text-center mb-5">
        <h1 class="fw-bold display-4">¡Hola, <?= e($_SESSION['usuario_nombre']) ?>! 🍏</h1>
        <p class="lead text-secondary mb-4">Panel de gestión de Chipi News</p>
        
        <div class="d-flex justify-content-center gap-3">
            <a href="?page=nueva-noticia" class="btn btn-chipi btn-lg rounded-pill px-5 shadow-sm text-white">Redactar Noticia</a>
            <a href="?page=noticias" class="btn btn-outline-secondary btn-lg rounded-pill px-4">Ver Portal Público</a>
        </div>
    </div>

    <?php $rol = $_SESSION['usuario_rol'] ?? 0; ?>

    <?php if ($rol == 2): ?>
        <div class="alert alert-info rounded-4 border-0 shadow-sm p-4 mb-5 d-flex align-items-center justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">Panel de Validador 🛡️</h4>
                <p class="mb-0 text-secondary">Tenés noticias pendientes de revisión para publicar.</p>
            </div>
            <a href="?page=validar-noticias" class="btn btn-primary rounded-pill px-4 fw-bold">Revisar Ahora</a>
        </div>
    <?php endif; ?>

    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card-auth p-4 h-100">
                <h3 class="fw-bold text-chipi">📝</h3>
                <h5 class="fw-bold">Mis Noticias</h5>
                <p class="text-muted small">Gestioná tu contenido.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-auth p-4 h-100">
                <h3 class="fw-bold text-chipi">⏳</h3>
                <h5 class="fw-bold">Pendientes</h5>
                <p class="text-muted small">Esperando validación.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-auth p-4 h-100">
                <h3 class="fw-bold text-chipi">🍏</h3>
                <h5 class="fw-bold">Tips de Chipi</h5>
                <p class="text-muted small">Usá títulos llamativos.</p>
            </div>
        </div>
    </div>

<?php else: ?>
    <div class="hero-box text-center mb-5">
        <h1 class="display-3 fw-bold mb-3 text-white">Informate con Chipi News</h1>
        <p class="lead opacity-90 mb-4 fw-medium text-white">Las noticias de la UNSL, frescas y verificadas.</p>
        <a href="?page=noticias" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-chipi shadow">Explorar Novedades</a>
    </div>

    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="p-4 bg-white rounded-4 shadow-sm h-100 border border-light">
                <div class="h1 mb-3">🍏</div>
                <h4 class="fw-bold">Fresco</h4>
                <p class="text-muted small">Diseño moderno pensado para la lectura rápida.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 bg-white rounded-4 shadow-sm h-100 border border-light">
                <div class="h1 mb-3">✅</div>
                <h4 class="fw-bold">Verificado</h4>
                <p class="text-muted small">Contenido revisado por el equipo institucional.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 bg-white rounded-4 shadow-sm h-100 border border-light">
                <div class="h1 mb-3">🚀</div>
                <h4 class="fw-bold">Rápido</h4>
                <p class="text-muted small">Enterate de todo lo que pasa al instante.</p>
            </div>
        </div>
    </div>
<?php endif; ?>