// Date cible : 22 août 2026 à 14h30
const weddingDate = new Date("2026-08-22T14:30:00-04:00").getTime();

const countdownFunction = setInterval(() => {
    const now = new Date().getTime();
    const distance = weddingDate - now;

    // Calculs du temps
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Affichage
    const element = document.getElementById("countdown-timer");
    if (element) {
        element.innerHTML = `
            <div class="time-unit"><span class="number">${days}</span><span class="label">Jours</span></div>
            <div class="time-unit"><span class="number">${hours}</span><span class="label">Heures</span></div>
            <div class="time-unit"><span class="number">${minutes}</span><span class="label">Minutes</span></div>
            <div class="time-unit"><span class="number">${seconds}</span><span class="label">Secondes</span></div>
        `;
    }

    // Si le compte à rebours est fini
    if (distance < 0) {
        clearInterval(countdownFunction);
        if (element) {
            element.innerHTML = "C'est le grand jour !";
        }
    }
}, 1000);
