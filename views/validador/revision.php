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
            <span class="badge bg-primary rounded-pill px-4 py-2">EN REVISION</span>
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
            <h5 class="fw-bold mb-3">Panel de Decisiones</h5>
            
            <?php 
            /*
             * VALIDACION VISUAL DE AUTORIA
             * Comparamos el autor de la noticia con el usuario actualmente logueado.
             * Si coinciden, mostramos un mensaje de restriccion y ocultamos los botones de accion.
             */
            if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $noticia['autor_id']): 
            ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-0 p-4 d-flex align-items-center">
                    <div>
                        <h6 class="fw-bold mb-1 text-danger">Accion denegada: Autoria propia</h6>
                        <p class="mb-0 small text-secondary">
                            Por politicas de transparencia y control de calidad, un editor no puede validar ni aprobar sus propias redacciones. Esta publicacion debe ser revisada por otro validador del equipo.
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-success rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalPublicar">
                        Aprobar y Publicar
                    </button>
                    <button type="button" class="btn btn-warning rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalCorregir">
                        Pedir Correccion
                    </button>
                    <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAnular">
                        Anular
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <?php 
        /*
         * PROTECCION DE MODALES
         * Solo se imprimen en el HTML si el usuario supero la validacion de autoria.
         * Esto evita que un usuario manipule el codigo fuente desde el navegador para forzar la aprobacion.
         */
        if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] != $noticia['autor_id']): 
        ?>
            <div class="modal fade" id="modalPublicar" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow rounded-5">
                        <div class="modal-header border-0 pt-4 px-4">
                            <h5 class="modal-title fw-bold text-success">Confirmar Publicacion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 pb-4">
                            <p class="text-secondary fs-5 mb-0">¿Estas seguro de que quieres publicar esta noticia?</p>
                            <small class="text-muted d-block mt-2">El contenido sera visible para todos los visitantes del portal web.</small>
                        </div>
                        <div class="modal-footer border-0 pb-4 px-4 gap-2">
                            <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Cancelar</button>
                            <form action="?page=procesar-revision" method="POST" class="m-0">
                                <input type="hidden" name="noticia_id" value="<?= $noticia['id'] ?>">
                                <input type="hidden" name="estado" value="Publicada">
                                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">Si, publicar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="modalCorregir" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow rounded-5">
                        <div class="modal-header border-0 pt-4 px-4">
                            <h5 class="modal-title fw-bold text-warning">Devolver al Autor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 pb-4">
                            <p class="text-secondary fs-5 mb-0">¿Quieres devolver este borrador para correccion?</p>
                            <small class="text-muted d-block mt-2">La noticia volvera al panel del autor con un aviso de que requiere ajustes.</small>
                        </div>
                        <div class="modal-footer border-0 pb-4 px-4 gap-2">
                            <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Cancelar</button>
                            <form action="?page=procesar-revision" method="POST" class="m-0">
                                <input type="hidden" name="noticia_id" value="<?= $noticia['id'] ?>">
                                <input type="hidden" name="estado" value="Para Corrección">
                                <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold">Si, pedir correccion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="modalAnular" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow rounded-5">
                        <div class="modal-header border-0 pt-4 px-4">
                            <h5 class="modal-title fw-bold text-danger">Anular Noticia</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 pb-4">
                            <p class="text-secondary fs-5 mb-0">¿Estas seguro de que quieres anular esta noticia?</p>
                            <small class="text-muted d-block mt-2">Esta accion detendra el proceso de validacion y la noticia no se publicara.</small>
                        </div>
                        <div class="modal-footer border-0 pb-4 px-4 gap-2">
                            <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Cancelar</button>
                            <form action="?page=procesar-revision" method="POST" class="m-0">
                                <input type="hidden" name="noticia_id" value="<?= $noticia['id'] ?>">
                                <input type="hidden" name="estado" value="Anulada">
                                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Si, anular</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        </div>
</div>