<div class="row">
    <div class="col-12 mb-4">
        <h2 class="fw-bold">Gestión de Publicaciones 🛡️</h2>
        <p class="text-muted">Revisá las noticias enviadas por los editores antes de que salgan al portal.</p>
    </div>

    <div class="col-12">
        <div class="card-auth p-0 overflow-hidden shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0">Título</th>
                        <th class="py-3 border-0">Autor</th>
                        <th class="py-3 border-0">Estado</th>
                        <th class="py-3 text-end pe-4 border-0">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($n = mysqli_fetch_assoc($noticias_pendientes)): ?>
                        <tr>
                            <td class="ps-4 py-3 fw-bold"><?= e($n['titulo']) ?></td>
                            <td class="py-3"><?= e($n['nombre_autor']) ?></td>
                            <td class="py-3">
                                <span class="badge rounded-pill bg-warning text-dark px-3 fw-medium">
                                    <?= e($n['estado']) ?>
                                </span>
                            </td>
                            <td class="py-3 text-end pe-4">
                                <a href="?page=revisar-noticia&id=<?= $n['id'] ?>" class="btn btn-sm btn-chipi rounded-pill px-3 shadow-sm">
                                    Revisar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($noticias_pendientes) == 0): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                No hay noticias esperando validación por ahora. ✨
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>