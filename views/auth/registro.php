<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card-auth p-5 shadow-sm rounded-4 bg-white border-0">
            <h2 class="fw-bold text-center mb-4">Crear Cuenta <span class="text-chipi">치피</span></h2>

            <?php include '../views/noticias/errores.php'; ?>

            <form action="?page=procesar-registro" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nombre</label>
                        <input type="text" name="nombre" class="form-control rounded-pill px-3" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Apellido</label>
                        <input type="text" name="apellido" class="form-control rounded-pill px-3" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control rounded-pill px-3" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" id="passwordInput" class="form-control rounded-start-4 border-end-0" required>

                        <span class="input-group-text rounded-end-4 bg-white px-3" id="btnTogglePassword" style="cursor: pointer; border-color: #dee2e6;">
                            <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label d-block fw-bold">Roles Solicitados:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="1" id="rolEditor" checked>
                        <label class="form-check-label" for="rolEditor">Editor</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="2" id="rolValidador">
                        <label class="form-check-label" for="rolValidador">Validador</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-chipi w-100 rounded-pill py-2 fw-bold text-white shadow-sm">
                    Registrarse
                </button>
            </form>
        </div>
    </div>
</div>