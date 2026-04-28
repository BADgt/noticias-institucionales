document.addEventListener('DOMContentLoaded', function() {
    // --- LÓGICA DEL OJITO (INTACTA) ---
    const togglePassword = () => {
        const btnToggle = document.getElementById('btnTogglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');

        if (btnToggle && passwordInput && eyeIcon) {
            btnToggle.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
                    eyeIcon.classList.add('active');
                } else {
                    eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
                    eyeIcon.classList.remove('active');
                }
            });
        }
    };

    togglePassword();
});

// --- LÓGICA DE IMAGEN (ACTUALIZADA) ---
function previewImage(input) {
    const preview = document.getElementById('img-preview');
    const placeholder = document.getElementById('placeholder-content');
    const btnClean = document.getElementById('btn-clean-preview');
    const inputBorrar = document.getElementById('borrar_imagen_actual'); // Buscamos al mensajero
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            preview.style.display = 'block'; 
            if (placeholder) placeholder.classList.add('d-none');
            if (btnClean) btnClean.classList.remove('d-none');
            
            // Si elige una foto nueva, nos aseguramos que el mensajero valga 0
            if (inputBorrar) inputBorrar.value = "0";
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removePreviewImage(event) {
    event.stopPropagation(); 
    
    const preview = document.getElementById('img-preview');
    const placeholder = document.getElementById('placeholder-content');
    const btnClean = document.getElementById('btn-clean-preview');
    const input = document.getElementById('noticia-imagen'); 
    const inputBorrar = document.getElementById('borrar_imagen_actual'); // Buscamos al mensajero

    if (input) input.value = ""; 
    
    // ¡ESTO ES LO NUEVO!: Le avisamos al PHP que el usuario quiere borrar la foto
    if (inputBorrar) inputBorrar.value = "1";
    
    if (preview) {
        preview.src = "#";
        preview.classList.add('d-none');
    }
    if (placeholder) placeholder.classList.remove('d-none');
    if (btnClean) btnClean.classList.add('d-none');
}