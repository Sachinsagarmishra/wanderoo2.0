<?php
require_once __DIR__ . '/../../config.php';
// Add authentication check here in the future
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_PATH; ?>/assets/css/style.css">
    <style>
        /* Admin specific tweaks */
        .admin-sidebar {
            width: 260px;
            height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            position: fixed;
            left: 0;
            top: 0;
            padding: 2rem;
        }
        .admin-main {
            margin-left: 260px;
            padding: 2rem;
        }
        .admin-nav-item {
            display: block;
            padding: 0.8rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            color: var(--text-muted);
        }
        .admin-nav-item:hover, .admin-nav-item.active {
            background: var(--surface-light);
            color: var(--white);
        }
    </style>
</head>
<body>
    <div class="admin-sidebar">
        <h2 class="logo" style="margin-bottom: 2rem;"><?php echo SITE_NAME; ?> Admin</h2>
        <nav>
            <a href="dashboard.php" class="admin-nav-item active">Dashboard</a>
            <a href="#" class="admin-nav-item">Pages</a>
            <a href="#" class="admin-nav-item">Settings</a>
            <a href="<?php echo SITE_PATH; ?>/" class="admin-nav-item" style="margin-top: 2rem;">View Site</a>
            <a href="logout.php" class="admin-nav-item" style="color: var(--secondary);">Logout</a>
        </nav>
    </div>
    <div class="admin-main">
