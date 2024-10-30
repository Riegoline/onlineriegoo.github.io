document.addEventListener('DOMContentLoaded', function() {
    // Animación suave al hacer scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Función para mostrar contenido al hacer clic en los elementos de la lista
    function setupClickableList(listId, contentId) {
        const list = document.getElementById(listId);
        const contentBox = document.getElementById(contentId);
        
        if (list && contentBox) {
            list.addEventListener('click', function(e) {
                const target = e.target.closest('li');
                if (target) {
                    const text = target.getAttribute('data-content');
                    contentBox.textContent = text;
                    contentBox.classList.add('active');
                    
                    // Remover la clase 'active' de todos los elementos
                    list.querySelectorAll('li').forEach(li => li.classList.remove('active'));
                    
                    // Agregar la clase 'active' al elemento clicado
                    target.classList.add('active');

                    // Scroll suave hasta el contenido
                    contentBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            });
        }
    }

    // Configurar listas clickeables
    setupClickableList('valores-list', 'valores-content');
    setupClickableList('carreras-list', 'carreras-content');
    setupClickableList('actividades-list', 'actividades-content');

    // Mostrar/ocultar formulario de contacto
    const contactLink = document.getElementById('contact-link');
    const contactForm = document.getElementById('contact-form');
    if (contactLink && contactForm) {
        contactLink.addEventListener('click', (e) => {
            e.preventDefault();
            contactForm.style.display = contactForm.style.display === 'none' ? 'block' : 'none';
        });
    }

    // Manejar envío del formulario
    const emailForm = document.getElementById('email-form');
    if (emailForm) {
        emailForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            alert(`Gracias por tu mensaje. Te contactaremos pronto en ${email}.`);
            emailForm.reset();
            contactForm.style.display = 'none';
        });
    }

    // Animación de imágenes al hacer scroll
    const images = document.querySelectorAll('.img-fluid');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.5 });

    images.forEach(img => {
        img.style.opacity = '0';
        img.style.transform = 'translateY(20px)';
        img.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(img);
    });
});