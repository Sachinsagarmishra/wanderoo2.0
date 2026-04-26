<?php
$pageTitle = "Modern PHP CMS Solution";
$pageDesc = "Welcome to Wanderoo - The ultimate PHP/MySQL starter for your next big project.";
include_once 'includes/header.php';
?>

<main>
    <section class="hero">
        <img src="<?php echo SITE_PATH; ?>/assets/img/hero-bg.webp" alt="Travel Destination" class="hero-bg">
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <div class="social-proof">
                <img src="<?php echo SITE_PATH; ?>/assets/img/ratedby.png" alt="Rated by Tourists" style="height: 40px; width: auto;">
            </div>

            <h1 class="hero-title">Your Dream Holiday<br> <span class="playfair italic">Perfectly Planned</span></h1>

            <p class="hero-subtitle">We plan, you relax</p>

            <a href="#" class="btn-quote">Get Instant Quote</a>
        </div>
    </section>

    <section class="who-we-are"
        style="padding: 100px 40px; max-width: 1400px; margin: 0 auto; display: flex; gap: 60px; align-items: center;">
        <div style="flex: 1;">
            <h2 style="font-size: 56px;"><span class="urbanist">Who</span> <span class="playfair italic">We Are</span>
            </h2>
        </div>
        <div style="flex: 1.5;">
            <p style="font-size: 18px; color: #4a4a4a; margin-bottom: 20px; font-weight: 500;">
                We're not just another booking site — we're your travel partner. At Wanderoo, you'll have your own
                dedicated destination expert to plan every step of your trip with care, clarity, and a genuine local
                touch.
            </p>
            <a href="#" style="font-weight: 700; border-bottom: 2px solid var(--primary); padding-bottom: 5px;">Read
                More →</a>
        </div>
    </section>
</main>

<?php include_once 'includes/footer.php'; ?>