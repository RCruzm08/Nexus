<?php
require_once '../includes/auth.php';
$u = $currentUser;

$members = [
    ['name'=>'NightStalker','status'=>'online', 'role'=>'Commander',   'emoji'=>'🟢'],
    ['name'=>'ZeroDay_X',   'status'=>'online', 'role'=>'Elite',       'emoji'=>'🟢'],
    ['name'=>'PhantomByte', 'status'=>'idle',   'role'=>'Operative',   'emoji'=>'🟡'],
    ['name'=>'CruzM08',     'status'=>'online', 'role'=>'Operative',   'emoji'=>'🟢'],
    ['name'=>'Vex_0xFF',    'status'=>'offline','role'=>'Recruit',     'emoji'=>'⚫'],
    ['name'=>'ShadowKey',   'status'=>'idle',   'role'=>'Recruit',     'emoji'=>'🟡'],
];

$channels = [
    ['name'=>'#general',       'unread'=>3],
    ['name'=>'#ops-briefing',  'unread'=>1],
    ['name'=>'#intel-drop',    'unread'=>0],
    ['name'=>'#recruitment',   'unread'=>7],
    ['name'=>'#announcements', 'unread'=>0],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS // DISCORD</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .discord-header {
            background: linear-gradient(135deg, rgba(88,101,242,0.12), rgba(0,245,255,0.04));
            border: 1px solid rgba(88,101,242,0.3);
            border-top: 3px solid #7289da;
            padding: 32px;
            display: flex;
            align-items: center;
            gap: 28px;
            margin-bottom: 24px;
        }
        .discord-logo-big { font-size: 3.5rem; filter: drop-shadow(0 0 20px rgba(114,137,218,0.6)); }
        .discord-server-name {
            font-family: var(--font-hud);
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.1em;
        }
        .discord-meta {
            font-size: 0.65rem;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.15em;
            margin-top: 6px;
        }
        .discord-meta span { color: #7289da; }
        .channel-list { list-style: none; }
        .channel-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: 0;
            margin-bottom: 2px;
            cursor: pointer;
            transition: background 0.2s;
            font-size: 0.78rem;
            color: var(--text-dim);
            border: 1px solid transparent;
        }
        .channel-item:hover {
            background: rgba(114,137,218,0.08);
            border-color: rgba(114,137,218,0.2);
            color: var(--cyan);
        }
        .channel-badge {
            background: var(--magenta);
            color: #fff;
            font-size: 0.55rem;
            padding: 1px 7px;
            border-radius: 10px;
            font-family: var(--font-hud);
        }
        .member-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 0;
            border-bottom: 1px solid var(--border2);
            font-size: 0.75rem;
        }
        .member-row:last-child { border-bottom: none; }
        .member-status { font-size: 0.8rem; }
        .member-name { flex: 1; font-family: var(--font-ui); font-weight: 600; }
        .member-role { font-size: 0.58rem; letter-spacing: 0.2em; color: var(--text-dim); }
        .connected-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            background: rgba(0,255,136,0.08);
            border: 1px solid rgba(0,255,136,0.3);
            color: var(--green);
            font-family: var(--font-hud);
            font-size: 0.62rem;
            letter-spacing: 0.2em;
            margin-left: auto;
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
            <a href="library.php"><span class="icon">◻</span> LIBRARY</a>
            <a href="leaderboard.php"><span class="icon">▲</span> LEADERBOARD</a>
            <div class="nav-section">// SYSTEM</div>
            <a href="discord.php" class="active"><span class="icon">◈</span> DISCORD</a>
            <a href="settings.php"><span class="icon">⚙</span> SETTINGS</a>
        </nav>
        <div class="sidebar-bottom">
            <a href="../logout.php" class="logout-btn">⏻ &nbsp; DISCONNECT</a>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div class="page-title">DISCORD <span>INTEGRATION</span></div>
            <div class="topbar-right">
                <span><span class="status-dot"></span><?= $u['status'] ?></span>
                <span id="live-time"><?= date('H:i:s') ?></span>
            </div>
        </div>

        <div class="discord-header">
            <div class="discord-logo-big">🎮</div>
            <div>
                <div class="discord-server-name">SPECTER UNIT</div>
                <div class="discord-meta">CONNECTED AS <span><?= htmlspecialchars($u['discord']) ?></span></div>
                <div class="discord-meta" style="margin-top:4px;">FACTION: <span><?= htmlspecialchars($u['faction']) ?></span></div>
            </div>
            <div class="connected-badge">
                <span class="status-dot"></span> CONNECTED
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="card-title">◈ SERVER CHANNELS</div>
                <ul class="channel-list">
                    <?php foreach ($channels as $ch): ?>
                    <li class="channel-item">
                        <span><?= htmlspecialchars($ch['name']) ?></span>
                        <?php if ($ch['unread'] > 0): ?>
                        <span class="channel-badge"><?= $ch['unread'] ?></span>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card">
                <div class="card-title">◈ ONLINE MEMBERS</div>
                <?php foreach ($members as $m): ?>
                <div class="member-row">
                    <span class="member-status"><?= $m['emoji'] ?></span>
                    <span class="member-name"><?= htmlspecialchars($m['name']) ?></span>
                    <span class="member-role"><?= htmlspecialchars($m['role']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <script src="../assets/js/dashboard.js"></script>
</body>
</html>
