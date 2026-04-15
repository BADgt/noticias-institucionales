<div class="row justify-content-center">
    <div class="col-lg-9">
        <a href="?page=noticias" class="text-decoration-none text-chipi fw-bold mb-4 d-inline-block">
            ← Volver a Novedades
        </a>

        <article class="card-news p-4 p-md-5">
            <header class="mb-5 text-center">
                <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                    <span class="badge rounded-pill" style="background-color: var(--light-green); color: var(--dark-green); padding: 0.6rem 1.2rem;">
                        <?= e($noticia['estado']) ?>
                    </span>
                    <span class="text-muted fw-bold small text-uppercase">Publicado el <?= date('d/m/Y', strtotime($noticia['fecha_creacion'])) ?></span>
                </div>
                <h1 class="display-4 fw-bold text-dark"><?= e($noticia['titulo']) ?></h1>
            </header>

            <div class="noticia-contenido" style="font-size: 1.15rem; line-height: 1.8; color: #334155;">
                <?= nl2br(e($noticia['descripcion'])) ?>
            </div>

            <footer class="mt-5 pt-4 border-top">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px; background-color: var(--primary-green); color: white; font-weight: bold;">
                             B
                        </div>
                        <div>
                            <p class="m-0 fw-bold">Brisa Ahylin Dágata</p>
                            <p class="m-0 text-muted small">Redacción Chipi News</p>
                        </div>
                    </div>
                    <div class="text-muted small">
                        San Luis, Argentina
                    </div>
                </div>
            </footer>
        </article>
    </div>
</div>