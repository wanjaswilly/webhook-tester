<?php
$dataFile = __DIR__ . '/data.jsonl';
$logs = [];

if (file_exists($dataFile)) {
    $lines = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $logs[] = json_decode($line, true);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Webhook Logs</title>
    <style>
        body { font-family: sans-serif; margin: 2em; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 0.5em; border: 1px solid #ccc; vertical-align: top; }
        pre { white-space: pre-wrap; word-wrap: break-word; }
    </style>
</head>
<body>
    <h1>Webhook Log Viewer</h1>
    <p>Total entries: <?= count($logs) ?></p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date & Time</th>
                <th>IP</th>
                <th>Headers</th>
                <th>Body</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (array_reverse($logs) as $i => $log): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($log['datetime']) ?></td>
                    <td><?= htmlspecialchars($log['ip']) ?></td>
                    <td><pre><?= htmlspecialchars(json_encode($log['headers'], JSON_PRETTY_PRINT)) ?></pre></td>
                    <td><pre><?= htmlspecialchars(json_encode($log['body'], JSON_PRETTY_PRINT)) ?></pre></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
