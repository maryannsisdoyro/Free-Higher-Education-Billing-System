<?php
// - Set the X-Frame-Options header for clickjacking protection
header('X-Frame-Options: SAMEORIGIN');

// - Set the Content Security Policy header with multiple directives
header("Content-Security-Policy: default-src 'self'; script-src 'self'; object-src 'self'; base-uri 'self';");
exit;
?>