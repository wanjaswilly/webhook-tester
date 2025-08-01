<?php
// Use same token you typed in the Facebook webhook dashboard
$VERIFY_TOKEN = "Fm0d3@!";

// Step 1: Verification
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hub_mode'])) {
    if (
        $_GET['hub_mode'] === 'subscribe' &&
        $_GET['hub_verify_token'] === $VERIFY_TOKEN
    ) {
        // Respond with the challenge token from the request
        echo $_GET['hub_challenge'];
        exit;
    } else {
        // Token mismatch
        http_response_code(403);
        echo "Forbidden: Invalid verify token.";
        exit;
    }
}

// Step 2: Handle incoming POST webhook data (normal webhook usage)
$dataFile = __DIR__ . '/data.jsonl';

$body = file_get_contents('php://input');
$headers = getallheaders();

$entry = [
    'datetime' => date('Y-m-d H:i:s'),
    'headers' => $headers,
    'body' => json_decode($body, true) ?? $body,
    'ip' => $_SERVER['REMOTE_ADDR']
];

file_put_contents($dataFile, json_encode($entry) . PHP_EOL, FILE_APPEND);
http_response_code(200);
echo json_encode(['status' => 'received']);
