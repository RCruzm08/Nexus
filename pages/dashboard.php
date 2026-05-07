<?php
require_once '../includes/auth.php';

global $NEXUS_GAMES, $NEXUS_ACTIVITY, $NEXUS_LEADERBOARD;

$u    = $currentUser;
$xpPc = xpPercent($u);
$wr   = winRate($u);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS // DASHBOARD</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="grid-bg"></div>
    <div class="scanline"></div>

    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="nx">NEXUS</div>
            <div class="ver">v2.0.4 // NEURAL HUB</div>
        </div>

        <div class="sidebar-user">
            <div class="avatar-ring">🔴</div>
            <div class="user-meta">
                <div class="name"><?= htmlspecialchars($u['displayName']) ?></div>
                <div class="rank"><?= htmlspecialchars($u['rank']) ?></div>
            </div>
        </div>

        <nav class="nav">
            <div class="nav-section">// CORE</div>
            <a href="dashboard.php"><span class="icon">⬡</span> DASHBOARD</a>
            <a href="profile.php"><span class="icon">◈</span> PROFILE</a>
            <a href="stats.php"><span class="icon">▦</span> STATISTICS</a>

            <div class="nav-section">// CONTENT</div>
            <a href="library.php"><span class="icon">◻</span> LIBRARY</a>
            <a href="leaderboard.php"><span class="icon">▲</span> LEADERBOARD</a>

            <div class="nav-section">// SYSTEM</div>
            <a href="discord.php"><span class="icon">◈</span> DISCORD</a>
            <a href="settings.php"><span class="icon">⚙</span> SETTINGS</a>
        </nav>

        <div class="sidebar-bottom">
            <a href="../logout.php" class="logout-btn">⏻ &nbsp; DISCONNECT</a>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div class="page-title">DASH<span>BOARD</span></div>
            <div class="topbar-right">
                <span><span class="status-dot"></span><?= htmlspecialchars($u['status']) ?></span>
                <span><?= htmlspecialchars($u['faction']) ?></span>
                <span id="live-time"><?= date('H:i:s') ?></span>
            </div>
        </div>

        <div class="grid-4" style="margin-bottom:20px;">
            <div class="stat-card">
                <div class="val"><?= $u['level'] ?></div>
                <div class="lbl">LEVEL</div>
            </div>
            <div class="stat-card">
                <div class="val" style="color:var(--green);text-shadow:0 0 20px rgba(0,255,136,0.5);"><?= $u['wins'] ?></div>
                <div class="lbl">WINS</div>
            </div>
            <div class="stat-card">
                <div class="val" style="color:var(--yellow);text-shadow:0 0 20px rgba(255,230,0,0.5);"><?= $u['kd'] ?></div>
                <div class="lbl">K/D RATIO</div>
            </div>
            <div class="stat-card">
                <div class="val" style="color:var(--magenta);text-shadow:0 0 20px rgba(255,0,110,0.5);"><?= $wr ?></div>
                <div class="lbl">WIN RATE</div>
            </div>
        </div>

        <div class="grid-2" style="margin-bottom:20px;">
            <div class="card">
                <div class="card-title">⬡ XP PROGRESSION</div>
                <div style="display:flex;align-items:baseline;gap:10px;margin-bottom:14px;">
                    <span style="font-family:var(--font-hud);font-size:2.2rem;font-weight:900;"><?= number_format($u['xp']) ?></span>
                    <span style="font-size:0.65rem;color:var(--text-dim);letter-spacing:0.1em;">/ <?= number_format($u['xp_next']) ?> XP</span>
                </div>
                <div class="xp-bar-wrap">
                    <div class="xp-bar-track">
                        <div class="xp-bar-fill" data-width="<?= $xpPc ?>" style="width:0%"></div>
                    </div>
                    <div class="xp-meta">
                        <span>LVL <?= $u['level'] ?></span>
                        <span><?= $xpPc ?>%</span>
                        <span>LVL <?= $u['level'] + 1 ?></span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-title">◈ OPERATOR SKILLS</div>
                <?php foreach ($u['skills'] as $skill => $val): ?>
                <div class="skill-bar-row">
                    <div class="skill-bar-header">
                        <span><?= $skill ?></span>
                        <span><?= $val ?></span>
                    </div>
                    <div class="skill-bar-track">
                        <div class="skill-bar-fill" data-width="<?= $val ?>" style="width:0%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <div class="music-player">
                <span style="font-size:1.4rem;">🎵</span>
                <div class="music-info">
                    <div class="music-title" id="music-title">NEON PROTOCOL</div>
                    <div class="music-artist" id="music-artist">CYBERDRIVE</div>
                </div>
                <div class="music-controls">
                    <button class="music-btn" id="btn-prev">⏮</button>
                    <button class="music-btn" id="btn-play">▶</button>
                    <button class="music-btn" id="btn-next">⏭</button>
                </div>
                <div class="music-bar">
                    <div class="music-progress" id="music-progress"></div>
                </div>
            </div>
        </div>

        <div class="grid-2" style="margin-bottom:20px;">
            <div class="card">
                <div class="card-title">▦ RECENT ACTIVITY</div>
                <?php foreach ($NEXUS_ACTIVITY as $item): ?>
                <div class="activity-item">
                    <div class="activity-dot dot-<?= $item['type'] ?>"></div>
                    <span class="activity-time"><?= $item['time'] ?></span>
                    <span><?= htmlspecialchars($item['msg']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="card">
                <div class="card-title">▲ LEADERBOARD</div>
                <?php foreach ($NEXUS_LEADERBOARD as $row): ?>
                <div class="leaderboard-row <?= $row['you'] ? 'you' : '' ?>">
                    <span class="lb-pos <?= $row['pos'] === 1 ? 'gold' : ($row['pos'] === 2 ? 'silver' : ($row['pos'] === 3 ? 'bronze' : '')) ?>">#<?= $row['pos'] ?></span>
                    <span class="lb-name"><?= htmlspecialchars($row['name']) ?> <?= $row['you'] ? '<small style="color:var(--cyan);font-size:0.55rem;">[YOU]</small>' : '' ?></span>
                    <span class="lb-faction"><?= $row['faction'] ?></span>
                    <span class="lb-score"><?= number_format($row['score']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-title">◈ DISCORD INTEGRATION</div>
            <div class="discord-card">
                <div class="discord-logo">🎮</div>
                <div class="discord-info">
                    <div class="label">// CONNECTED ACCOUNT</div>
                    <div class="handle"><?= htmlspecialchars($u['discord']) ?></div>
                    <div class="meta"><span class="status-dot"></span>SYNCED &nbsp;|&nbsp; FACTION: <?= htmlspecialchars($u['faction']) ?></div>
                </div>
                <a href="discord.php" class="discord-btn">[ VIEW DISCORD ]</a>
            </div>
        </div>

        <div class="card">
            <div class="card-title">◻ GAME LIBRARY</div>
            <div class="grid-3">
                <?php foreach (array_slice($NEXUS_GAMES, 0, 6) as $g): ?>
                <div class="game-card" style="border-top:2px solid <?= $g['color'] ?>;">
                    <span class="game-icon"><?= $g['icon'] ?></span>
                    <div class="game-rating">★ <?= $g['rating'] ?></div>
                    <div class="game-title"><?= htmlspecialchars($g['title']) ?></div>
                    <div class="game-genre"><?= htmlspecialchars($g['genre']) ?></div>
                    <span class="tag <?= strtolower($g['status']) ?>"><?= $g['status'] ?></span>
                    <div class="game-hours"><?= $g['hours'] ?>h played</div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <script src="../assets/js/dashboard.js"></script>
</body>
</html>
