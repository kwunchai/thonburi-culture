<?php
// Laravel Railway Health Check
// Simple health check that bypasses Laravel bootstrap
// Compatible with Railway's port configuration

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

echo 'OK';
exit;