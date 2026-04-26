<?php if ($noticia): ?>
<div class="row justify-content-center py-4">
    <div class="col-lg-9">
        <a href="javascript:history.back()" class="text-decoration-none text-chipi fw-bold mb-4 d-inline-block">
            ← Volver atrás
        </a>

        <article class="card border-0 shadow-sm rounded-5 overflow-hidden bg-white">
            <?php if (!empty($noticia['imagen'])): ?>
                <div class="ratio ratio-21x9">
                    <img src="uploads/<?= $noticia['imagen'] ?>" 
                         class="img-fluid object-fit-cover" 
                         alt="<?= e($noticia['titulo']) ?>">
                </div>
            <?php endif; ?>

            <div class="p-4 p-md-5">
                <header class="mb-5">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge rounded-pill px-3 py-2" 
                              style="background-color: var(--light-green); color: var(--dark-green);">
                            <?= e($noticia['estado']) ?>
                        </span>
                        <span class="text-muted small fw-bold">
                            📅 <?= date('d/m/Y', strtotime($noticia['fecha_publicacion'] ?? $noticia['fecha_creacion'])) ?>
                        </span>
                    </div>
                    
                    <h1 class="display-4 fw-bold text-dark mb-4"><?= e($noticia['titulo']) ?></h1>
                    
                    <?php if(!empty($noticia['resumen'])): ?>
                        <p class="lead text-secondary fw-medium border-start border-4 border-chipi ps-3">
                            <?= e($noticia['resumen']) ?>
                        </p>
                    <?php endif; ?>
                </header>

                <div class="noticia-contenido" style="font-size: 1.2rem; line-height: 1.8; color: #334155;">
                    <?= nl2br(e($noticia['descripcion'])) ?>
                </div>

                <footer class="mt-5 pt-4 border-top">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" 
                                 style="width: 55px; height: 55px; background: linear-gradient(135deg, #1e3d1a, #43a047); color: white; font-weight: bold; font-size: 1.2rem;">
                                <?= strtoupper(substr($noticia['nombre'], 0, 1)) ?>
                            </div>
                            <div>
                                <p class="m-0 fw-bold text-dark"><?= e($noticia['nombre']) ?> <?= e($noticia['apellido']) ?></p>
                                <p class="m-0 text-muted small">Redacción Chipi News • San Luis</p>
                            </div>
                        </div>
                        <div class="text-muted small italic">
                            Publicado desde San Luis, Argentina
                        </div>
                    </div>
                </footer>
            </div>
        </article>
    </div>
</div>

<style>
    .object-fit-cover { object-fit: cover; }
</style>

<?php else: ?>
    <div class="container py-5 text-center">
        <h2 class="text-muted">No se pudo encontrar la noticia seleccionada. 🍏</h2>
        <a href="?page=home" class="btn btn-chipi text-white rounded-pill px-4 mt-3">Ir al Inicio</a>
    </div>
<?php endif; ?>