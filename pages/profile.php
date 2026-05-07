<?php
require_once '../includes/auth.php';
$u = $currentUser;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS // PROFILE</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .profile-hero {
            background: linear-gradient(135deg, rgba(0,245,255,0.05), rgba(255,0,110,0.05));
            border: 1px solid var(--border);
            padding: 40px;
            display: flex;
            gap: 40px;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }
        .profile-hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--cyan), var(--magenta), var(--cyan));
        }
        .avatar-lg {
            width: 110px; height: 110px;
            border-radius: 50%;
            border: 3px solid var(--cyan);
            display: flex; align-items: center; justify-content: center;
            font-size: 3.5rem;
            box-shadow: var(--glow), inset 0 0 30px rgba(0,245,255,0.1);
            flex-shrink: 0;
            animation: pulse 3s ease infinite;
        }
        .profile-name {
            font-family: var(--font-hud);
            font-size: 2rem; font-weight: 900;
            letter-spacing: 0.15em;
        }
        .profile-rank {
            color: var(--magenta);
            font-size: 0.7rem; letter-spacing: 0.3em;
            margin: 6px 0 12px;
        }
        .profile-bio {
            font-family: var(--font-ui);
            color: var(--text-dim);
            font-size: 0.95rem;
            margin-bottom: 16px;
        }
        .profile-tags { display: flex; gap: 10px; flex-wrap: wrap; }
        .profile-tag {
            padding: 4px 14px;
            border: 1px solid var(--border);
            font-size: 0.6rem;
            letter-spacing: 0.2em;
            font-family: var(--font-hud);
            color: var(--text-dim);
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border2);
            font-size: 0.75rem;
        }
        .info-key { color: var(--text-dim); letter-spacing: 0.1em; }
        .info-val { font-family: var(--font-hud); font-size: 0.72rem; }
    </style>
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
            <a href="profile.php" class="active"><span class="icon">◈</span> PROFILE</a>
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
            <div class="page-title">OPER<span>ATOR PROFILE</span></div>
            <div class="topbar-right">
                <span><span class="status-dot"></span><?= $u['status'] ?></span>
                <span id="live-time"><?= date('H:i:s') ?></span>
            </div>
        </div>

        <div class="profile-hero">
            <div class="avatar-lg">🔴</div>
            <div>
                <div class="profile-name"><?= htmlspecialchars($u['displayName']) ?></div>
                <div class="profile-rank"><?= htmlspecialchars($u['rank']) ?></div>
                <div class="profile-bio"><?= htmlspecialchars($u['bio']) ?></div>
                <div class="profile-tags">
                    <span class="profile-tag">LVL <?= $u['level'] ?></span>
                    <span class="profile-tag"><?= htmlspecialchars($u['faction']) ?></span>
                    <span class="profile-tag tag online"><?= $u['status'] ?></span>
                    <span class="profile-tag"><?= $u['achievements'] ?> ACH</span>
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="card-title">◈ OPERATOR DATA</div>
                <div>
                    <div class="info-row">
                        <span class="info-key">USERNAME</span>
                        <span class="info-val"><?= htmlspecialchars($u['username']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">FACTION</span>
                        <span class="info-val" style="color:var(--cyan);"><?= htmlspecialchars($u['faction']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">DISCORD</span>
                        <span class="info-val" style="color:#7289da;"><?= htmlspecialchars($u['discord']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">JOINED</span>
                        <span class="info-val"><?= $u['joined'] ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">TOTAL PLAYTIME</span>
                        <span class="info-val" style="color:var(--yellow);"><?= number_format($u['playtime']) ?>h</span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">FRIENDS</span>
                        <span class="info-val"><?= $u['friends'] ?></span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-title">◈ OPERATOR SKILLS</div>
                <?php foreach ($u['skills'] as $skill => $val): ?>
                <div class="skill-bar-row">
                    <div class="skill-bar-header">
                        <span><?= $skill ?></span>
                        <span><?= $val ?>/100</span>
                    </div>
                    <div class="skill-bar-track">
                        <div class="skill-bar-fill" data-width="<?= $val ?>" style="width:0%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <script src="../assets/js/dashboard.js"></script>
</body>
</html>
