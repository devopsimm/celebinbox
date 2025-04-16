<?php

// Get the current timestamp
$timestamp = date("Y-m-d H:i:s");

// Get the raw POST data
$raw_data = file_get_contents('php://input');

// Log the raw POST data to a log file (along with timestamp)
$log_file = 'webhook_received_log.txt'; // Path to the log file
$log_entry = [
    'timestamp' => $timestamp,
    'data' => $raw_data
];

// Convert the log entry to JSON format for easy readability
$log_content = json_encode($log_entry, JSON_PRETTY_PRINT) . PHP_EOL;

// Append the log content to the log file
file_put_contents($log_file, $log_content, FILE_APPEND);

// You can also echo the raw data if you need to verify it quickly
echo "Data received: " . htmlspecialchars($raw_data) . "<br>";
echo "Log entry written to 'webhook_received_log.txt'.<br>";

?>
