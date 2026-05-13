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

    <!-- EXPLORE BY REGION (Bento Grid) -->
    <section class="category-section reveal-section" id="destinations">
        <h2 class="section-title centered" style="margin-bottom: 50px;">Explore by Region</h2>
        <div class="category-grid">
            <!-- 01 SOUTH EAST ASIA (Large Card) -->
            <div class="cat-card cat-large" style="background-image: url('assets/img/cat-sea.png');">
                <div class="cat-overlay"></div>
                <div class="cat-header-top">
                    <div class="cat-index">01</div>
                    <div class="cat-circle-btn">→</div>
                </div>
                <div class="cat-body">
                    <div class="cat-label">FOR</div>
                    <h2 class="cat-title">South East<br>Asia</h2>
                    <p class="cat-desc">The ultimate blend of tropical retreats, vibrant street food, and high-energy
                        cities for team bonding.</p>
                </div>
                <div class="cat-footer">
                    <div class="cat-meta">5 TO 7 DAYS · 20 TO 100 PAX · FLIGHTS & VISAS HANDLED</div>
                    <a href="#" class="cat-open">OPEN →</a>
                </div>
            </div>

            <div class="cat-right-stack">
                <!-- 02 EUROPE (Small Card) -->
                <div class="cat-card cat-small" style="background-image: url('assets/img/cat-europe.png');">
                    <div class="cat-overlay"></div>
                    <div class="cat-header-top">
                        <div class="cat-index">02</div>
                        <div class="cat-circle-btn">→</div>
                    </div>
                    <div class="cat-body">
                        <div class="cat-label">FOR</div>
                        <h2 class="cat-title">Europe</h2>
                        <p class="cat-desc">Old-world charm meets modern work culture. From Swiss Alps to Mediterranean
                            escapes.</p>
                    </div>
                    <div class="cat-footer">
                        <div class="cat-meta">7 TO 10 DAYS · 15 TO 40 PAX · LUXURY STAYS</div>
                        <a href="#" class="cat-open">OPEN →</a>
                    </div>
                </div>

                <!-- 03 DOMESTIC (Small Card) -->
                <div class="cat-card cat-small" style="background-image: url('assets/img/cat-domestic.png');">
                    <div class="cat-overlay"></div>
                    <div class="cat-header-top">
                        <div class="cat-index">03</div>
                        <div class="cat-circle-btn">→</div>
                    </div>
                    <div class="cat-body">
                        <div class="cat-label">FOR</div>
                        <h2 class="cat-title">Domestic</h2>
                        <p class="cat-desc">Uncover the gems closer to home. Mountain retreats, coastal escapes, and
                            heritage stays.</p>
                    </div>
                    <div class="cat-footer">
                        <div class="cat-meta">3 TO 5 DAYS · 30 TO 200 PAX · 12 DESTINATIONS</div>
                        <a href="#" class="cat-open">OPEN →</a>
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
        <div class="section-container why-dest-flex">
            <div class="why-dest-left">
                <h2 class="why-title">Why Our Destinations Deliver More</h2>
            </div>
            <div class="why-dest-right">
                <div class="why-dest-grid">
                    <div class="why-dest-item">
                        <div class="w-icon bg-orange"><i class="fa-solid fa-chess-knight"></i></div>
                        <h4>Strategic Selection</h4>
                        <p>We choose destinations that inspire, engage and motivate.</p>
                    </div>
                    <div class="why-dest-item">
                        <div class="w-icon bg-green"><i class="fa-solid fa-route"></i></div>
                        <h4>Seamless Logistics</h4>
                        <p>End-to-end planning and on-ground execution.</p>
                    </div>
                    <div class="why-dest-item">
                        <div class="w-icon bg-purple"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                        <h4>Exclusive Experiences</h4>
                        <p>Unique activities and access beyond the usual.</p>
                    </div>
                    <div class="why-dest-item">
                        <div class="w-icon bg-yellow"><i class="fa-solid fa-chart-line"></i></div>
                        <h4>Measurable Impact</h4>
                        <p>Trips designed to drive performance and strengthen relationships.</p>
                    </div>
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
