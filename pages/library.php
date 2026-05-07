<?php
require_once '../includes/auth.php';
global $NEXUS_GAMES;
$u = $currentUser;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS // LIBRARY</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .filter-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        .filter-btn {
            padding: 7px 18px;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-dim);
            font-family: var(--font-hud);
            font-size: 0.6rem;
            letter-spacing: 0.2em;
            cursor: pointer;
            transition: all 0.2s;
        }
        .filter-btn:hover,
        .filter-btn.active {
            border-color: var(--cyan);
            color: var(--cyan);
            background: rgba(0,245,255,0.05);
        }
        .game-card-lg {
            background: var(--panel);
            border: 1px solid var(--border2);
            padding: 24px;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }
        .game-card-lg:hover {
            border-color: var(--border);
            background: var(--panel2);
            transform: translateY(-3px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        }
        .game-card-lg .accent-line {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }
        .game-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 14px;
        }
        .game-icon-lg { font-size: 2.4rem; }
        .game-info .title {
            font-family: var(--font-hud);
            font-size: 0.85rem;
            letter-spacing: 0.12em;
        }
        .game-info .genre {
            font-size: 0.6rem;
            color: var(--text-dim);
            letter-spacing: 0.15em;
            margin-top: 3px;
        }
        .game-rating-lg {
            margin-left: auto;
            font-family: var(--font-hud);
            font-size: 1.2rem;
            color: var(--yellow);
        }
        .game-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 14px;
            border-top: 1px solid var(--border2);
            font-size: 0.65rem;
            color: var(--text-dim);
        }
        .game-meta span { letter-spacing: 0.1em; }
        .total-hours {
            font-family: var(--font-hud);
            font-size: 2rem;
            font-weight: 900;
            color: var(--cyan);
            text-shadow: 0 0 20px rgba(0,245,255,0.5);
        }
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
            <a href="profile.php"><span class="icon">◈</span> PROFILE</a>
            <a href="stats.php"><span class="icon">▦</span> STATISTICS</a>
            <div class="nav-section">// CONTENT</div>
            <a href="library.php" class="active"><span class="icon">◻</span> LIBRARY</a>
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
            <div class="page-title">GAME <span>LIBRARY</span></div>
            <div class="topbar-right">
                <span><span class="status-dot"></span><?= $u['status'] ?></span>
                <span id="live-time"><?= date('H:i:s') ?></span>
            </div>
        </div>

        <div class="grid-3" style="margin-bottom:24px;">
            <div class="stat-card">
                <div class="total-hours"><?= array_sum(array_column($NEXUS_GAMES,'hours')) ?>h</div>
                <div class="lbl" style="font-size:0.6rem;letter-spacing:0.2em;color:var(--text-dim);margin-top:6px;">TOTAL PLAYTIME</div>
            </div>
            <div class="stat-card">
                <div class="total-hours" style="color:var(--green);"><?= count(array_filter($NEXUS_GAMES, fn($g)=>$g['status']==='ACTIVE')) ?></div>
                <div class="lbl" style="font-size:0.6rem;letter-spacing:0.2em;color:var(--text-dim);margin-top:6px;">ACTIVE GAMES</div>
            </div>
            <div class="stat-card">
                <div class="total-hours" style="color:var(--yellow);"><?= count($NEXUS_GAMES) ?></div>
                <div class="lbl" style="font-size:0.6rem;letter-spacing:0.2em;color:var(--text-dim);margin-top:6px;">TOTAL TITLES</div>
            </div>
        </div>

        <div class="filter-bar">
            <button class="filter-btn active" onclick="filterGames('ALL',this)">ALL</button>
            <button class="filter-btn" onclick="filterGames('ACTIVE',this)">ACTIVE</button>
            <button class="filter-btn" onclick="filterGames('INSTALLED',this)">INSTALLED</button>
            <button class="filter-btn" onclick="filterGames('WISHLIST',this)">WISHLIST</button>
        </div>

        <div class="grid-2" id="game-grid">
            <?php foreach ($NEXUS_GAMES as $g): ?>
            <div class="game-card-lg" data-status="<?= $g['status'] ?>">
                <div class="accent-line" style="background:<?= $g['color'] ?>;box-shadow:0 0 12px <?= $g['color'] ?>;"></div>
                <div class="game-header">
                    <div class="game-icon-lg"><?= $g['icon'] ?></div>
                    <div class="game-info">
                        <div class="title"><?= htmlspecialchars($g['title']) ?></div>
                        <div class="genre"><?= htmlspecialchars($g['genre']) ?></div>
                    </div>
                    <div class="game-rating-lg">★ <?= $g['rating'] ?></div>
                </div>
                <span class="tag <?= strtolower($g['status']) ?>"><?= $g['status'] ?></span>
                <div class="game-meta">
                    <span><?= $g['hours'] ?>h played</span>
                    <span>Last: <?= $g['last'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/library.js"></script>
</body>
</html>
