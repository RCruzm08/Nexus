<?php
require_once '../includes/auth.php';
global $NEXUS_LEADERBOARD;
$u = $currentUser;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS // LEADERBOARD</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .lb-table {
            width: 100%;
            border-collapse: collapse;
        }
        .lb-table th {
            text-align: left;
            padding: 10px 16px;
            font-family: var(--font-hud);
            font-size: 0.58rem;
            letter-spacing: 0.25em;
            color: var(--text-dim);
            border-bottom: 1px solid var(--border);
        }
        .lb-table td {
            padding: 14px 16px;
            font-size: 0.78rem;
            border-bottom: 1px solid var(--border2);
            transition: background 0.2s;
        }
        .lb-table tr:hover td { background: rgba(0,245,255,0.03); }
        .lb-table tr.you td  { background: rgba(0,245,255,0.06); }
        .podium {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 32px;
            padding: 20px;
        }
        .podium-slot {
            text-align: center;
            background: var(--panel);
            border: 1px solid var(--border);
            padding: 20px 28px;
            position: relative;
        }
        .podium-slot .medal { font-size: 2rem; }
        .podium-slot .pname {
            font-family: var(--font-hud);
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            margin: 8px 0 4px;
        }
        .podium-slot .pscore {
            font-size: 0.65rem;
            color: var(--text-dim);
        }
        .podium-slot.first  { border-top: 3px solid #ffd700; order: 2; }
        .podium-slot.second { border-top: 3px solid #c0c0c0; order: 1; }
        .podium-slot.third  { border-top: 3px solid #cd7f32; order: 3; }
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
            <a href="leaderboard.php" class="active"><span class="icon">▲</span> LEADERBOARD</a>
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
            <div class="page-title">GLOBAL <span>LEADERBOARD</span></div>
            <div class="topbar-right">
                <span><span class="status-dot"></span><?= $u['status'] ?></span>
                <span id="live-time"><?= date('H:i:s') ?></span>
            </div>
        </div>

        <div class="podium">
            <?php foreach (array_slice($NEXUS_LEADERBOARD, 0, 3) as $row):
                $cls = ['first','second','third'][$row['pos']-1];
                $medals = ['🥇','🥈','🥉'];
                $medal = $medals[$row['pos']-1];
            ?>
            <div class="podium-slot <?= $cls ?>">
                <div class="medal"><?= $medal ?></div>
                <div class="pname"><?= htmlspecialchars($row['name']) ?></div>
                <div class="pscore"><?= number_format($row['score']) ?> pts</div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="card">
            <div class="card-title">▲ GLOBAL RANKING</div>
            <table class="lb-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>OPERATOR</th>
                        <th>LEVEL</th>
                        <th>FACTION</th>
                        <th>SCORE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($NEXUS_LEADERBOARD as $row): ?>
                    <tr class="<?= $row['you'] ? 'you' : '' ?>">
                        <td>
                            <span class="lb-pos <?= $row['pos']===1?'gold':($row['pos']===2?'silver':($row['pos']===3?'bronze':'')) ?>">
                                #<?= $row['pos'] ?>
                            </span>
                        </td>
                        <td class="lb-name">
                            <?= htmlspecialchars($row['name']) ?>
                            <?php if ($row['you']): ?>
                                <small style="color:var(--cyan);font-size:0.55rem;margin-left:8px;">[YOU]</small>
                            <?php endif; ?>
                        </td>
                        <td style="color:var(--text-dim);font-size:0.7rem;">LVL <?= $row['level'] ?></td>
                        <td><span class="lb-faction"><?= htmlspecialchars($row['faction']) ?></span></td>
                        <td class="lb-score"><?= number_format($row['score']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="../assets/js/dashboard.js"></script>
</body>
</html>
