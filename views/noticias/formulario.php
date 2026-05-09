<?php
// Determinamos si estamos editando o creando una nueva
$es_edicion = isset($noticia);
$titulo_vista = $es_edicion ? "Editar Noticia" : "Redactar Noticia";
$accion_url = $es_edicion ? "?page=actualizar-noticia" : "?page=guardar-noticia";
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="mb-4">
            <a href="?page=mis-borradores" class="btn btn-light rounded-pill px-3 border shadow-sm">← Mis Borradores</a>
        </div>

        <?php if ($es_edicion && $noticia['estado'] === 'Para Corrección'): ?>
            <div class="alert alert-warning border-0 shadow-sm rounded-4 p-4 mb-4 d-flex align-items-center">
                <span class="fs-2 me-3">!</span>
                <div>
                    <h5 class="fw-bold mb-1">Hola <?= e($_SESSION['usuario_nombre']) ?>. Hay ajustes pendientes</h5>
                    <p class="mb-0 small text-secondary">El validador reviso tu noticia y te la devolvio para que le hagas unos retoques antes de publicarla.</p>
                </div>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-5 p-5 bg-white">
            <h2 class="fw-bold mb-4"><?= $titulo_vista ?></h2>

            <form action="<?= $accion_url ?>" method="POST" enctype="multipart/form-data">
                <?php if ($es_edicion): ?>
                    <input type="hidden" name="id" value="<?= $noticia['id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label fw-bold">Titulo</label>
                    <input type="text" name="titulo" class="form-control rounded-4 px-3"
                        value="<?= $es_edicion ? e($noticia['titulo']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Resumen (breve)</label>
                    <textarea name="resumen" class="form-control rounded-4 px-3" rows="2"><?= $es_edicion ? e($noticia['resumen']) : '' ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Imagen de Portada</label>
                    <input type="hidden" name="borrar_imagen_actual" id="borrar_imagen_actual" value="0">
                    <div class="image-upload-placeholder" onclick="document.getElementById('noticia-imagen').click();">
                        <div id="btn-clean-preview"
                            class="image-preview-cleaner <?= ($es_edicion && !empty($noticia['imagen'])) ? '' : 'd-none' ?>"
                            onclick="removePreviewImage(event)"
                            title="Quitar imagen">
                            <span>T</span>
                        </div>
                        <img id="img-preview"
                            src="<?= ($es_edicion && !empty($noticia['imagen'])) ? 'uploads/' . $noticia['imagen'] : '#' ?>"
                            class="<?= ($es_edicion && !empty($noticia['imagen'])) ? '' : 'd-none' ?>"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 1.5rem;">
                        <div id="placeholder-content" class="text-center <?= ($es_edicion && !empty($noticia['imagen'])) ? 'd-none' : '' ?>">
                            <span style="font-size: 2.5rem;">+</span>
                            <p class="fw-bold mb-0">Anadir portada</p>
                        </div>
                    </div>
                    <input type="file" name="imagen" id="noticia-imagen" class="d-none" accept="image/*" onchange="previewImage(this)">
                    <small class="text-muted d-block mt-2">Hace clic en la tarjeta para cambiar la imagen.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Contenido de la Noticia</label>
                    <textarea name="contenido" class="form-control rounded-4 px-3" rows="8" required><?= $es_edicion ? e($noticia['descripcion'] ?? $noticia['contenido']) : '' ?></textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                    <div>
                        <a href="?page=mis-borradores" class="btn btn-light rounded-pill px-4 border">Cancelar</a>

                        <?php if ($es_edicion): ?>
                            <button type="button" class="btn btn-outline-danger rounded-pill px-4 ms-2" data-bs-toggle="modal" data-bs-target="#modalEliminarNoticia">
                                Eliminar
                            </button>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="accion" value="borrador" class="btn btn-outline-secondary rounded-pill px-4">
                            Guardar Borrador
                        </button>
                        <button type="submit" name="accion" value="revisar" class="btn btn-chipi text-white rounded-pill px-4 fw-bold shadow-sm">
                            Mandar a Revisar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if ($es_edicion): ?>
    <div class="modal fade" id="modalEliminarNoticia" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-5">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-danger" id="modalEliminarLabel">Confirmar eliminacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <p class="text-secondary fs-5 mb-0">
                        ¿Segura que queres borrar este borrador?
                    </p>
                    <small class="text-muted d-block mt-2">
                        Esta accion no se puede deshacer. La informacion se eliminara definitivamente de la base de datos.
                    </small>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Cancelar</button>

                    <a href="?page=eliminar-noticia&id=<?= $noticia['id'] ?>" class="btn btn-danger rounded-pill px-4 fw-bold">
                        Si, eliminar borrador
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>
