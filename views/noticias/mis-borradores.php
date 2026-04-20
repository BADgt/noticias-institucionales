<div class="container py-4">
    <div class="mb-4">
        <a href="?page=home" class="btn btn-light rounded-pill px-3 border shadow-sm">← Volver al Inicio</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0 text-dark">Mis Borradores <span class="text-chipi">치피</span></h2>
        <a href="?page=nueva-noticia" class="btn btn-chipi text-white rounded-pill px-4 fw-bold shadow-sm">+ Nuevo Borrador</a>
    </div>

    <div class="card border-0 shadow-sm rounded-5 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-chipi text-white">
                    <tr>
                        <th class="ps-4 py-3 border-0">Título</th>
                        <th class="py-3 border-0">Última Modificación</th>
                        <th class="text-end pe-4 py-3 border-0">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($borradores) > 0): ?>
                        <?php while($b = mysqli_fetch_assoc($borradores)): ?>
                        <tr>
                            <td class="ps-4 py-3 fw-bold text-dark"><?= e($b['titulo']) ?></td>
                            <td class="text-secondary"><?= date('d/m/Y H:i', strtotime($b['fecha_creacion'])) ?></td>
                            <td class="text-end pe-4">
                                <a href="?page=editar-noticia&id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-chipi rounded-pill px-3 fw-bold">
                                    Continuar Editando
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">No tenés borradores guardados. ✨</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>