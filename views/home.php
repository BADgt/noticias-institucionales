<?php 
    $roles = $_SESSION['usuario_roles'] ?? []; 
    $es_editor = in_array(1, $roles);
    $es_validador = in_array(2, $roles);
?>

<div class="container py-4">
    <div class="hero-box text-center mb-5 p-5 rounded-5 shadow-lg" 
         style="background: linear-gradient(135deg, #1e3d1a 0%, #43a047 100%); border: none;">
        
        <h1 class="display-3 fw-bold mb-3 text-white">Chipi News 🍏</h1>
        <p class="lead opacity-90 mb-4 fw-medium text-white">
            <?= isset($_SESSION['usuario_id']) ? "¡Hola de nuevo, " . e($_SESSION['usuario_nombre']) . "! Tenés el control del portal." : "Las noticias de la UNSL, frescas y verificadas." ?>
        </p>
        
        <div class="d-flex justify-content-center gap-3">
            <a href="?page=noticias" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-chipi shadow">Explorar Novedades</a>
            <?php if(isset($_SESSION['usuario_id'])): ?>
                <a href="?page=perfil" class="btn btn-outline-light btn-lg rounded-pill px-4">Mi Perfil</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (isset($_SESSION['usuario_id'])): ?>
        <div class="row g-4">
            <?php if ($es_editor): ?>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-5 p-4 bg-white transition-hover">
                    <div class="d-flex align-items-start">
                        <div class="bg-chipi-light rounded-4 p-3 me-3">
                            <span class="fs-1">📝</span>
                        </div>
                        <div>
                            <h3 class="fw-bold text-dark mb-2">Redacción</h3>
                            <p class="text-secondary mb-4">Escribí nuevas historias, gestioná borradores y mantené informada a la comunidad.</p>
                            <div class="d-flex gap-2">
                                <a href="?page=nueva-noticia" class="btn btn-chipi text-white rounded-pill px-4 fw-bold">Nueva Noticia</a>
                                <a href="?page=mis-borradores" class="btn btn-light rounded-pill px-3 border">Mis Borradores</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($es_validador): ?>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-5 p-4 bg-white transition-hover">
                    <div class="d-flex align-items-start">
                        <div class="bg-primary-light rounded-4 p-3 me-3">
                            <span class="fs-1">🛡️</span>
                        </div>
                        <div>
                            <h3 class="fw-bold text-dark mb-2">Validación</h3>
                            <p class="text-secondary mb-4">Revisá las propuestas de los editores y decidí qué noticias se publican hoy.</p>
                            <a href="?page=validar-noticias" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">Revisar Ahora</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Estilos para mantener la consistencia */
    .bg-chipi-light { background-color: #f1f8e9; }
    .bg-primary-light { background-color: #e3f2fd; }
    
    /* Animación suave para las tarjetas */
    .transition-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }

    /* Respetamos tus colores originales de los botones en el style.css */
</style>