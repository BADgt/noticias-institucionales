<div class="container py-4">
    <div class="mb-4">
        <a href="?page=home" class="btn btn-light rounded-pill px-3 border shadow-sm">← Volver al Inicio</a>
    </div>

    <div class="mb-5">
        <h2 class="fw-bold text-dark m-0">Novedades</h2>
        <p class="text-secondary">Enterate de todo lo que pasa en la universidad.</p>
    </div>

    <div class="row g-4">
        <?php if (mysqli_num_rows($noticias) > 0): ?>
            <?php while ($n = mysqli_fetch_assoc($noticias)): ?>
                <div class="col-md-4">
                    <div class="card-news">
                        <?php if (!empty($n['imagen'])): ?>
                            <img src="uploads/<?= $n['imagen'] ?>"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover;"
                                 alt="<?= e($n['titulo']) ?>">
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span class="text-muted small">Sin imagen</span>
                            </div>
                        <?php endif; ?>

                        <div class="card-body p-4 d-flex flex-column">
                            <?php if (isset($_SESSION['usuario_id'])): ?>
                                <span class="badge rounded-pill bg-success mb-2 align-self-start" style="font-size: 0.7rem;">Publicada</span>
                            <?php endif; ?>

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
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Todavía no hay noticias publicadas.</p>
            </div>
        <?php endif; ?>
    </div>
</div>