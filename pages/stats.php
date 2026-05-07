<?php
require_once '../includes/auth.php';
$u  = $currentUser;
$wr = winRate($u);
$kda = $u['wins'] + ($u['losses'] * 0.5);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS // STATISTICS</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .big-stat {
            text-align: center;
            padding: 28px 16px;
        }
        .big-stat .n {
            font-family: var(--font-hud);
            font-size: 3rem;
            font-weight: 900;
            line-height: 1;
            text-shadow: 0 0 30px currentColor;
        }
        .big-stat .l {
            font-size: 0.58rem;
            letter-spacing: 0.25em;
            color: var(--text-dim);
            margin-top: 8px;
        }
        .radar-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
        }
        .chart-bar-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
        }
        .chart-bar-label {
            width: 100px;
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            color: var(--text-dim);
            text-align: right;
            flex-shrink: 0;
        }
        .chart-bar-track {
            flex: 1;
            height: 18px;
            background: rgba(0,245,255,0.05);
            border: 1px solid var(--border2);
            position: relative;
            overflow: hidden;
        }
        .chart-bar-fill {
            height: 100%;
            transition: width 1.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .chart-bar-val {
            width: 50px;
            font-family: var(--font-hud);
            font-size: 0.7rem;
            flex-shrink: 0;
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
            <a href="stats.php" class="active"><span class="icon">▦</span> STATISTICS</a>
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
            <div class="page-title">COMBAT <span>STATISTICS</span></div>
            <div class="topbar-right">
                <span><span class="status-dot"></span><?= $u['status'] ?></span>
                <span id="live-time"><?= date('H:i:s') ?></span>
            </div>
        </div>

        <div class="grid-4" style="margin-bottom:20px;">
            <div class="stat-card">
                <div class="big-stat">
                    <div class="n" style="color:var(--green);"><?= $u['wins'] ?></div>
                    <div class="l">TOTAL WINS</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="big-stat">
                    <div class="n" style="color:var(--magenta);"><?= $u['losses'] ?></div>
                    <div class="l">TOTAL LOSSES</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="big-stat">
                    <div class="n" style="color:var(--yellow);"><?= $u['kd'] ?></div>
                    <div class="l">K/D RATIO</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="big-stat">
                    <div class="n" style="color:var(--cyan);"><?= $wr ?></div>
                    <div class="l">WIN RATE</div>
                </div>
            </div>
        </div>

        <div class="grid-2" style="margin-bottom:20px;">
            <div class="card">
                <div class="card-title">▦ PERFORMANCE BREAKDOWN</div>

                <?php
                $rows = [
                    ['WINS',         $u['wins'],         400, 'var(--green)'],
                    ['LOSSES',       $u['losses'],       400, 'var(--magenta)'],
                    ['HEADSHOTS',    $u['headshots'],    2000,'var(--yellow)'],
                    ['ACHIEVEMENTS', $u['achievements'], 100, 'var(--purple)'],
                    ['FRIENDS',      $u['friends'],      100, 'var(--cyan)'],
                    ['PLAYTIME (h)', $u['playtime'],     5000,'#ff8800'],
                ];
                foreach ($rows as [$label, $val, $max, $color]):
                    $pct = min(100, (int)(($val / $max) * 100));
                ?>
                <div class="chart-bar-row">
                    <div class="chart-bar-label"><?= $label ?></div>
                    <div class="chart-bar-track">
                        <div class="chart-bar-fill" data-width="<?= $pct ?>" style="width:0%;background:<?= $color ?>;box-shadow:0 0 10px <?= $color ?>;opacity:0.85;"></div>
                    </div>
                    <div class="chart-bar-val" style="color:<?= $color ?>;"><?= number_format($val) ?></div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="card">
                <div class="card-title">▦ OPERATOR SKILLS RADAR</div>
                <div class="radar-wrap">
                    <?php
                    $skills = $u['skills'];
                    $names  = array_keys($skills);
                    $vals   = array_values($skills);
                    $n      = count($names);
                    $cx     = 160; $cy = 160; $r = 120;
                    $levels = [20,40,60,80,100];
                    $colors = ['var(--cyan)','var(--magenta)','var(--yellow)','var(--purple)','var(--green)'];

                    $angles = [];
                    for ($i = 0; $i < $n; $i++) {
                        $angles[] = deg2rad(-90 + ($i * 360 / $n));
                    }

                    $polyPoints = [];
                    for ($i = 0; $i < $n; $i++) {
                        $frac = $vals[$i] / 100;
                        $polyPoints[] = ($cx + $r * $frac * cos($angles[$i])) . ',' . ($cy + $r * $frac * sin($angles[$i]));
                    }
                    ?>
                    <svg width="320" height="320" viewBox="0 0 320 320">
                        <?php foreach ($levels as $lvl): ?>
                        <polygon points="<?php
                            $pts = [];
                            foreach ($angles as $a) {
                                $fr = $lvl / 100;
                                $pts[] = ($cx + $r * $fr * cos($a)) . ',' . ($cy + $r * $fr * sin($a));
                            }
                            echo implode(' ', $pts);
                        ?>" fill="none" stroke="rgba(0,245,255,0.12)" stroke-width="1"/>
                        <?php endforeach; ?>

                        <?php for ($i = 0; $i < $n; $i++): ?>
                        <line x1="<?= $cx ?>" y1="<?= $cy ?>" x2="<?= $cx + $r * cos($angles[$i]) ?>" y2="<?= $cy + $r * sin($angles[$i]) ?>" stroke="rgba(0,245,255,0.15)" stroke-width="1"/>
                        <?php endfor; ?>

                        <polygon points="<?= implode(' ', $polyPoints) ?>" fill="rgba(0,245,255,0.15)" stroke="var(--cyan)" stroke-width="2"/>

                        <?php for ($i = 0; $i < $n; $i++):
                            $lx = $cx + ($r + 22) * cos($angles[$i]);
                            $ly = $cy + ($r + 22) * sin($angles[$i]);
                        ?>
                        <text x="<?= $lx ?>" y="<?= $ly ?>" text-anchor="middle" dominant-baseline="middle"
                              fill="rgba(0,245,255,0.7)" font-family="'Orbitron',monospace" font-size="9" letter-spacing="1">
                            <?= strtoupper($names[$i]) ?>
                        </text>
                        <?php endfor; ?>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid-3">
            <div class="stat-card">
                <div class="big-stat">
                    <div class="n" style="color:var(--purple);"><?= number_format($u['headshots']) ?></div>
                    <div class="l">HEADSHOTS</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="big-stat">
                    <div class="n" style="color:#ff8800;"><?= number_format($u['playtime']) ?>h</div>
                    <div class="l">TOTAL PLAYTIME</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="big-stat">
                    <div class="n" style="color:var(--green);"><?= $u['achievements'] ?></div>
                    <div class="l">ACHIEVEMENTS</div>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/js/dashboard.js"></script>
</body>
</html>
