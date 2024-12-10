<?php
// ob_start(); // Start output buffering to prevent issues with sending headers
// Ensure the site is served over HTTPS
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
}
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
#header("Content-Security-Policy: default-src 'self'; script-src 'self'; object-src 'self'; base-uri 'self'; upgrade-insecure-requests;");
header("Referrer-Policy: no-referrer");
header("Permissions-Policy: geolocation=(), microphone=(), camera=(), autoplay=(self)"); // Adjust policies as needed
//exit;

// - start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not already started
}

$pages = [
    '/login.php',
    '/forgot-password.php'
];
// - check authentication
if(!isset($_SESSION['login_id']) && !in_array($_SERVER['PHP_SELF'] , $pages))
    header("location: login.php");

// - check if user is already logged in
if (isset($_SESSION['login_id']) && in_array($_SERVER['PHP_SELF'] , $pages))
    header("location: index.php");


if (!isset($_SESSION['user_token']) && !in_array($_SERVER['PHP_SELF'] , $pages)) {
    session_destroy();
    foreach ($_SESSION as $key => $value) {
        unset($_SESSION[$key]);
    }
    header("location:login.php");
}
?>