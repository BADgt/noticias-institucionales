<div class="container py-4">

    <?php 
    /* * Validamos si la URL contiene el parametro success.
     * Este parametro es enviado por el archivo index.php tras procesar un formulario.
     */
    if (isset($_GET['success'])): 
    ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-4 mb-4 d-flex align-items-center" role="alert">
            <div>
                <h5 class="fw-bold mb-1 text-success">Accion realizada con exito</h5>
                <p class="mb-0 small text-secondary">
                    <?php 
                    /* * Mostramos un mensaje diferente segun el valor recibido.
                     * success=1 indica una nueva noticia creada.
                     * success=update indica una noticia editada.
                     */
                    if ($_GET['success'] == '1') {
                        echo "Tu noticia ha sido procesada y guardada correctamente en el sistema.";
                    } elseif ($_GET['success'] == 'update') {
                        echo "Los cambios realizados en la publicacion han sido actualizados exitosamente.";
                    }
                    ?>
                </p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="hero-box text-center">
        <h1 class="display-3 fw-bold mb-3 text-white">Chipi 치피 News</h1>
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
        <h2 class="fw-bold mb-4">Últimas Novedades</h2>
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