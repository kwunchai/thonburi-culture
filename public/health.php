<?php
// Laravel Railway Health Check
// Bypass Laravel bootstrap and handle Railway hostname restrictions

// Set headers for immediate response
http_response_code(200);
header('Content-Type: text/plain; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Add Railway-specific headers for debugging
header('X-Health-Check: OK');
header('X-Service: thonburi-culture');
header('X-Timestamp: ' . date('c'));

// Log the requesting host for debugging
$host = $_SERVER['HTTP_HOST'] ?? 'unknown';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

// Railway trusted hosts
$trustedHosts = [
    'healthcheck.railway.app',
    'railway.app',
    'localhost',
    '127.0.0.1',
    '0.0.0.0'
];

// Check if host contains railway or is in trusted list
$isRailwayHost = false;
foreach ($trustedHosts as $trustedHost) {
    if (strpos($host, $trustedHost) !== false || strpos($host, 'railway.app') !== false) {
        $isRailwayHost = true;
        break;
    }
}

// Add debugging header
header('X-Request-Host: ' . $host);
header('X-Railway-Host: ' . ($isRailwayHost ? 'true' : 'false'));

echo 'OK';
exit;