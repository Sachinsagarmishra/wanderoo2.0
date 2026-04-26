<?php
/**
 * Global Configuration
 */

// Site Information
define('SITE_NAME', 'Wanderoo');
define('SITE_URL', 'http://localhost/wanderoo');

// Database Credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'wanderoo_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Error Reporting (Set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
