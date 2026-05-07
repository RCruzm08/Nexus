document.addEventListener('DOMContentLoaded', () => {
    spawnParticles();
    glitchLogo();
    liveTime();
});

function spawnParticles() {
    for (let i = 0; i < 22; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        const size = Math.random() * 3 + 1.5;
        Object.assign(p.style, {
            left:              Math.random() * 100 + '%',
            width:             size + 'px',
            height:            size + 'px',
            animationDuration: (Math.random() * 14 + 8) + 's',
            animationDelay:    (Math.random() * 16) + 's',
        });
        document.body.appendChild(p);
    }
}

function glitchLogo() {
    const logo = document.querySelector('.logo');
    if (!logo) return;
    let count = 0;
    const iv = setInterval(() => {
        if (++count > 6) { clearInterval(iv); return; }
        logo.style.filter = `drop-shadow(0 0 ${25 + Math.random() * 30}px rgba(0,245,255,${0.4 + Math.random() * 0.5}))`;
    }, 90);
}

function liveTime() {
    const el = document.getElementById('live-time');
    if (!el) return;
    const tick = () => { el.textContent = new Date().toLocaleTimeString('pt-BR'); };
    tick();
    setInterval(tick, 1000);
}
