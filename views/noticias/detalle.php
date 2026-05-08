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

                        <?php if (!empty($noticia['resumen'])): ?>
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

                    <?php
                    if (isset($_SESSION['usuario_id']) && $noticia['estado'] === 'Publicada'):

                        $es_autor = ($_SESSION['usuario_id'] == $noticia['autor_id']);
                        $es_validador = in_array(2, $_SESSION['usuario_roles'] ?? []);

                        if ($es_autor || $es_validador):
                    ?>
                            <div class="mt-4 pt-4 border-top text-end">
                                <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalBajaNoticia">
                                    Dar de baja esta noticia
                                </button>
                            </div>

                            <div class="modal fade" id="modalBajaNoticia" tabindex="-1" aria-labelledby="modalBajaLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow rounded-5">
                                        <div class="modal-header border-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold" id="modalBajaLabel">Confirmar accion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body px-4 pb-4">
                                            <p class="text-secondary fs-5 mb-0">
                                                ¿Estas seguro de que quieres dar de baja esta noticia?
                                            </p>
                                            <small class="text-muted d-block mt-2">
                                                La noticia dejara de ser visible para el publico y pasara al estado Anulada.
                                            </small>
                                        </div>
                                        <div class="modal-footer border-0 pb-4 px-4 gap-2">
                                            <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Cancelar</button>

                                            <form action="?page=bajar-noticia" method="POST" class="m-0">
                                                <input type="hidden" name="noticia_id" value="<?= $noticia['id'] ?>">
                                                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">
                                                    Si, dar de baja
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endif;
                    endif;
                    ?>
                </div>
            </article>
        </div>
    </div>

    <style>
        .object-fit-cover {
            object-fit: cover;
        }
    </style>

<?php else: ?>
    <div class="container py-5 text-center">
        <h2 class="text-muted">No se pudo encontrar la noticia seleccionada.</h2>
        <a href="?page=home" class="btn btn-chipi text-white rounded-pill px-4 mt-3">Ir al Inicio</a>
    </div>
<?php endif; ?>