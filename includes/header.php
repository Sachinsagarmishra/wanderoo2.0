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
    <link rel="stylesheet" href="<?php echo SITE_PATH; ?>/assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- Mobile Menu Overlay -->
<div class="mobile-nav-overlay" id="mobileMenu">
  <div class="close-menu" onclick="toggleMenu()">✕</div>
  <a href="#destinations" onclick="toggleMenu()">Destinations</a>
  <a href="#solutions" onclick="toggleMenu()">Solutions</a>
  <a href="#case-studies" onclick="toggleMenu()">Case Studies</a>
  <a href="#how" onclick="toggleMenu()">How It Works</a>
  <a href="#pricing" onclick="toggleMenu()">Pricing</a>
  <button class="nav-cta" style="margin-top: 20px;">Get Proposal →</button>
</div>

<!-- NAV -->
<nav class="main-nav">
  <div class="nav-container">
    <div class="nav-logo">Wander<span>oo</span></div>
    <ul class="nav-links">
      <li><a href="#destinations">Destinations</a></li>
      <li><a href="#solutions">Solutions</a></li>
      <li><a href="#case-studies">Case Studies</a></li>
      <li><a href="#how">How It Works</a></li>
      <li><a href="#pricing">Pricing</a></li>
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
