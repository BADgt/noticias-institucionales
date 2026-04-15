<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Chipi 치피 News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="?page=home">
            Chipi <span class="text-chipi">치피</span> News
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link px-3 fw-medium" href="?page=home">Inicio</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-medium" href="?page=noticias">Noticias</a></li>
                
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-chipi rounded-pill px-4 text-white shadow-sm fw-bold" href="?page=nueva-noticia">
                            + Redactar
                        </a>
                    </li>
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link p-0" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                 style="width: 42px; height: 42px; background-color: var(--light-green); border: 2px solid var(--primary-green);">
                                <span class="fw-bold" style="color: var(--dark-green);">
                                    <?= strtoupper(substr($_SESSION['usuario_nombre'], 0, 1)) ?>
                                </span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end rounded-4 border-0 shadow mt-3 py-2">
                            <li><h6 class="dropdown-header small text-uppercase opacity-50">Hola, <?= e($_SESSION['usuario_nombre']) ?></h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="?page=perfil">Mi Perfil</a></li>
                            <li><a class="dropdown-item text-danger fw-bold" href="?page=logout">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-4">
                        <a class="nav-link fw-bold text-chipi" href="?page=login">Ingresar</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-chipi rounded-pill px-4 text-white shadow-sm" href="?page=registro">Registrarse</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">