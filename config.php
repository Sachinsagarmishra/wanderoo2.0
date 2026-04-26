<?php
/**
 * Global Configuration
 */

// Site Information
// Site Information
define('SITE_NAME', 'Wanderoo');

// Dynamic Path Detection (Works for both root and subdirectories)
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];
$script_name = $_SERVER['SCRIPT_NAME'];
$base_dir = str_replace(basename($script_name), '', $script_name);

// If we are in the admin folder, we need to go one level up for the site root
if (strpos($base_dir, '/admin/') !== false) {
    $base_dir = str_replace('admin/', '', $base_dir);
}

define('SITE_PATH', rtrim($base_dir, '/'));

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
