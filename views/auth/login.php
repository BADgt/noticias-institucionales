<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5">
        <div class="card-auth"> <div class="text-center mb-4">
                <h2 class="fw-bold">Chipi <span class="text-chipi">치피</span> News</h2>
                <p class="text-muted small">Ingresá para gestionar noticias</p>
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

            <form method="POST" action="?page=procesar-login">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">Email</label>
                    <input type="email" name="email" class="form-control rounded-pill px-3 py-2" placeholder="usuario@email.com" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold small text-secondary">Contraseña</label>
                    <input type="password" name="password" class="form-control rounded-pill px-3 py-2" placeholder="Tu clave secreta" required>
                </div>
                <button type="submit" class="btn btn-chipi w-100 rounded-pill py-2 text-white fw-bold shadow-sm">
                    Iniciar Sesión
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="small text-muted">¿Sos nueva? <a href="?page=registro" class="text-chipi fw-bold text-decoration-none">Registrate acá</a></p>
            </div>
        </div>
    </div>
</div>