<?php
$historial = obtenerHistorialUsuario($conn, $_SESSION['usuario_id']);
?>

<div class="container py-4">
    <div class="mb-4">
        <a href="?page=home" class="btn btn-light rounded-pill px-3 border shadow-sm">← Volver al Inicio</a>
    </div>

    <div class="row g-4">
        <div class="col-md-4 text-center">
            <div class="card border-0 shadow-sm rounded-5 p-4 bg-white">
                <div class="rounded-circle bg-chipi-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width:120px; height:120px;">
                    <h1 class="display-3 m-0 text-chipi"><?= strtoupper(substr($_SESSION['usuario_nombre'], 0, 1)) ?></h1>
                </div>
                <h4 class="fw-bold"><?= e($_SESSION['usuario_nombre']) ?> <?= e($_SESSION['usuario_apellido']) ?></h4>
                <p class="text-muted small"><?= e($_SESSION['usuario_email']) ?></p>

                <div class="my-3">
                    <p class="small text-uppercase fw-bold text-secondary mb-2">Tus Permisos:</p>
                    <?php
                    $roles = (array)$_SESSION['usuario_roles'];
                    foreach ($roles as $rol): ?>
                        <span class="badge rounded-pill px-3 py-2 shadow-sm" style="background-color: #1e3d1a; color: white; font-weight: 600;">
                            <?= (trim($rol) == 1) ? 'Editor' : 'Validador' ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                <a href="?page=logout" class="btn btn-outline-danger w-100 rounded-pill mt-3">Cerrar Sesión</a>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-5 p-4 bg-white h-100">
                <h5 class="fw-bold mb-4">Mi Historial Reciente 📂</h5>
                <div class="list-group list-group-flush">
                    <?php if (mysqli_num_rows($historial) > 0): ?>
                        <?php while ($h = mysqli_fetch_assoc($historial)): ?>
                            <?php
                            // Decidimos a dónde mandar al usuario según el estado
                            // Si es borrador, vamos a editar. Si no, a la vista pública.
                            $pagina_destino = ($h['estado'] == 'Borrador') ? 'editar-noticia' : 'noticia';
                            ?>
                            <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center border-bottom bg-transparent">
                                <div class="d-flex align-items-center gap-3">
                                    <a href="?page=<?= $pagina_destino ?>&id=<?= $h['id'] ?>" class="text-decoration-none fs-5" title="Ver contenido">
                                        <?= ($h['estado'] == 'Borrador') ? '📝' : '🔍' ?>
                                    </a>
                                    <div>
                                        <a href="?page=<?= $pagina_destino ?>&id=<?= $h['id'] ?>" class="h6 fw-bold mb-0 text-dark text-decoration-none hover-chipi">
                                            <?= e($h['titulo']) ?>
                                        </a>
                                        <br>
                                        <small class="text-muted"><?= date('d/m/Y', strtotime($h['fecha_creacion'])) ?></small>
                                    </div>
                                </div>

                                <?php
                                $badge_color = 'bg-warning text-dark';
                                if ($h['estado'] == 'Publicada') $badge_color = 'bg-success';
                                if ($h['estado'] == 'Anulada') $badge_color = 'bg-danger';
                                if ($h['estado'] == 'Lista para Validación') $badge_color = 'bg-info text-dark';
                                ?>
                                <span class="badge rounded-pill <?= $badge_color ?> px-3">
                                    <?= $h['estado'] ?>
                                </span>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <p class="text-muted">Todavía no tenés actividad registrada. ✨</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>