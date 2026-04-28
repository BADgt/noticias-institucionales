document.addEventListener('DOMContentLoaded', function() {
    // Usamos una función para que se pueda reutilizar si hay más de un campo
    const togglePassword = () => {
        const btnToggle = document.getElementById('btnTogglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');

        // Solo si los TRES existen en la página, activamos la lógica
        if (btnToggle && passwordInput && eyeIcon) {
            btnToggle.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
                    eyeIcon.classList.add('active'); // Se pone verde manzana
                } else {
                    eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
                    eyeIcon.classList.remove('active'); // Vuelve al gris
                }
            });
        }
    };

    togglePassword();
});
function previewImage(input) {
    const preview = document.getElementById('img-preview');
    const placeholder = document.getElementById('placeholder-content');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Ponemos la imagen que acabamos de elegir
            preview.src = e.target.result;
            
            // EL TRUCO: Le quitamos la clase d-none de Bootstrap
            preview.classList.remove('d-none');
            
            // Nos aseguramos que se vea (por si las dudas)
            preview.style.display = 'block'; 
            
            // Ocultamos el "+" para que no quede abajo de la foto
            if (placeholder) {
                placeholder.classList.add('d-none');
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}