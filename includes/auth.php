<?php
session_start();
require_once __DIR__ . '/data.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}

$currentUser = getUser($_SESSION['user']);
