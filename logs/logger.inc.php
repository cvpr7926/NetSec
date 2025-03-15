<?php
function logUserActivity($username = "'Guest'", $action = "Visited Page") {
    $timestamp = date("Y-m-d H:i:s");
    $webpage = $_SERVER['REQUEST_URI'];
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    $logMessage = "[$timestamp] | Webpage: $webpage | Action: $action | Username: $username | IP: $ipAddress\n";
    $logFilePath = __DIR__ . "/user_activity.log"; // Absolute path within logs/
    
    if (file_put_contents($logFilePath, $logMessage, FILE_APPEND) === false) {
        error_log("Failed to write log to: $logFilePath"); // Logs to PHP error log
    }
}
?>