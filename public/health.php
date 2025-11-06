<?php
// Simple health check that bypasses Laravel bootstrap
// Returns immediately without loading framework

http_response_code(200);
header('Content-Type: text/plain');
header('Cache-Control: no-cache');

echo 'OK';
exit;