<?php
// Ultra-simple health check - bypass all Laravel dependencies

// Set response headers immediately
http_response_code(200);
header('Content-Type: text/plain');
header('Cache-Control: no-cache');

// Log the request for debugging
$logEntry = date('Y-m-d H:i:s') . " - Health check accessed from " . ($_SERVER['HTTP_HOST'] ?? 'unknown') . "\n";
error_log($logEntry);

// Simple OK response
echo 'OK';
exit;