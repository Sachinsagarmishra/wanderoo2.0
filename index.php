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
            <p>Incentive travel programs that motivate employees, energise dealers, and retain your best people — planned and executed end-to-end.</p>
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
                    <div class="num">500<span>+</span></div>
                    <div class="label">Trips Executed</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">👥</div>
                <div class="stat-info">
                    <div class="num">48<span>k</span></div>
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
                <p class="section-sub">From HR incentives to dealer trips — we handle the complexity so you can focus on performance.</p>
            </div>
        </div>
        <div class="use-grid">
            <div class="use-card theme-orange">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/empolyee.png" alt="Employee">
                </div>
                <h3>Employee Incentives</h3>
                <p>Reward top performers with curated travel experiences that drive retention and loyalty.</p>
                <span class="tag">FOR HR & PEOPLE TEAMS</span>
            </div>
            <div class="use-card theme-green">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/dealer.png" alt="Dealer">
                </div>
                <h3>Dealer & Distributor Trips</h3>
                <p>Motivate your channel partners with incentive travel tied to sales milestones.</p>
                <span class="tag">FOR SALES LEADERS</span>
            </div>
            <div class="use-card theme-purple">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/leadership.png" alt="Leadership">
                </div>
                <h3>Leadership Offsites</h3>
                <p>Retreats designed for strategy, alignment, and executive team bonding.</p>
                <span class="tag">FOR CXOS & ADMINS</span>
            </div>
            <div class="use-card theme-blue">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/assets/img/logos/college.png" alt="College">
                </div>
                <h3>College & MBA Trips</h3>
                <p>Immersive international experiences for student cohorts and campus leaders.</p>
                <span class="tag">FOR INSTITUTIONS</span>
            </div>
        </div>
    </section>

    <!-- DESTINATIONS -->
    <section id="destinations">
        <div class="destinations-header">
            <div>
                <div class="section-label">Destinations</div>
                <div class="section-title">Where will you<br>reward them next?</div>
            </div>
            <div class="tab-group">
                <button class="tab active" onclick="switchTab('intl', this)">🌍 International</button>
                <button class="tab" onclick="switchTab('dom', this)">🇮🇳 Domestic</button>
            </div>
        </div>

        <!-- International -->
        <div id="dest-intl" class="dest-grid">
            <div class="dest-card">
                <div class="dest-img"><div class="dest-img-inner sg">🏙️</div></div>
                <div class="dest-body">
                    <div class="dest-tag">Incentive · Offsite</div>
                    <h3>Singapore</h3>
                    <div class="dest-meta">5D/4N · Group activities · City + Gardens</div>
                    <div class="dest-price">₹65,000 <span>/ person onwards</span></div>
                    <div class="dest-actions">
                        <button class="dest-btn primary">View Itinerary</button>
                        <button class="dest-btn outline">Customize</button>
                    </div>
                </div>
            </div>
            <div class="dest-card">
                <div class="dest-img"><div class="dest-img-inner th">🌴</div></div>
                <div class="dest-body">
                    <div class="dest-tag">Incentive · Beach</div>
                    <h3>Thailand</h3>
                    <div class="dest-meta">5D/4N · Beach + Team Activities</div>
                    <div class="dest-price">₹45,000 <span>/ person onwards</span></div>
                    <div class="dest-actions">
                        <button class="dest-btn primary">View Itinerary</button>
                        <button class="dest-btn outline">Customize</button>
                    </div>
                </div>
            </div>
            <div class="dest-card">
                <div class="dest-img"><div class="dest-img-inner my">🌇</div></div>
                <div class="dest-body">
                    <div class="dest-tag">Incentive · Culture</div>
                    <h3>Malaysia</h3>
                    <div class="dest-meta">4D/3N · City + Jungle + Beaches</div>
                    <div class="dest-price">₹38,000 <span>/ person onwards</span></div>
                    <div class="dest-actions">
                        <button class="dest-btn primary">View Itinerary</button>
                        <button class="dest-btn outline">Customize</button>
                    </div>
                </div>
            </div>
            <div class="dest-card">
                <div class="dest-img"><div class="dest-img-inner mu">🏝️</div></div>
                <div class="dest-body">
                    <div class="dest-tag">Luxury · Incentive</div>
                    <h3>Mauritius</h3>
                    <div class="dest-meta">6D/5N · Luxury Beach Resort</div>
                    <div class="dest-price">₹90,000 <span>/ person onwards</span></div>
                    <div class="dest-actions">
                        <button class="dest-btn primary">View Itinerary</button>
                        <button class="dest-btn outline">Customize</button>
                    </div>
                </div>
            </div>
            <div class="dest-card">
                <div class="dest-img"><div class="dest-img-inner sl">🌿</div></div>
                <div class="dest-body">
                    <div class="dest-tag">Adventure · Offsite</div>
                    <h3>Sri Lanka</h3>
                    <div class="dest-meta">5D/4N · Culture + Beach + Tea Hills</div>
                    <div class="dest-price">₹42,000 <span>/ person onwards</span></div>
                    <div class="dest-actions">
                        <button class="dest-btn primary">View Itinerary</button>
                        <button class="dest-btn outline">Customize</button>
                    </div>
                </div>
            </div>
            <div class="dest-card">
                <div class="dest-img"><div class="dest-img-inner bali">🌺</div></div>
                <div class="dest-body">
                    <div class="dest-tag">Incentive · Wellness</div>
                    <h3>Bali, Indonesia</h3>
                    <div class="dest-meta">5D/4N · Temples + Beach + Retreats</div>
                    <div class="dest-price">₹48,000 <span>/ person onwards</span></div>
                    <div class="dest-actions">
                        <button class="dest-btn primary">View Itinerary</button>
                        <button class="dest-btn outline">Customize</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Domestic -->
        <div id="dest-dom" class="dest-grid" style="display:none;">
            <div class="dest-card">
                <div class="dest-img"><div class="dest-img-inner hp">⛰️</div></div>
                <div class="dest-body">
                    <div class="dest-tag">Adventure · Offsite</div>
                    <h3>Himachal Pradesh</h3>
                    <div class="dest-meta">4D/3N · Mountains + Adventure + Bonding</div>
                    <div class="dest-price">₹18,000 <span>/ person onwards</span></div>
                    <div class="dest-actions">
                        <button class="dest-btn primary">View Itinerary</button>
                        <button class="dest-btn outline">Customize</button>
                    </div>
                </div>
            </div>
            <div class="dest-card">
                <div class="dest-img"><div class="dest-img-inner goa">🌊</div></div>
                <div class="dest-body">
                    <div class="dest-tag">Incentive · Beach</div>
                    <h3>Goa</h3>
                    <div class="dest-meta">3D/2N · Beach + Nightlife + Team Activities</div>
                    <div class="dest-price">₹14,000 <span>/ person onwards</span></div>
                    <div class="dest-actions">
                        <button class="dest-btn primary">View Itinerary</button>
                        <button class="dest-btn outline">Customize</button>
                    </div>
                </div>
            </div>
            <div class="dest-card">
                <div class="dest-img"><div class="dest-img-inner raj">🏰</div></div>
                <div class="dest-body">
                    <div class="dest-tag">Luxury · Culture</div>
                    <h3>Rajasthan</h3>
                    <div class="dest-meta">5D/4N · Heritage Hotels + Desert Safari</div>
                    <div class="dest-price">₹22,000 <span>/ person onwards</span></div>
                    <div class="dest-actions">
                        <button class="dest-btn primary">View Itinerary</button>
                        <button class="dest-btn outline">Customize</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY WANDEROO -->
    <section class="why">
        <div class="why-header">
            <div class="section-label">Why Wanderoo</div>
            <div class="section-title">We solve the real<br>problems of corporate travel</div>
            <p class="section-sub">Because fragmented vendors, opaque pricing, and generic rewards are costing you more than you think.</p>
        </div>
        <div class="why-grid">
            <div class="problem-solution">
                <div class="ps-row">
                    <div class="ps-problem">
                        <div class="ps-label">❌ Problem</div>
                        <p>Too many vendors, too much coordination</p>
                    </div>
                    <div class="ps-solution">
                        <div class="ps-label">✅ Wanderoo</div>
                        <p>One platform, one point of contact</p>
                    </div>
                </div>
                <div class="ps-row">
                    <div class="ps-problem">
                        <div class="ps-label">❌ Problem</div>
                        <p>Time-consuming trip planning</p>
                    </div>
                    <div class="ps-solution">
                        <div class="ps-label">✅ Wanderoo</div>
                        <p>Done-for-you itineraries, ready in 48h</p>
                    </div>
                </div>
                <div class="ps-row">
                    <div class="ps-problem">
                        <div class="ps-label">❌ Problem</div>
                        <p>Generic rewards with low engagement</p>
                    </div>
                    <div class="ps-solution">
                        <div class="ps-label">✅ Wanderoo</div>
                        <p>Experience-driven travel that employees remember</p>
                    </div>
                </div>
                <div class="ps-row">
                    <div class="ps-problem">
                        <div class="ps-label">❌ Problem</div>
                        <p>Budget confusion and hidden costs</p>
                    </div>
                    <div class="ps-solution">
                        <div class="ps-label">✅ Wanderoo</div>
                        <p>Transparent per-person pricing, always</p>
                    </div>
                </div>
            </div>
            <div class="why-right">
                <div class="metric-card">
                    <div class="metric-icon">📈</div>
                    <div>
                        <div class="metric-num">35<span>%</span></div>
                        <div class="metric-desc">Average performance boost post incentive trips</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon">⏱️</div>
                    <div>
                        <div class="metric-num">48<span>h</span></div>
                        <div class="metric-desc">Custom itinerary delivered to your inbox</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon">💰</div>
                    <div>
                        <div class="metric-num">20<span>%</span></div>
                        <div class="metric-desc">Average savings vs. booking independently</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CASE STUDIES -->
    <section id="case-studies">
        <div>
            <div class="section-label">Case Studies</div>
            <div class="section-title">Real results from<br>real companies</div>
            <p class="section-sub" style="margin-bottom: 56px;">See how leading brands use Wanderoo to drive performance through experience.</p>
        </div>
        <div class="case-grid">
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">CRED</div>
                    <div class="case-dest-badge">🇹🇭 Thailand</div>
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
                    <strong>Outcome:</strong> Post-trip engagement scores hit an all-time high. Sales team exceeded Q3 targets by 30%.
                </div>
            </div>
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">ISB</div>
                    <div class="case-dest-badge">🏔️ Uttarakhand</div>
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
                    <strong>Outcome:</strong> Full strategy realignment achieved. Faculty returned energised with a clear institutional roadmap.
                </div>
            </div>
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">TATA</div>
                    <div class="case-dest-badge">🇸🇬 Singapore</div>
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
                    <strong>Outcome:</strong> Dealer network strengthened significantly. Repeat order rates jumped 45% in the quarter following.
                </div>
            </div>
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">Razorpay</div>
                    <div class="case-dest-badge">🌺 Bali</div>
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
                    <strong>Outcome:</strong> Flawless execution for 350 pax. Zero logistics issues. Team voted it the best all-hands ever.
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how" id="how">
        <div class="how-header">
            <div class="section-label">How It Works</div>
            <div class="section-title">From idea to journey<br>in 4 steps</div>
            <p class="section-sub">We've simplified corporate travel planning so you can focus on what matters — your people.</p>
        </div>
        <div class="how-steps">
            <div class="how-step">
                <div class="step-num">1</div>
                <h3>Tell us your goal</h3>
                <p>Share your team size, budget, destination preference, and what you want to achieve.</p>
            </div>
            <div class="how-step">
                <div class="step-num">2</div>
                <h3>We design your trip</h3>
                <p>Our experts craft a custom itinerary — flights, hotels, activities, and logistics.</p>
            </div>
            <div class="how-step">
                <div class="step-num">3</div>
                <h3>You approve & relax</h3>
                <p>Review the proposal, make tweaks, and give the go-ahead. We handle the rest.</p>
            </div>
            <div class="how-step">
                <div class="step-num">4</div>
                <h3>End-to-end execution</h3>
                <p>From airport transfers to farewell dinner — every detail managed by our team on the ground.</p>
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
        <div class="section-title">Plan your next incentive<br>trip in <em style="font-style:normal;background:linear-gradient(135deg,var(--amber),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent;">48 hours</em></div>
        <p class="section-sub">Tell us your goal and we'll send you a fully designed itinerary with transparent pricing — no commitment required.</p>
        <div class="final-cta-actions">
            <button class="btn-primary" style="font-size:16px;padding:16px 36px;">Get Your Proposal →</button>
            <button class="btn-secondary" style="font-size:16px;padding:16px 36px;">Talk to an Expert</button>
        </div>
    </section>
</main>

<?php include_once 'includes/footer.php'; ?>