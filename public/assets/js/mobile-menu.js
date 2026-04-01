document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    const body = document.body;

    if (!menuToggle || !navLinks) return;

    menuToggle.addEventListener('click', (e) => {
        e.stopPropagation(); // Empêche le clic de se propager
        menuToggle.classList.toggle('active');
        navLinks.classList.toggle('active');
        body.classList.toggle('no-scroll');
    });

    // Fermer le menu si on clique sur un lien
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            menuToggle.classList.remove('active');
            navLinks.classList.remove('active');
            body.classList.remove('no-scroll');
        });
    });

    // Fermer le menu si on clique en dehors
    document.addEventListener('click', (e) => {
        if (navLinks.classList.contains('active') && !navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
            menuToggle.classList.remove('active');
            navLinks.classList.remove('active');
            body.classList.remove('no-scroll');
        }
    });

    // Gérer le redimensionnement de la fenêtre
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && navLinks.classList.contains('active')) {
            menuToggle.classList.remove('active');
            navLinks.classList.remove('active');
            body.classList.remove('no-scroll');
        }
    });
});
