<?php
require_once __DIR__ . '/../config.php';
$pageTitle = isset($pageTitle) ? $pageTitle . " | " . SITE_NAME : SITE_NAME . " — Incentive Travel Platform";
$pageDesc = isset($pageDesc) ? $pageDesc : "India's #1 Incentive Travel Platform - Motivate employees, energise dealers, and retain your best people.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $pageDesc; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo SITE_PATH; ?>/assets/img/favicon.png">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH; ?>/assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- Mobile Menu Overlay -->
<div class="mobile-nav-overlay" id="mobileMenu">
  <div class="close-menu" onclick="toggleMenu()">✕</div>
  <a href="<?php echo SITE_PATH; ?>/index#destinations" onclick="toggleMenu()">Destinations</a>
  <a href="<?php echo SITE_PATH; ?>/index#solutions" onclick="toggleMenu()">Solutions</a>
  <a href="<?php echo SITE_PATH; ?>/index#case-studies" onclick="toggleMenu()">Case Studies</a>
  <a href="<?php echo SITE_PATH; ?>/index#how" onclick="toggleMenu()">How It Works</a>
  <a href="<?php echo SITE_PATH; ?>/about" onclick="toggleMenu()">About Us</a>
  <button class="nav-cta" style="margin-top: 20px;">Get Proposal →</button>
</div>

<!-- NAV -->
<nav class="main-nav">
  <div class="nav-container">
    <a href="<?php echo SITE_PATH; ?>/" class="nav-logo">
      <img src="<?php echo SITE_PATH; ?>/assets/img/wanderoo.svg" alt="Wanderoo Logo">
    </a>
    <ul class="nav-links">
      <li><a href="<?php echo SITE_PATH; ?>/index#destinations">Destinations</a></li>
      <li><a href="<?php echo SITE_PATH; ?>/index#solutions">Solutions</a></li>
      <li><a href="<?php echo SITE_PATH; ?>/index#case-studies">Case Studies</a></li>
      <li><a href="<?php echo SITE_PATH; ?>/index#how">How It Works</a></li>
      <li><a href="<?php echo SITE_PATH; ?>/about">About Us</a></li>
    </ul>
    <div class="nav-actions">
      <button class="nav-cta">Get Proposal →</button>
      <div class="mobile-menu-btn" onclick="toggleMenu()">☰</div>
    </div>
  </div>
</nav>

<script>
function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('active');
    document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : 'auto';
}
</script>
