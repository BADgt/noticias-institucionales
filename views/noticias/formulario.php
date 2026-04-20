<?php
// Determinamos si estamos editando o creando una nueva
$es_edicion = isset($noticia);
$titulo_vista = $es_edicion ? "Editar Noticia ✍️" : "Redactar Noticia ✍️";
$accion_url = $es_edicion ? "?page=actualizar-noticia" : "?page=guardar-noticia";
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="mb-4">
            <a href="?page=home" class="btn btn-light rounded-pill px-3 border shadow-sm">← Volver al Inicio</a>
        </div>

        <div class="card border-0 shadow-sm rounded-5 p-5 bg-white">
            <h2 class="fw-bold mb-4"><?= $titulo_vista ?></h2>
            
            <form action="<?= $accion_url ?>" method="POST" enctype="multipart/form-data">
                <?php if($es_edicion): ?>
                    <input type="hidden" name="id" value="<?= $noticia['id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label fw-bold">Título</label>
                    <input type="text" name="titulo" class="form-control rounded-4 px-3" 
                           value="<?= $es_edicion ? e($noticia['titulo']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Resumen (Bajada)</label>
                    <textarea name="resumen" class="form-control rounded-4 px-3" rows="2"><?= $es_edicion ? e($noticia['resumen']) : '' ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Imagen de Portada</label>
                    
                    <div id="preview-container" class="mb-3 <?= ($es_edicion && $noticia['imagen']) ? '' : 'd-none' ?>">
                        <p class="small text-muted mb-2">Vista previa de la foto:</p>
                        <img id="img-preview" 
                             src="<?= ($es_edicion && $noticia['imagen']) ? 'uploads/' . $noticia['imagen'] : '#' ?>" 
                             class="rounded-4 shadow-sm border" 
                             style="max-height: 250px; width: 100%; object-fit: cover;">
                    </div>

                    <input type="file" name="imagen" id="noticia-imagen" class="form-control rounded-4" accept="image/*" onchange="previewImage(this)">
                    <small class="text-muted">Si seleccionás una nueva, se reemplazará la anterior.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Contenido de la Noticia</label>
                    <textarea name="contenido" class="form-control rounded-4 px-3" rows="8" required><?= $es_edicion ? e($noticia['descripcion']) : '' ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="?page=home" class="btn btn-light rounded-pill px-4 border">Cancelar</a>
                    
                    <button type="submit" name="accion" value="borrador" class="btn btn-outline-secondary rounded-pill px-4">
                        Guardar Borrador
                    </button>
                    <button type="submit" name="accion" value="revisar" class="btn btn-chipi text-white rounded-pill px-4 fw-bold shadow-sm">
                        Mandar a Revisar 🚀
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('img-preview');
    const container = document.getElementById('preview-container');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.classList.remove('d-none'); // Mostramos el contenedor si estaba oculto
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>