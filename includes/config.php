<?php
// ============================================================
//  Database Configuration
//  Student Management System
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Change to your MySQL username
define('DB_PASS', '');            // Change to your MySQL password
define('DB_NAME', 'student_management');

function getDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("<div style='font-family:Arial;padding:20px;color:red;'>
            <h3>Database Connection Failed</h3>
            <p>" . $conn->connect_error . "</p>
            <p>Please check your database settings in <strong>includes/config.php</strong></p>
        </div>");
    }
    $conn->set_charset("utf8");
    return $conn;
}
?>
