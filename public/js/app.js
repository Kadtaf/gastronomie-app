
    const toggleBtn = document.getElementById('theme-toggle');

    // Charger le thème sauvegardé
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);

    // Mettre à jour l’icône seulement si le bouton existe
if (toggleBtn) {
    toggleBtn.textContent = savedTheme === 'dark' ? '☀️' : '🌙';

    toggleBtn.addEventListener('click', () => {
        const current = document.documentElement.getAttribute('data-theme');
        const next = current === 'light' ? 'dark' : 'light';

        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);

        toggleBtn.textContent = next === 'dark' ? '☀️' : '🌙';
    });
}
