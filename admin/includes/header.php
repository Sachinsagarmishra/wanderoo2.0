<?php
require_once __DIR__ . '/../../config.php';

// Authentication Check: Redirect to login if session is not active
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_PATH; ?>/admin/assets/css/admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="admin-mobile-header">
        <button class="sidebar-toggle" id="mobileSidebarToggle">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="mobile-logo">
            Wander<span>oo</span> Admin
        </div>
        <div style="width: 24px;"></div>
    </header>

    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="sidebar-logo">
                Wander<span>oo</span> Admin
                <button class="sidebar-close" id="mobileSidebarClose"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <nav class="admin-nav">
                <a href="dashboard.php" class="nav-item <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-chart-line" style="margin-right: 8px;"></i> Dashboard
                </a>
                <a href="about-editor.php" class="nav-item <?php echo $current_page == 'about-editor.php' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-circle-info" style="margin-right: 8px;"></i> Edit About Us
                </a>
                <a href="#" class="nav-item">
                    <i class="fa-solid fa-file-lines" style="margin-right: 8px;"></i> Pages
                </a>
                <a href="#" class="nav-item">
                    <i class="fa-solid fa-users" style="margin-right: 8px;"></i> Users
                </a>
                <a href="#" class="nav-item">
                    <i class="fa-solid fa-gear" style="margin-right: 8px;"></i> Settings
                </a>
            </nav>
            <nav class="admin-nav nav-spacer">
                <a href="<?php echo SITE_PATH; ?>/" class="nav-item" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square" style="margin-right: 8px;"></i> View Site
                </a>
                <a href="logout.php" class="nav-item" style="color: var(--danger);">
                    <i class="fa-solid fa-power-off" style="margin-right: 8px;"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="admin-main">
