<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
    session_start();
}
if (empty($_SESSION['csrf_token']))
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
require_once __DIR__ . '/../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHRI HIT RADHAVALLAV POOJA STORE</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php if (file_exists(__DIR__ . '/navbar.php'))
        include __DIR__ . '/navbar.php'; ?>
    <main id="main-content"></main>