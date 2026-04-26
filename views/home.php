<div class="container py-4">
    <div class="hero-box text-center">
        <h1 class="display-3 fw-bold mb-3 text-white">Chipi News 🍏</h1>
        <p class="lead opacity-90 mb-4 fw-medium text-white">
            <?= isset($_SESSION['usuario_id']) ? "¡Hola, " . e($_SESSION['usuario_nombre']) . "! Bienvenido al portal." : "Las noticias de la UNSL, frescas y verificadas." ?>
        </p>

        <div class="d-flex justify-content-center gap-3">
            <a href="?page=noticias" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-chipi shadow">Explorar Novedades</a>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="?page=perfil" class="btn btn-outline-light btn-lg rounded-pill px-4">Mi Perfil</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-5">
        <h2 class="fw-bold mb-4">Últimas Novedades 🍏</h2>
        <div class="row g-4">
            <?php
            $noticias_home = obtenerNoticiasPublicas($conn);
            while ($n = mysqli_fetch_assoc($noticias_home)):
            ?>
                <div class="col-md-4">
                    <div class="card-news">
                        <?php if ($n['imagen']): ?>
                            <img src="uploads/<?= $n['imagen'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="fw-bold text-dark mb-2"><?= e($n['titulo']) ?></h5>
                            <p class="text-secondary small mb-3"><?= e($n['resumen']) ?></p>

                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                <small class="text-muted">Por: <strong><?= e($n['nombre']) ?> <?= e($n['apellido']) ?></strong></small>
                                <a href="?page=noticia&id=<?= $n['id'] ?>" class="btn-outline-chipi stretched-link">
                                    Leer más
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>