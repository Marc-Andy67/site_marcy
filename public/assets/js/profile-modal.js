document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('profile-modal');
    const modalImg = document.getElementById('modal-img');
    const modalTitle = document.getElementById('modal-title');
    const modalDesc = document.getElementById('modal-desc');
    const modalConstellation = document.getElementById('modal-constellation');
    const closeBtn = document.querySelector('.modal-close');
    const readMoreBtns = document.querySelectorAll('.read-more-btn');
    const body = document.body;

    function openModal(card) {
        // Retrieve data from the card
        const name = card.getAttribute('data-name');
        const imgText = card.getAttribute('data-img');
        const fullDesc = card.querySelector('.full-content').innerHTML;
        const constellationHtml = card.querySelector('.constellation-html').innerHTML;

        // Populate modal
        modalTitle.textContent = name;
        modalImg.textContent = imgText;
        modalDesc.innerHTML = fullDesc;
        modalConstellation.innerHTML = constellationHtml;

        // Show modal with animation
        modal.classList.add('active');
        body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeModal() {
        modal.classList.remove('active');
        body.style.overflow = '';
    }

    // Event Listeners for Read More buttons
    readMoreBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const card = e.target.closest('.profile-card');
            openModal(card);
        });
    });

    // Close button
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    // Close on background click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close on simple tap on background (sometimes click is tricky on mobile)
    modal.addEventListener('touchend', (e) => {
        if (e.target === modal) {
            e.preventDefault(); // Prevent ghost clicks
            closeModal();
        }
    });
});
