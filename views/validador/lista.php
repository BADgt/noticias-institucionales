<div class="container py-4">
    <div class="mb-4">
        <a href="?page=home" class="btn btn-light rounded-pill px-3 border shadow-sm">← Volver al Inicio</a>
    </div>

    <div class="mb-4">
        <h2 class="fw-bold text-dark m-0">Gestión de Validación 🛡️</h2>
        <p class="text-secondary">Noticias esperando revisión para ser publicadas.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-5 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="ps-4 py-3 border-0">Noticia</th>
                        <th class="py-3 border-0">Autor</th>
                        <th class="py-3 border-0">Fecha de Envío</th>
                        <th class="text-end pe-4 py-3 border-0">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($noticias_pendientes) > 0): ?>
                        <?php while($n = mysqli_fetch_assoc($noticias_pendientes)): ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark"><?= e($n['titulo']) ?></div>
                                <small class="text-muted d-block text-truncate" style="max-width: 250px;"><?= e($n['resumen']) ?></small>
                            </td>
                            <td class="text-dark">
                                <span class="badge bg-light text-dark border rounded-pill px-2">
                                    <?= e($n['nombre']) ?> <?= e($n['apellido']) ?>
                                </span>
                            </td>
                            <td class="text-secondary small">
                                <?= date('d/m/Y', strtotime($n['fecha_creacion'])) ?><br>
                                <?= date('H:i', strtotime($n['fecha_creacion'])) ?> hs
                            </td>
                            <td class="text-end pe-4">
                                <a href="?page=revisar-noticia&id=<?= $n['id'] ?>" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                    Revisar
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <span class="display-4 d-block mb-2">✅</span>
                                No hay noticias pendientes de validación.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>