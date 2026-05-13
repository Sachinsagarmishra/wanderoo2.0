<?php
$pageTitle = "India's #1 Incentive Travel Platform";
include_once 'includes/header.php';
?>

<main>
    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">INDIA'S #1 INCENTIVE TRAVEL PLATFORM</div>
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
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/dunzo.svg" alt="Dunzo">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/tata1mg.svg" alt="Tata 1mg">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/videocon.svg" alt="Videocon">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/isb.svg" alt="ISB">
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
    <section class="use-cases reveal-section" id="solutions">
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
    <section class="category-section reveal-section" id="destinations">
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

    <!-- WHY WANDEROO -->
    <section class="why reveal-section">
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
    <section id="case-studies" class="reveal-section">
        <div class="case-header-main">
            <div class="section-label">Case Studies</div>
            <h2 class="section-title">Real results from<br>real companies</h2>
            <p class="section-sub">See how leading brands use Wanderoo to drive performance through experience.</p>
        </div>
        <div class="case-grid">
            <!-- Dunzo -->
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">
                        <img src="<?php echo SITE_PATH; ?>/assets/img/logos/dunzo.svg" alt="Dunzo">
                    </div>
                    <div class="case-dest-badge badge-orange">
                        <span>🇹🇭</span> Thailand
                    </div>
                </div>
                <div class="case-type">Growth Team Offsite · 80 Employees</div>
                <div class="case-stats">
                    <div>
                        <div class="case-stat-num">80</div>
                        <div class="case-stat-label">Employees</div>
                    </div>
                    <div>
                        <div class="case-stat-num">4<span>D</span></div>
                        <div class="case-stat-label">Duration</div>
                    </div>
                    <div>
                        <div class="case-stat-num">+25<span>%</span></div>
                        <div class="case-stat-label">Efficiency</div>
                    </div>
                </div>
                <div class="case-outcome">
                    <strong>Outcome</strong>
                    Improved cross-team collaboration for logistics and ops. Post-trip productivity metrics showed a 25%
                    steady rise.
                </div>
            </div>

            <!-- Tata 1mg -->
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">
                        <img src="<?php echo SITE_PATH; ?>/assets/img/logos/tata1mg.svg" alt="Tata 1mg">
                    </div>
                    <div class="case-dest-badge badge-green">
                        <span>🌿</span> Rishikesh
                    </div>
                </div>
                <div class="case-type">Product Design Retreat · 60 Employees</div>
                <div class="case-stats">
                    <div>
                        <div class="case-stat-num">60</div>
                        <div class="case-stat-label">Designers</div>
                    </div>
                    <div>
                        <div class="case-stat-num">3<span>D</span></div>
                        <div class="case-stat-label">Duration</div>
                    </div>
                    <div>
                        <div class="case-stat-num">98<span>%</span></div>
                        <div class="case-stat-label">Creative Output</div>
                    </div>
                </div>
                <div class="case-outcome">
                    <strong>Outcome</strong>
                    The design team finalized the new app UI in record time. 98% satisfaction score on retreat quality.
                </div>
            </div>

            <!-- Videocon -->
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">
                        <img src="<?php echo SITE_PATH; ?>/assets/img/logos/videocon.svg" alt="Videocon">
                    </div>
                    <div class="case-dest-badge badge-red">
                        <span>🇸🇬</span> Singapore
                    </div>
                </div>
                <div class="case-type">Sales Incentive Trip · 150 Employees</div>
                <div class="case-stats">
                    <div>
                        <div class="case-stat-num">150</div>
                        <div class="case-stat-label">Distributors</div>
                    </div>
                    <div>
                        <div class="case-stat-num">5<span>D</span></div>
                        <div class="case-stat-label">Duration</div>
                    </div>
                    <div>
                        <div class="case-stat-num">+40<span>%</span></div>
                        <div class="case-stat-label">Sales Boost</div>
                    </div>
                </div>
                <div class="case-outcome">
                    <strong>Outcome</strong>
                    Incentivized the top distributor network across India. Resulted in a 40% jump in festive season
                    inventory.
                </div>
            </div>

            <!-- ISB -->
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">
                        <img src="<?php echo SITE_PATH; ?>/assets/img/logos/isb.svg" alt="ISB">
                    </div>
                    <div class="case-dest-badge badge-purple">
                        <span>🏔️</span> Sri Lanka
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
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how reveal-section" id="how">
        <div class="how-header">
            <div class="section-label">How It Works</div>
            <h2 class="section-title">From idea to journey<br>in 4 steps</h2>
            <p class="section-sub">We've simplified corporate travel planning so you can focus on what matters — your
                people.</p>
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



    <!-- NORTH AI PLANNER -->
    <section class="ai-planner-section reveal-section">
        <div class="planner-container">
            <div class="section-label" style="text-align:center; color: var(--amber);">Investment Planner</div>
            <h2 class="section-title" style="color: var(--text-main);">Get Your Estimate<br>In Seconds.</h2>
            <p class="section-sub" style="color: var(--text-muted); margin: 0 auto 40px; max-width: 700px;">
                Ask <strong>North AI</strong> for a personalized estimate with venue recommendations, or use the manual
                planner for a quick indicative range across our popular destinations.
            </p>

            <div class="planner-actions">
                <button class="btn-planner-primary">
                    <span class="ai-icon">✨</span> ASK NORTH AI
                </button>
                <button class="btn-planner-outline">
                    MANUAL CALCULATOR
                </button>
            </div>

            <div class="planner-suggestions">
                <div class="suggestion-chip">50-person offsite</div>
                <div class="suggestion-chip">Leadership retreat</div>
                <div class="suggestion-chip">200-person conference</div>
                <div class="suggestion-chip">Team workation</div>
            </div>

            <p class="planner-footer-text">Pick a mode above, or click a suggestion to ask North AI directly</p>
        </div>
    </section>
</main>

<?php include_once 'includes/footer.php'; ?>