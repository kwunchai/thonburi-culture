<?php
// Health check at root directory for Railway
http_response_code(200);
header('Content-Type: text/plain');
header('Cache-Control: no-cache');

echo 'OK';
exit;