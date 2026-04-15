<div class="row justify-content-center py-5">
    <div class="col-md-6 col-lg-5">
        <div class="card-auth"> <div class="text-center mb-4">
                <h2 class="fw-bold">Unirse a <br>Chipi <span class="text-chipi">치피</span> News</h2>
                <p class="text-muted small">Creá tu cuenta de editor para empezar</p>
            </div>

            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger border-0 rounded-4 small shadow-sm mb-4">
                    <ul class="mb-0">
                        <?php foreach ($errores as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="?page=procesar-registro">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">Nombre Completo</label>
                    <input type="text" name="nombre" class="form-control rounded-pill px-3 py-2" placeholder="Ej: Brisa Ahylin" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">Correo Institucional</label>
                    <input type="email" name="email" class="form-control rounded-pill px-3 py-2" placeholder="usuario@unsl.edu.ar" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold small text-secondary">Contraseña</label>
                    <input type="password" name="password" class="form-control rounded-pill px-3 py-2" placeholder="Mínimo 6 caracteres" required>
                </div>
                <button type="submit" class="btn btn-chipi w-100 rounded-pill py-2 shadow-sm text-white fw-bold">
                    Completar Registro
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="small text-muted">¿Ya tenés cuenta? <a href="?page=login" class="text-chipi fw-bold text-decoration-none">Iniciá sesión</a></p>
            </div>
        </div>
    </div>
</div>