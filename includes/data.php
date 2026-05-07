<?php

$NEXUS_USERS = [
    'cruz' => [
        'username'     => 'cruz',
        'displayName'  => 'CruzM08',
        'rank'         => 'Shadow Operative',
        'level'        => 42,
        'xp'           => 8750,
        'xp_next'      => 10000,
        'discord'      => 'Cruz#0001',
        'status'       => 'ONLINE',
        'faction'      => 'SPECTER UNIT',
        'joined'       => '2023-01-15',
        'playtime'     => 2847,
        'wins'         => 312,
        'losses'       => 89,
        'kd'           => 4.2,
        'headshots'    => 1420,
        'achievements' => 67,
        'friends'      => 28,
        'bio'          => 'Backend dev. Security researcher. Night operator.',
        'skills'       => ['Recon' => 92, 'Hacking' => 88, 'Combat' => 76, 'Stealth' => 95, 'Comms' => 80],
        'password'     => 'nexus123',
    ],
    'admin' => [
        'username'     => 'admin',
        'displayName'  => 'RootNode',
        'rank'         => 'System Root',
        'level'        => 99,
        'xp'           => 99999,
        'xp_next'      => 100000,
        'discord'      => 'Root#0000',
        'status'       => 'ONLINE',
        'faction'      => 'NEXUS CORE',
        'joined'       => '2022-01-01',
        'playtime'     => 9999,
        'wins'         => 999,
        'losses'       => 0,
        'kd'           => 99.9,
        'headshots'    => 9999,
        'achievements' => 100,
        'friends'      => 99,
        'bio'          => 'System administrator. All access granted.',
        'skills'       => ['Recon' => 99, 'Hacking' => 99, 'Combat' => 99, 'Stealth' => 99, 'Comms' => 99],
        'password'     => 'admin123',
    ],
];

$NEXUS_GAMES = [
    ['id' => 1, 'title' => 'CYBER PROTOCOL',  'genre' => 'FPS',         'hours' => 486, 'rating' => 9.4, 'status' => 'ACTIVE',    'last' => '2h ago',  'icon' => '🔫', 'color' => '#00f5ff'],
    ['id' => 2, 'title' => 'VOID RUNNERS',     'genre' => 'Battle Royale','hours' => 312, 'rating' => 8.8, 'status' => 'ACTIVE',    'last' => '1d ago',  'icon' => '🏃', 'color' => '#ff006e'],
    ['id' => 3, 'title' => 'NEON HEIST',       'genre' => 'Stealth',     'hours' => 228, 'rating' => 9.1, 'status' => 'ACTIVE',    'last' => '3d ago',  'icon' => '💎', 'color' => '#ffe600'],
    ['id' => 4, 'title' => 'SHADOW GRID',      'genre' => 'Strategy',    'hours' => 154, 'rating' => 8.2, 'status' => 'INSTALLED', 'last' => '1w ago',  'icon' => '⚡', 'color' => '#a855f7'],
    ['id' => 5, 'title' => 'GHOST WIRE',       'genre' => 'Action RPG',  'hours' => 98,  'rating' => 7.9, 'status' => 'INSTALLED', 'last' => '2w ago',  'icon' => '👻', 'color' => '#00ff88'],
    ['id' => 6, 'title' => 'MATRIX BREACH',    'genre' => 'Hacking Sim', 'hours' => 67,  'rating' => 8.6, 'status' => 'WISHLIST',  'last' => '—',       'icon' => '🌐', 'color' => '#ff8800'],
];

$NEXUS_ACTIVITY = [
    ['time' => '14:32',     'msg' => 'Completed mission DARK HORIZON',     'type' => 'mission'],
    ['time' => '13:15',     'msg' => 'Earned achievement GHOST MODE',       'type' => 'achievement'],
    ['time' => '11:48',     'msg' => 'Ranked up in CYBER PROTOCOL',         'type' => 'rank'],
    ['time' => 'Yesterday', 'msg' => 'Joined squad SPECTER UNIT',           'type' => 'social'],
    ['time' => '2d ago',    'msg' => 'New personal record: 42 kills',       'type' => 'record'],
    ['time' => '3d ago',    'msg' => 'Unlocked skin NEON PHANTOM',          'type' => 'unlock'],
];

$NEXUS_LEADERBOARD = [
    ['pos' => 1, 'name' => 'NightStalker', 'level' => 87, 'score' => 142800, 'faction' => 'CRIMSON', 'you' => false],
    ['pos' => 2, 'name' => 'ZeroDay_X',    'level' => 81, 'score' => 138500, 'faction' => 'NEXUS',   'you' => false],
    ['pos' => 3, 'name' => 'PhantomByte',  'level' => 79, 'score' => 131200, 'faction' => 'SPECTER', 'you' => false],
    ['pos' => 4, 'name' => 'CruzM08',      'level' => 42, 'score' => 98750,  'faction' => 'SPECTER', 'you' => true],
    ['pos' => 5, 'name' => 'Vex_0xFF',     'level' => 56, 'score' => 94100,  'faction' => 'CRIMSON', 'you' => false],
];

function getUser(string $u): array {
    global $NEXUS_USERS;
    return $NEXUS_USERS[$u] ?? [];
}

function xpPercent(array $u): int {
    return (int)(($u['xp'] / $u['xp_next']) * 100);
}

function winRate(array $u): string {
    $total = $u['wins'] + $u['losses'];
    return $total > 0 ? number_format(($u['wins'] / $total) * 100, 1) . '%' : '0%';
}
