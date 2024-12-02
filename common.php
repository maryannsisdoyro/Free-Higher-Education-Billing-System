<?php
// ob_start(); // Start output buffering to prevent issues with sending headers
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header("Content-Security-Policy: default-src 'self'; script-src 'self'; object-src 'self'; base-uri 'self'; upgrade-insecure-requests;");
// exit;
?>