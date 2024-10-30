document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.querySelector('.wrapper');
    const registerLink = document.querySelector('.register-link');
    const loginLink = document.querySelector('.login-link');

    const toggleForm = () => {
        wrapper.classList.toggle('active');
    };

    registerLink.addEventListener('click', function(e) {
        e.preventDefault();
        toggleForm();
    });

    loginLink.addEventListener('click', function(e) {
        e.preventDefault();
        toggleForm();
    });

    // Función para mostrar alerta de éxito
    window.mostrar = function() {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your work has been saved",
            showConfirmButton: false,
            timer: 1500
        });
    };
});