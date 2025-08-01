<?php
// Store incoming webhook data to a file
$dataFile = __DIR__ . '/data.jsonl';

$body = file_get_contents('php://input');
$headers = getallheaders();

$entry = [
    'datetime' => date('Y-m-d H:i:s'),
    'headers' => $headers,
    'body' => json_decode($body, true) ?? $body,
    'ip' => $_SERVER['REMOTE_ADDR']
];

// Append to file
file_put_contents($dataFile, json_encode($entry) . PHP_EOL, FILE_APPEND);

// Optional: respond to sender
http_response_code(200);
echo json_encode(['status' => 'received']);
