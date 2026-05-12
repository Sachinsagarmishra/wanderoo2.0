<?php
$pageTitle = "India's #1 Incentive Travel Platform";
include_once 'includes/header.php';
?>

<main>
    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">☆ INDIA'S #1 INCENTIVE TRAVEL PLATFORM</div>
            <h1>Make Performance<br><span class="accent">Worth Chasing</span></h1>
            <p>Incentive travel programs that motivate employees, energise dealers, and retain your best people —
                planned and executed end-to-end.</p>
            <div class="hero-actions">
                <button class="btn-primary">Plan a Trip →</button>
                <button class="btn-secondary">View Destinations</button>
            </div>

            <div class="hero-trust">
                <p>Trusted by teams at</p>
                <div class="trust-logos">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/cred.svg" alt="CRED">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/tata.svg" alt="TATA">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/isb.svg" alt="ISB">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/byjus.svg" alt="BYJU'S">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/razorpay.svg" alt="RAZORPAY">
                </div>
            </div>
        </div>

        <!-- Floating stats -->
        <div class="hero-stats">
            <div class="stat-card">
                <div class="stat-icon purple">✈️</div>
                <div class="stat-info">
                    <div class="num">98<span>%</span></div>
                    <div class="label">Retention</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">👥</div>
                <div class="stat-info">
                    <div class="num">15<span>k</span></div>
                    <div class="label">Happy Travellers</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">⭐</div>
                <div class="stat-info">
                    <div class="num">4.9<span>★</span></div>
                    <div class="label">Avg. Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- SOLUTIONS -->
    <section class="use-cases" id="solutions">
        <div class="use-cases-header">
            <div class="header-left">
                <div class="section-label">Solutions</div>
                <div class="section-title">Built for every<br>corporate use case</div>
            </div>
            <div class="header-right">
                <p class="section-sub">From HR incentives to dealer trips — we handle the complexity so you can focus on
                    performance.</p>
            </div>
        </div>
        <div class="use-grid">
            <!-- 1. Leadership Offsites -->
            <div class="use-card theme-purple">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/leadership.png" alt="Leadership">
                </div>
                <h3>Leadership Offsites</h3>
                <p>Retreats designed for strategy, alignment, and executive team bonding.</p>
                <span class="tag">FOR CXOS & ADMINS</span>
            </div>

            <!-- 2. Dealer & Distributor Trips -->
            <div class="use-card theme-green">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/dealer.png" alt="Dealer">
                </div>
                <h3>Dealer & Distributor Trips</h3>
                <p>Motivate your channel partners with incentive travel tied to sales milestones.</p>
                <span class="tag">FOR SALES LEADERS</span>
            </div>

            <!-- 3. Employee Incentives -->
            <div class="use-card theme-orange">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/empolyee.png" alt="Employee">
                </div>
                <h3>Employee Incentives</h3>
                <p>Reward top performers with curated travel experiences that drive retention and loyalty.</p>
                <span class="tag">FOR HR & PEOPLE TEAMS</span>
            </div>

            <!-- 4. Annual Team Offsites -->
            <div class="use-card theme-blue">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/college.png" alt="Annual">
                </div>
                <h3>Annual Team Offsites</h3>
                <p>Bring teams together through immersive retreats that strengthen culture and alignment.</p>
                <span class="tag">FOR PEOPLE OPS</span>
            </div>
        </div>
    </section>

    <!-- WORKATION CATEGORIES GRID -->
    <section class="category-section" id="destinations">
        <div class="category-grid">
            <!-- 01 REMOTE FIRST (Large Card) -->
            <div class="cat-card cat-large" style="background-image: url('assets/img/cat-remote.png');">
                <div class="cat-overlay"></div>
                <div class="cat-header-top">
                    <div class="cat-index">01</div>
                    <div class="cat-circle-btn">→</div>
                </div>
                <div class="cat-body">
                    <div class="cat-label">FOR</div>
                    <h2 class="cat-title">Remote-<br>first</h2>
                    <p class="cat-desc">When the only IRL is once a year, make it the one they'll talk about for years.</p>
                </div>
                <div class="cat-footer">
                    <div class="cat-meta">5 DAYS · 20 TO 60 PAX · HYBRID FORMAT</div>
                    <a href="#" class="cat-open">OPEN →</a>
                </div>
            </div>

            <div class="cat-right-stack">
                <!-- 02 DOMESTIC CLOSE (Small Card) -->
                <div class="cat-card cat-small" style="background-image: url('assets/img/cat-domestic.png');">
                    <div class="cat-overlay"></div>
                    <div class="cat-header-top">
                        <div class="cat-index">02</div>
                        <div class="cat-circle-btn">→</div>
                    </div>
                    <div class="cat-body">
                        <div class="cat-label">FOR</div>
                        <h2 class="cat-title">Domestic · Close</h2>
                        <p class="cat-desc">Out of the office, into the wild, and back home before Monday.</p>
                    </div>
                    <div class="cat-footer">
                        <div class="cat-meta">2 TO 4 DAYS · 40 TO 150 PAX · 9 DESTINATIONS</div>
                        <a href="#" class="cat-open">OPEN →</a>
                    </div>
                </div>

                <!-- 03 INTERNATIONAL (Small Card) -->
                <div class="cat-card cat-small" style="background-image: url('assets/img/cat-international.png');">
                    <div class="cat-overlay"></div>
                    <div class="cat-header-top">
                        <div class="cat-index">03</div>
                        <div class="cat-circle-btn">→</div>
                    </div>
                    <div class="cat-body">
                        <div class="cat-label">FOR</div>
                        <h2 class="cat-title">International</h2>
                        <p class="cat-desc">Some years deserve a passport-stamp moment.</p>
                    </div>
                    <div class="cat-footer">
                        <div class="cat-meta">5 TO 7 DAYS · 20 TO 60 PAX · VISAS HANDLED</div>
                        <a href="#" class="cat-open">OPEN →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY WANDEROO -->
    <section class="why">
        <div class="why-container">
            <!-- Left: Title & Subtext -->
            <div class="why-left">
                <div class="section-label">Why Wanderoo</div>
                <h2 class="section-title">We solve the real<br>problems of corporate travel</h2>
                <p class="section-sub">Because fragmented vendors, opaque pricing, and generic rewards are costing you
                    more than you think.</p>
                <img src="<?php echo SITE_PATH; ?>/assets/img/arrow.png" alt="Decorative Arrow" class="why-arrow">
            </div>

            <!-- Center: Comparison Card -->
            <div class="why-center">
                <div class="comparison-card">
                    <div class="comparison-header">
                        <div class="comp-col-label problem">❌ PROBLEM</div>
                        <div class="comp-col-label wanderoo">✅ WANDEROO</div>
                    </div>
                    <div class="comparison-row">
                        <div class="comp-problem">Too many vendors, too much coordination</div>
                        <div class="comp-wanderoo">One platform, one point of contact</div>
                    </div>
                    <div class="comparison-row">
                        <div class="comp-problem">Time-consuming trip planning</div>
                        <div class="comp-wanderoo">Done-for-you itineraries, ready in 48h</div>
                    </div>
                    <div class="comparison-row">
                        <div class="comp-problem">Generic rewards with low engagement</div>
                        <div class="comp-wanderoo">Experience-driven travel that employees remember</div>
                    </div>
                    <div class="comparison-row">
                        <div class="comp-problem">Budget confusion and hidden costs</div>
                        <div class="comp-wanderoo">Transparent per-person pricing, always</div>
                    </div>
                </div>
            </div>

            <!-- Right: Metrics Stack -->
            <div class="why-right">
                <div class="metric-card theme-orange">
                    <div class="metric-icon">📈</div>
                    <div class="metric-content">
                        <div class="metric-num">35<span>%</span></div>
                        <div class="metric-desc">Average performance boost post incentive trips</div>
                    </div>
                </div>
                <div class="metric-card theme-purple">
                    <div class="metric-icon">⏱️</div>
                    <div class="metric-content">
                        <div class="metric-num">12<span>h</span></div>
                        <div class="metric-desc">Custom itinerary delivered to your inbox</div>
                    </div>
                </div>
                <div class="metric-card theme-green">
                    <div class="metric-icon">💰</div>
                    <div class="metric-content">
                        <div class="metric-num">30<span>%</span></div>
                        <div class="metric-desc">Average savings vs. booking independently</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CASE STUDIES -->
    <section id="case-studies">
        <div class="case-header-main">
            <div class="section-label">Case Studies</div>
            <h2 class="section-title">Real results from<br>real companies</h2>
            <p class="section-sub">See how leading brands use Wanderoo to drive performance through experience.</p>
        </div>
        <div class="case-grid">
            <!-- CRED -->
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">
                        <img src="<?php echo SITE_PATH; ?>/assets/img/logos/cred.svg" alt="CRED">
                    </div>
                    <div class="case-dest-badge badge-orange">
                        <span>🇹🇭</span> Thailand
                    </div>
                </div>
                <div class="case-type">Sales Incentive Trip · 120 Employees</div>
                <div class="case-stats">
                    <div>
                        <div class="case-stat-num">120</div>
                        <div class="case-stat-label">Employees</div>
                    </div>
                    <div>
                        <div class="case-stat-num">5<span>D</span></div>
                        <div class="case-stat-label">Duration</div>
                    </div>
                    <div>
                        <div class="case-stat-num">+30<span>%</span></div>
                        <div class="case-stat-label">Performance Lift</div>
                    </div>
                </div>
                <div class="case-outcome">
                    <strong>Outcome</strong>
                    Post-trip engagement scores hit an all-time high. Sales team exceeded Q3 targets by 30%.
                </div>
            </div>

            <!-- ISB -->
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">
                        <img src="<?php echo SITE_PATH; ?>/assets/img/logos/isb.svg" alt="ISB">
                    </div>
                    <div class="case-dest-badge badge-green">
                        <span>🏔️</span> Uttarakhand
                    </div>
                </div>
                <div class="case-type">Leadership Retreat · Senior Faculty</div>
                <div class="case-stats">
                    <div>
                        <div class="case-stat-num">45</div>
                        <div class="case-stat-label">Leaders</div>
                    </div>
                    <div>
                        <div class="case-stat-num">4<span>D</span></div>
                        <div class="case-stat-label">Duration</div>
                    </div>
                    <div>
                        <div class="case-stat-num">100<span>%</span></div>
                        <div class="case-stat-label">Satisfaction</div>
                    </div>
                </div>
                <div class="case-outcome">
                    <strong>Outcome</strong>
                    Full strategy realignment achieved. Faculty returned energised with a clear institutional roadmap.
                </div>
            </div>

            <!-- TATA -->
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">
                        <img src="<?php echo SITE_PATH; ?>/assets/img/logos/tata.svg" alt="TATA">
                    </div>
                    <div class="case-dest-badge badge-red">
                        <span>🇸🇬</span> Singapore
                    </div>
                </div>
                <div class="case-type">Dealer Incentive Trip · Top Distributors</div>
                <div class="case-stats">
                    <div>
                        <div class="case-stat-num">200</div>
                        <div class="case-stat-label">Dealers</div>
                    </div>
                    <div>
                        <div class="case-stat-num">6<span>D</span></div>
                        <div class="case-stat-label">Duration</div>
                    </div>
                    <div>
                        <div class="case-stat-num">+45<span>%</span></div>
                        <div class="case-stat-label">Repeat Orders</div>
                    </div>
                </div>
                <div class="case-outcome">
                    <strong>Outcome</strong>
                    Dealer network strengthened significantly. Repeat order rates jumped 45% in the quarter following.
                </div>
            </div>

            <!-- Razorpay -->
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">
                        <img src="<?php echo SITE_PATH; ?>/assets/img/logos/razorpay.svg" alt="Razorpay">
                    </div>
                    <div class="case-dest-badge badge-purple">
                        <span>🌺</span> Bali
                    </div>
                </div>
                <div class="case-type">Annual All-Hands · Full Team</div>
                <div class="case-stats">
                    <div>
                        <div class="case-stat-num">350</div>
                        <div class="case-stat-label">Employees</div>
                    </div>
                    <div>
                        <div class="case-stat-num">5<span>D</span></div>
                        <div class="case-stat-label">Duration</div>
                    </div>
                    <div>
                        <div class="case-stat-num">4.9<span>★</span></div>
                        <div class="case-stat-label">Avg. Rating</div>
                    </div>
                </div>
                <div class="case-outcome">
                    <strong>Outcome</strong>
                    Flawless execution for 350 pax. Zero logistics issues. Team voted it the best all-hands ever.
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how" id="how">
        <div class="how-header">
            <div class="section-label">How It Works</div>
            <h2 class="section-title">From idea to journey<br>in 4 steps</h2>
            <p class="section-sub">We've simplified corporate travel planning so you can focus on what matters — your people.</p>
        </div>
        <div class="how-steps-container">
            <div class="how-step theme-orange">
                <div class="step-badge">1</div>
                <div class="step-icon-box">
                    <div class="step-icon">🎯</div>
                </div>
                <div class="step-text">
                    <h3>Tell us your goal</h3>
                    <p>Share your team size, budget, destination preference, and what you want to achieve.</p>
                </div>
            </div>

            <div class="step-arrow">→</div>

            <div class="how-step theme-green">
                <div class="step-badge">2</div>
                <div class="step-icon-box">
                    <div class="step-icon">🗺️</div>
                </div>
                <div class="step-text">
                    <h3>We design your trip</h3>
                    <p>Our experts craft a custom itinerary — flights, hotels, activities, and logistics.</p>
                </div>
            </div>

            <div class="step-arrow">→</div>

            <div class="how-step theme-purple">
                <div class="step-badge">3</div>
                <div class="step-icon-box">
                    <div class="step-icon">🤝</div>
                </div>
                <div class="step-text">
                    <h3>You approve & relax</h3>
                    <p>Review the proposal, make tweaks, and give the go-ahead. We handle the rest.</p>
                </div>
            </div>

            <div class="step-arrow">→</div>

            <div class="how-step theme-blue">
                <div class="step-badge">4</div>
                <div class="step-icon-box">
                    <div class="step-icon">✈️</div>
                </div>
                <div class="step-text">
                    <h3>End-to-end execution</h3>
                    <p>From airport transfers to farewell dinner — every detail managed by our team on the ground.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PRICING -->
    <section id="pricing">
        <div class="pricing-header">
            <div class="section-label">Pricing</div>
            <div class="section-title">Transparent pricing.<br>No surprises.</div>
            <p class="section-sub">Per-person pricing with everything included. Custom quote in 24 hours.</p>
        </div>
        <div class="pricing-grid">
            <div class="pricing-card">
                <div class="pricing-tier">Budget</div>
                <div class="pricing-price">₹14k+</div>
                <div class="pricing-note">per person, domestic</div>
                <ul class="pricing-features">
                    <li>Domestic destinations</li>
                    <li>Comfortable 3★ hotels</li>
                    <li>Curated group activities</li>
                    <li>Ground transfers included</li>
                    <li>Dedicated trip manager</li>
                </ul>
                <button class="pricing-btn outline">Get Quote</button>
            </div>
            <div class="pricing-card featured">
                <div class="featured-badge">Most Popular</div>
                <div class="pricing-tier">Premium</div>
                <div class="pricing-price">₹45k+</div>
                <div class="pricing-note">per person, international</div>
                <ul class="pricing-features">
                    <li>Southeast Asia destinations</li>
                    <li>4★ hotels & resorts</li>
                    <li>Custom team experiences</li>
                    <li>Flights + all transfers</li>
                    <li>24/7 on-ground support</li>
                    <li>Photography & content</li>
                </ul>
                <button class="pricing-btn primary">Get Quote →</button>
            </div>
            <div class="pricing-card">
                <div class="pricing-tier">Luxury</div>
                <div class="pricing-price">₹90k+</div>
                <div class="pricing-note">per person, luxury international</div>
                <ul class="pricing-features">
                    <li>Mauritius, Maldives & more</li>
                    <li>5★ luxury resorts</li>
                    <li>Private experiences & charters</li>
                    <li>Business class flights</li>
                    <li>Dedicated concierge team</li>
                    <li>Custom gifting & branding</li>
                </ul>
                <button class="pricing-btn outline">Get Quote</button>
            </div>
        </div>
    </section>

    <!-- FINAL CTA -->
    <section class="final-cta">
        <div class="section-label" style="text-align:center;">Ready to Start?</div>
        <div class="section-title">Plan your next incentive<br>trip in <em
                style="font-style:normal;background:linear-gradient(135deg,var(--amber),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent;">48
                hours</em></div>
        <p class="section-sub">Tell us your goal and we'll send you a fully designed itinerary with transparent pricing
            — no commitment required.</p>
        <div class="final-cta-actions">
            <button class="btn-primary" style="font-size:16px;padding:16px 36px;">Get Your Proposal →</button>
            <button class="btn-secondary" style="font-size:16px;padding:16px 36px;">Talk to an Expert</button>
        </div>
    </section>
</main>

<?php include_once 'includes/footer.php'; ?>