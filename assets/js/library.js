function filterGames(status, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('#game-grid .game-card-lg').forEach(card => {
        const match = status === 'ALL' || card.dataset.status === status;
        card.style.display = match ? '' : 'none';
    });
}
