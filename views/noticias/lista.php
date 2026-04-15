<div class="d-flex justify-content-between align-items-center mb-5">
    <h2 class="fw-bold m-0">Novedades</h2>
    <span class="badge rounded-pill" style="background-color: var(--light-green); color: var(--dark-green);">
        Mostrando noticias públicas
    </span>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php while($row = mysqli_fetch_assoc($noticias)): ?>
        <div class="col">
            <div class="card card-news h-100 p-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                            <?= e($row['estado']) ?>
                        </span>
                        <small class="text-muted fw-bold"><?= date('d/m/Y', strtotime($row['fecha_creacion'])) ?></small>
                    </div>
                    <h5 class="card-title fw-bold mb-3"><?= e($row['titulo']) ?></h5>
                    <p class="card-text text-secondary mb-4" style="font-size: 0.95rem;">
                        <?= mb_strimwidth(e($row['descripcion']), 0, 110, "...") ?>
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="?page=noticia&id=<?= $row['id'] ?>" class="text-chipi fw-bold text-decoration-none">Leer más →</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

