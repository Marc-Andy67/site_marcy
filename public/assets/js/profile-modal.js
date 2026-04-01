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
        const name = card.getAttribute('data-name');
        const imgText = card.getAttribute('data-img');
        const fullDesc = card.querySelector('.full-content').innerHTML;
        const constellationHtml = card.querySelector('.constellation-html').innerHTML;

        modalTitle.textContent = name;
        
        // Fix: Insert an actual img element instead of raw text
        modalImg.innerHTML = `<img src="${imgText}" alt="${name}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">`;
        
        modalDesc.innerHTML = fullDesc;
        modalConstellation.innerHTML = constellationHtml;
        modal.classList.add('active');
        body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeModal() {
        modal.classList.remove('active');
        body.style.overflow = '';
    }

    readMoreBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const card = e.target.closest('.profile-card');
            openModal(card);
        });
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    modal.addEventListener('touchend', (e) => {
        if (e.target === modal) {
            e.preventDefault(); // Prevent ghost clicks
            closeModal();
        }
    });
});