document.addEventListener('DOMContentLoaded', () => {
    spawnParticles();
    animateBars();
    liveTime();
    initMusic();
    highlightNav();
});

function spawnParticles() {
    for (let i = 0; i < 18; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        const size = Math.random() * 3 + 1;
        Object.assign(p.style, {
            left:              Math.random() * 100 + '%',
            width:             size + 'px',
            height:            size + 'px',
            animationDuration: (Math.random() * 15 + 10) + 's',
            animationDelay:    (Math.random() * 18) + 's',
        });
        document.body.appendChild(p);
    }
}

function animateBars() {
    requestAnimationFrame(() => {
        document.querySelectorAll('[data-width]').forEach(el => {
            el.style.width = el.dataset.width + '%';
        });
    });
}

function liveTime() {
    const el = document.getElementById('live-time');
    if (!el) return;
    const tick = () => {
        el.textContent = new Date().toLocaleTimeString('pt-BR', { hour12: false });
    };
    tick();
    setInterval(tick, 1000);
}

function highlightNav() {
    const path = window.location.pathname.split('/').pop();
    document.querySelectorAll('.nav a').forEach(a => {
        a.classList.toggle('active', a.getAttribute('href') === path);
    });
}

const tracks = [
    { title: 'NEON PROTOCOL',   artist: 'CYBERDRIVE' },
    { title: 'GHOST SIGNAL',    artist: 'NULLWAVE' },
    { title: 'SYSTEM BREACH',   artist: 'HEXCORE' },
    { title: 'DARK FREQUENCY',  artist: 'PHANTOM.EXE' },
    { title: 'NEURAL STATIC',   artist: 'DATASYNTH' },
];

let trackIdx = 0;
let playing  = false;
let progress = 35;
let progressTimer = null;
let audioCtx = null;
let oscillator = null;

function initMusic() {
    updateTrackUI();
    document.getElementById('btn-prev')?.addEventListener('click', prevTrack);
    document.getElementById('btn-play')?.addEventListener('click', togglePlay);
    document.getElementById('btn-next')?.addEventListener('click', nextTrack);
}

function updateTrackUI() {
    const t = tracks[trackIdx];
    const titleEl  = document.getElementById('music-title');
    const artistEl = document.getElementById('music-artist');
    if (titleEl)  titleEl.textContent  = t.title;
    if (artistEl) artistEl.textContent = t.artist;
}

function togglePlay() {
    playing = !playing;
    const btn = document.getElementById('btn-play');
    if (btn) {
        btn.textContent = playing ? '⏸' : '▶';
        btn.classList.toggle('playing', playing);
    }

    if (playing) {
        startAmbientSound();
        progressTimer = setInterval(() => {
            progress = (progress + 0.5) % 100;
            const bar = document.getElementById('music-progress');
            if (bar) bar.style.width = progress + '%';
        }, 500);
    } else {
        stopAmbientSound();
        clearInterval(progressTimer);
    }
}

function prevTrack() {
    trackIdx = (trackIdx - 1 + tracks.length) % tracks.length;
    progress = 0;
    updateTrackUI();
    if (playing) { stopAmbientSound(); startAmbientSound(); }
}

function nextTrack() {
    trackIdx = (trackIdx + 1) % tracks.length;
    progress = 0;
    updateTrackUI();
    if (playing) { stopAmbientSound(); startAmbientSound(); }
}

function startAmbientSound() {
    try {
        audioCtx   = new (window.AudioContext || window.webkitAudioContext)();
        const freqs  = [55, 80, 110, 160, 220];
        const baseFreq = freqs[trackIdx % freqs.length];

        oscillator = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        const filter = audioCtx.createBiquadFilter();

        oscillator.type      = 'sawtooth';
        oscillator.frequency.setValueAtTime(baseFreq, audioCtx.currentTime);
        filter.type          = 'lowpass';
        filter.frequency.setValueAtTime(400, audioCtx.currentTime);
        gain.gain.setValueAtTime(0, audioCtx.currentTime);
        gain.gain.linearRampToValueAtTime(0.04, audioCtx.currentTime + 0.5);

        oscillator.connect(filter);
        filter.connect(gain);
        gain.connect(audioCtx.destination);
        oscillator.start();
    } catch (_) {}
}

function stopAmbientSound() {
    try {
        if (oscillator) { oscillator.stop(); oscillator = null; }
        if (audioCtx)   { audioCtx.close();  audioCtx = null; }
    } catch (_) {}
}
