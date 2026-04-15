<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-auth p-4 p-md-5">
            <h2 class="fw-bold mb-2">Redactar Noticia</h2>
            <p class="text-muted mb-4 small">Tu noticia se guardará como <strong>Borrador</strong> hasta que sea validada.</p>

            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger border-0 rounded-4 small shadow-sm mb-4">
                    <ul class="mb-0">
                        <?php foreach ($errores as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="?page=guardar-noticia">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">Título de la noticia</label>
                    <input type="text" name="titulo" class="form-control rounded-4 px-3 py-2" 
                           placeholder="Entre 10 y 100 caracteres..." required 
                           value="<?= e($_POST['titulo'] ?? '') ?>">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-secondary">Descripción completa</label>
                    <textarea name="contenido" rows="6" class="form-control rounded-4 px-3 py-2" 
                              placeholder="Escribí al menos 50 caracteres..." required><?= e($_POST['contenido'] ?? '') ?></textarea>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-chipi rounded-pill px-5 py-2 text-white fw-bold shadow-sm">
                        Guardar Borrador
                    </button>
                    <a href="?page=home" class="btn btn-light rounded-pill px-4 py-2 text-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>