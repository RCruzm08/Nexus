<?php
require_once '../includes/auth.php';
$u = $currentUser;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS // SETTINGS</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .settings-section { margin-bottom: 28px; }
        .setting-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid var(--border2);
            gap: 20px;
        }
        .setting-row:last-child { border-bottom: none; }
        .setting-label {
            font-size: 0.8rem;
            font-family: var(--font-ui);
            font-weight: 600;
        }
        .setting-desc {
            font-size: 0.62rem;
            color: var(--text-dim);
            letter-spacing: 0.08em;
            margin-top: 2px;
        }
        .toggle {
            position: relative;
            width: 48px; height: 24px;
            flex-shrink: 0;
        }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute;
            inset: 0;
            background: rgba(0,245,255,0.08);
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.3s;
        }
        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 18px; height: 18px;
            left: 2px; top: 2px;
            background: var(--text-dim);
            transition: all 0.3s;
        }
        .toggle input:checked + .toggle-slider { background: rgba(0,245,255,0.15); border-color: var(--cyan); }
        .toggle input:checked + .toggle-slider::before { transform: translateX(24px); background: var(--cyan); box-shadow: var(--glow); }
        .select-input {
            background: rgba(0,245,255,0.04);
            border: 1px solid var(--border);
            color: var(--cyan);
            font-family: var(--font-mono);
            font-size: 0.75rem;
            padding: 7px 12px;
            outline: none;
            cursor: pointer;
        }
        .select-input option { background: var(--dark2); }
        .save-btn {
            padding: 12px 32px;
            background: transparent;
            border: 1px solid var(--cyan);
            color: var(--cyan);
            font-family: var(--font-hud);
            font-size: 0.7rem;
            letter-spacing: 0.25em;
            cursor: pointer;
            transition: all 0.25s;
            clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);
        }
        .save-btn:hover { background: rgba(0,245,255,0.08); box-shadow: var(--glow); }
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
            <a href="discord.php"><span class="icon">◈</span> DISCORD</a>
            <a href="settings.php" class="active"><span class="icon">⚙</span> SETTINGS</a>
        </nav>
        <div class="sidebar-bottom">
            <a href="../logout.php" class="logout-btn">⏻ &nbsp; DISCONNECT</a>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div class="page-title">SYSTEM <span>SETTINGS</span></div>
            <div class="topbar-right">
                <span><span class="status-dot"></span><?= $u['status'] ?></span>
                <span id="live-time"><?= date('H:i:s') ?></span>
            </div>
        </div>

        <div class="grid-2">
            <div>
                <div class="card settings-section">
                    <div class="card-title">⚙ DISPLAY</div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Scanlines</div>
                            <div class="setting-desc">CRT scanline overlay effect</div>
                        </div>
                        <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                    </div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Grid Background</div>
                            <div class="setting-desc">Animated grid background</div>
                        </div>
                        <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                    </div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Particles</div>
                            <div class="setting-desc">Floating particle effects</div>
                        </div>
                        <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                    </div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Accent Color</div>
                            <div class="setting-desc">Primary interface color</div>
                        </div>
                        <select class="select-input">
                            <option>CYAN // #00f5ff</option>
                            <option>MAGENTA // #ff006e</option>
                            <option>GREEN // #00ff88</option>
                            <option>PURPLE // #a855f7</option>
                        </select>
                    </div>
                </div>

                <div class="card settings-section">
                    <div class="card-title">⚙ AUDIO</div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Ambient Music</div>
                            <div class="setting-desc">Background ambient sound</div>
                        </div>
                        <label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label>
                    </div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">UI Sound FX</div>
                            <div class="setting-desc">Interface click sounds</div>
                        </div>
                        <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                    </div>
                </div>
            </div>

            <div>
                <div class="card settings-section">
                    <div class="card-title">⚙ NOTIFICATIONS</div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Level Up Alerts</div>
                            <div class="setting-desc">Notify on level progression</div>
                        </div>
                        <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                    </div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Achievement Popups</div>
                            <div class="setting-desc">Achievement unlock notifications</div>
                        </div>
                        <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                    </div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Discord Sync</div>
                            <div class="setting-desc">Sync status with Discord</div>
                        </div>
                        <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                    </div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Friend Requests</div>
                            <div class="setting-desc">Allow incoming requests</div>
                        </div>
                        <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                    </div>
                </div>

                <div class="card settings-section">
                    <div class="card-title">⚙ ACCOUNT</div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Operator ID</div>
                            <div class="setting-desc"><?= htmlspecialchars($u['username']) ?></div>
                        </div>
                    </div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Discord</div>
                            <div class="setting-desc"><?= htmlspecialchars($u['discord']) ?></div>
                        </div>
                    </div>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Faction</div>
                            <div class="setting-desc"><?= htmlspecialchars($u['faction']) ?></div>
                        </div>
                    </div>
                </div>

                <div style="text-align:right;">
                    <button class="save-btn" onclick="this.textContent='[ SAVED ✓ ]';setTimeout(()=>this.textContent='[ SAVE CHANGES ]',2000)">[ SAVE CHANGES ]</button>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/js/dashboard.js"></script>
</body>
</html>
