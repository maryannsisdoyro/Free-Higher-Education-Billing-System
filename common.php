<?php
// - Set the X-Frame-Options header for clickjacking protection
header('X-Frame-Options: SAMEORIGIN');

// - Set the X-Content-Type-Options header to prevent MIME sniffing
header('X-Content-Type-Options: nosniff');

// - Set the Content Security Policy header with multiple directives
header("Content-Security-Policy: default-src 'self'; script-src 'self';");
exit;
?>