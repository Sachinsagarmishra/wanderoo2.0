<?php
$pageTitle = "Explore Destinations";
include_once 'includes/header.php';
?>

<main>
    <!-- DESTINATIONS HERO -->
    <section class="dest-hero reveal-section">
        <div class="dest-hero-container">
            <div class="dest-hero-left">
                <div class="section-label">DESTINATIONS</div>
                <h1>Extraordinary places.<br><span class="accent">Meaningful impact.</span></h1>
                <p>From vibrant cities to serene escapes, we bring you the world's most inspiring destinations — curated for performance, connection, and unforgettable experiences.</p>
                <div class="dest-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search destinations, cities or countries">
                </div>
            </div>
            <div class="dest-hero-right">
                <div class="hero-image-wrapper">
                    <img src="assets/img/dest-hero-main.png" alt="Tropical Resort">
                    <div class="hero-image-badge">
                        <div class="badge-icon-bg"><i class="fa-solid fa-award"></i></div>
                        <span>Curated with expertise. Delivered with precision.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- EXPLORE BY REGION -->
    <section class="region-section reveal-section">
        <div class="section-container">
            <h2 class="section-title">Explore by Region</h2>
            <div class="region-grid">
                <!-- SE Asia -->
                <div class="region-card">
                    <div class="region-img">
                        <img src="assets/img/regions/se-asia.png" alt="South East Asia">
                        <div class="region-icon-float"><i class="fa-solid fa-palmtree"></i></div>
                    </div>
                    <div class="region-info">
                        <div class="region-header">
                            <h3>South East Asia</h3>
                            <a href="#" class="region-arrow">→</a>
                        </div>
                        <p>Tropical beaches, vibrant cultures, and world-class hospitality — perfect for high-impact incentive trips.</p>
                        <div class="popular-tags">
                            <span>Popular:</span>
                            <a href="#">Thailand</a>
                            <a href="#">Bali</a>
                            <a href="#">Vietnam</a>
                            <a href="#">Singapore</a>
                        </div>
                    </div>
                </div>

                <!-- Europe -->
                <div class="region-card">
                    <div class="region-img">
                        <img src="assets/img/regions/europe.png" alt="Europe">
                        <div class="region-icon-float"><i class="fa-solid fa-landmark"></i></div>
                    </div>
                    <div class="region-info">
                        <div class="region-header">
                            <h3>Europe</h3>
                            <a href="#" class="region-arrow">→</a>
                        </div>
                        <p>Timeless cities, rich history, and unforgettable experiences that inspire and reward.</p>
                        <div class="popular-tags">
                            <span>Popular:</span>
                            <a href="#">Switzerland</a>
                            <a href="#">Italy</a>
                            <a href="#">France</a>
                            <a href="#">Spain</a>
                        </div>
                    </div>
                </div>

                <!-- Domestic -->
                <div class="region-card">
                    <div class="region-img">
                        <img src="assets/img/regions/domestic.png" alt="Domestic">
                        <div class="region-icon-float"><i class="fa-solid fa-mountain-sun"></i></div>
                    </div>
                    <div class="region-info">
                        <div class="region-header">
                            <h3>Domestic</h3>
                            <a href="#" class="region-arrow">→</a>
                        </div>
                        <p>Incredible diversity, seamless connectivity, and experiences closer to home.</p>
                        <div class="popular-tags">
                            <span>Popular:</span>
                            <a href="#">Goa</a>
                            <a href="#">Kerala</a>
                            <a href="#">Rajasthan</a>
                            <a href="#">Himachal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HANDPICKED DESTINATIONS -->
    <section class="handpicked-section reveal-section">
        <div class="section-container">
            <div class="handpicked-header">
                <div class="h-text">
                    <h2>Handpicked Destinations for<br>High-Performing Teams</h2>
                    <p>Every destination we recommend is chosen for its ability to create impact, build connections, and drive results.</p>
                </div>
                <a href="#" class="btn-outline">View all destinations →</a>
            </div>

            <div class="dest-card-grid">
                <!-- Bali -->
                <div class="dest-card">
                    <div class="d-img">
                        <img src="assets/img/dest/bali.png" alt="Bali, Indonesia">
                    </div>
                    <div class="d-content">
                        <div class="d-meta">
                            <h4>Bali, Indonesia</h4>
                            <span class="duration">4N / 5D</span>
                        </div>
                        <p>Perfect blend of relaxation and cultural immersion.</p>
                        <div class="d-tags">
                            <span><i class="fa-solid fa-umbrella-beach"></i> Beach</span>
                            <span><i class="fa-solid fa-masks-theater"></i> Culture</span>
                            <span><i class="fa-solid fa-spa"></i> Wellness</span>
                        </div>
                        <a href="#" class="btn-explore">Explore</a>
                    </div>
                </div>

                <!-- Phuket -->
                <div class="dest-card">
                    <div class="d-img">
                        <img src="assets/img/dest/phuket.png" alt="Phuket, Thailand">
                    </div>
                    <div class="d-content">
                        <div class="d-meta">
                            <h4>Phuket, Thailand</h4>
                            <span class="duration">4N / 5D</span>
                        </div>
                        <p>Tropical paradise with luxury resorts and exciting activities.</p>
                        <div class="d-tags">
                            <span><i class="fa-solid fa-umbrella-beach"></i> Beach</span>
                            <span><i class="fa-solid fa-person-hiking"></i> Adventure</span>
                            <span><i class="fa-solid fa-martini-glass-citrus"></i> Nightlife</span>
                        </div>
                        <a href="#" class="btn-explore">Explore</a>
                    </div>
                </div>

                <!-- Swiss Alps -->
                <div class="dest-card">
                    <div class="d-img">
                        <img src="assets/img/dest/swiss.png" alt="Swiss Alps">
                    </div>
                    <div class="d-content">
                        <div class="d-meta">
                            <h4>Swiss Alps, Switzerland</h4>
                            <span class="duration">5N / 6D</span>
                        </div>
                        <p>Breathtaking landscapes and world-class experiences.</p>
                        <div class="d-tags">
                            <span><i class="fa-solid fa-mountain"></i> Mountains</span>
                            <span><i class="fa-solid fa-person-skiing"></i> Adventure</span>
                            <span><i class="fa-solid fa-gem"></i> Luxury</span>
                        </div>
                        <a href="#" class="btn-explore">Explore</a>
                    </div>
                </div>

                <!-- Barcelona -->
                <div class="dest-card">
                    <div class="d-img">
                        <img src="assets/img/dest/barcelona.png" alt="Barcelona">
                    </div>
                    <div class="d-content">
                        <div class="d-meta">
                            <h4>Barcelona, Spain</h4>
                            <span class="duration">4N / 5D</span>
                        </div>
                        <p>Vibrant city, iconic architecture and Mediterranean charm.</p>
                        <div class="d-tags">
                            <span><i class="fa-solid fa-landmark"></i> Culture</span>
                            <span><i class="fa-solid fa-utensils"></i> Food</span>
                            <span><i class="fa-solid fa-archway"></i> Architecture</span>
                        </div>
                        <a href="#" class="btn-explore">Explore</a>
                    </div>
                </div>

                <!-- Goa -->
                <div class="dest-card">
                    <div class="d-img">
                        <img src="assets/img/dest/goa.png" alt="Goa">
                    </div>
                    <div class="d-content">
                        <div class="d-meta">
                            <h4>Goa, India</h4>
                            <span class="duration">3N / 4D</span>
                        </div>
                        <p>Sun, sand and soulful experiences for teams.</p>
                        <div class="d-tags">
                            <span><i class="fa-solid fa-umbrella-beach"></i> Beach</span>
                            <span><i class="fa-solid fa-cocktail"></i> Leisure</span>
                            <span><i class="fa-solid fa-face-smile"></i> Fun</span>
                        </div>
                        <a href="#" class="btn-explore">Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY OUR DESTINATIONS -->
    <section class="why-dest-section reveal-section">
        <div class="section-container">
            <h2 class="section-title centered">Why Our Destinations Deliver More</h2>
            <div class="why-dest-grid">
                <div class="why-dest-item">
                    <div class="w-icon theme-orange"><i class="fa-solid fa-chess-knight"></i></div>
                    <h4>Strategic Selection</h4>
                    <p>We choose destinations that inspire, engage and motivate.</p>
                </div>
                <div class="why-dest-item">
                    <div class="w-icon theme-green"><i class="fa-solid fa-route"></i></div>
                    <h4>Seamless Logistics</h4>
                    <p>End-to-end planning and on-ground execution.</p>
                </div>
                <div class="why-dest-item">
                    <div class="w-icon theme-purple"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                    <h4>Exclusive Experiences</h4>
                    <p>Unique activities and access beyond the usual.</p>
                </div>
                <div class="why-dest-item">
                    <div class="w-icon theme-amber"><i class="fa-solid fa-chart-line"></i></div>
                    <h4>Measurable Impact</h4>
                    <p>Trips designed to drive performance and strengthen relationships.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PARTNER LOGOS -->
    <section class="partner-logos-section reveal-section">
        <div class="section-container">
            <div class="partner-tabs">
                <button class="tab-btn active">Hotels & Resorts</button>
                <button class="tab-btn">Cruises</button>
                <button class="tab-btn">Experiences & Adventure</button>
                <button class="tab-btn">Transportation</button>
            </div>
            <div class="logo-grid-wrapper">
                <div class="logo-grid">
                    <img src="assets/img/logos/dunzo.svg" alt="Dunzo">
                    <img src="assets/img/logos/tata1mg.svg" alt="TATA 1mg">
                    <img src="assets/img/logos/videocon.svg" alt="Videocon">
                    <img src="assets/img/logos/isb.svg" alt="ISB">
                    <img src="assets/img/logos/dunzo.svg" alt="Dunzo">
                    <img src="assets/img/logos/tata1mg.svg" alt="TATA 1mg">
                    <img src="assets/img/logos/videocon.svg" alt="Videocon">
                    <img src="assets/img/logos/isb.svg" alt="ISB">
                    <div class="more-badge">+10 More</div>
                </div>
            </div>
            <div class="partner-footer">
                <span class="p-line"></span>
                <p>20+ global partners committed to delivering excellence</p>
                <span class="p-line"></span>
            </div>
        </div>
    </section>

    <!-- FINAL CTA -->
    <section class="dest-cta-section reveal-section">
        <div class="section-container">
            <div class="dest-cta-card">
                <div class="cta-text">
                    <h3>Not sure where to go?<br>We'll help you find the perfect fit.</h3>
                    <p>Share your goals and we'll recommend destinations that align with your team, budget and objectives.</p>
                </div>
                <button class="btn-primary">Talk to an Expert →</button>
            </div>
        </div>
    </section>
</main>

<?php include_once 'includes/footer.php'; ?>
