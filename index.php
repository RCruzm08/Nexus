<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: pages/dashboard.php');
    exit;
}

require_once 'includes/data.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = strtolower(trim($_POST['username'] ?? ''));
    $p = $_POST['password'] ?? '';

    if (isset($NEXUS_USERS[$u]) && $NEXUS_USERS[$u]['password'] === $p) {
        $_SESSION['user'] = $u;
        header('Location: pages/dashboard.php');
        exit;
    }

    $error = 'ACCESS DENIED — Invalid credentials';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS // AUTH</title>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="grid-bg"></div>
    <div class="scanline"></div>
    <div class="corner tl"></div>
    <div class="corner tr"></div>
    <div class="corner bl"></div>
    <div class="corner br"></div>

    <div class="login-wrap">
        <div class="logo">NEXUS</div>
        <div class="logo-sub">NEURAL EXPERIENCE HUB &mdash;</div>

        <div class="panel">
            <div class="panel-title">// <span>AUTHENTICATION</span> REQUIRED //</div>

            <form method="POST" autocomplete="off">
                <div class="field">
                    <label>// OPERATOR ID</label>
                    <input type="text" name="username" placeholder="ENTER CALLSIGN" required>
                </div>
                <div class="field">
                    <label>// ACCESS KEY</label>
                    <input type="password" name="password" placeholder="••••••••••••" required>
                </div>
                <button type="submit" class="btn-login">[ AUTHENTICATE ]</button>
            </form>

            <?php if ($error): ?>
                <div class="error-msg">⚠ <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="demo-hint">
                DEMO &rarr; user: <span>cruz</span> &nbsp;/&nbsp; pass: <span>nexus123</span>
            </div>
        </div>
    </div>

    <div class="status-bar">
        <span><span class="status-dot"></span>NEXUS NETWORK ONLINE</span>
        <span>ENC: AES-256 &nbsp;|&nbsp; TLS 1.3</span>
        <span id="live-time"><?= date('H:i:s') ?></span>
    </div>

    <script src="assets/js/login.js"></script>
</body>
</html>
