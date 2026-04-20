<?php 
    $id = $_GET['id'] ?? 0;
    $noticia = obtenerNoticiaParaEditar($conn, $id); // Trae los datos + autor
?>

<div class="container py-5">
    <div class="mb-4">
        <a href="?page=validar-noticias" class="btn btn-light rounded-pill px-3 border">← Volver a Pendientes</a>
    </div>

    <div class="card border-0 shadow rounded-5 p-5 bg-white">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="fw-bold text-dark"><?= e($noticia['titulo']) ?></h1>
                <p class="text-secondary">Redactado por: **<?= e($noticia['nombre']) ?> <?= e($noticia['apellido']) ?>**</p>
            </div>
            <span class="badge bg-primary rounded-pill px-4 py-2">EN REVISIÓN</span>
        </div>

        <?php if ($noticia['imagen']): ?>
            <img src="uploads/<?= $noticia['imagen'] ?>" class="img-fluid rounded-4 mb-4 shadow-sm" style="max-height: 400px; width: 100%; object-fit: cover;">
        <?php endif; ?>

        <div class="noticia-body mb-5">
            <p class="lead fw-bold text-muted border-start border-4 border-chipi ps-3"><?= e($noticia['resumen']) ?></p>
            <div class="content mt-4 fs-5" style="line-height: 1.8;">
                <?= nl2br(e($noticia['descripcion'])) ?>
            </div>
        </div>

        <div class="p-4 rounded-4 bg-light">
            <h5 class="fw-bold mb-3">Panel de Decisiones 🛡️</h5>
            <form action="?page=procesar-revision" method="POST" class="d-flex flex-wrap gap-2">
                <input type="hidden" name="noticia_id" value="<?= $noticia['id'] ?>">
                <button type="submit" name="estado" value="Publicada" class="btn btn-success rounded-pill px-4 fw-bold">Aprobar y Publicar</button>
                <button type="submit" name="estado" value="Para Corrección" class="btn btn-warning rounded-pill px-4 fw-bold">Pedir Corrección</button>
                <button type="submit" name="estado" value="Anulada" class="btn btn-danger rounded-pill px-4 fw-bold">Anular</button>
            </form>
        </div>
    </div>
</div>