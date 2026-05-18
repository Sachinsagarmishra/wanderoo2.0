<?php
$pageTitle = "India's #1 Incentive Travel Platform";
include_once 'includes/header.php';
?>

<main>
    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge"><?php echo htmlspecialchars(get_site_setting('home_hero_badge')); ?></div>
            <h1><?php echo get_site_setting('home_hero_title'); ?></h1>
            <p><?php echo htmlspecialchars(get_site_setting('home_hero_desc')); ?></p>
            <div class="hero-actions">
                <button class="btn-primary" onclick="window.open('https://wa.me/<?php echo htmlspecialchars(get_site_setting('whatsapp_number', '919113515462')); ?>', '_blank')">Plan a Trip →</button>
                <button class="btn-secondary" onclick="window.location.href='destinations.php'">View Destinations</button>
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
                <div class="stat-icon purple"><i class="fa-solid fa-plane-departure"></i></div>
                <div class="stat-info">
                    <div class="num"><?php 
                        $val1 = get_site_setting('home_stat1_num');
                        $num1 = preg_replace('/[^0-9.]/', '', $val1);
                        $suffix1 = str_replace($num1, '', $val1);
                        echo htmlspecialchars($num1);
                    ?><span><?php echo htmlspecialchars($suffix1); ?></span></div>
                    <div class="label"><?php echo htmlspecialchars(get_site_setting('home_stat1_label')); ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fa-solid fa-users"></i></div>
                <div class="stat-info">
                    <div class="num"><?php 
                        $val2 = get_site_setting('home_stat2_num');
                        $num2 = preg_replace('/[^0-9.]/', '', $val2);
                        $suffix2 = str_replace($num2, '', $val2);
                        echo htmlspecialchars($num2);
                    ?><span><?php echo htmlspecialchars($suffix2); ?></span></div>
                    <div class="label"><?php echo htmlspecialchars(get_site_setting('home_stat2_label')); ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-star"></i></div>
                <div class="stat-info">
                    <div class="num"><?php 
                        $val3 = get_site_setting('home_stat3_num');
                        $num3 = preg_replace('/[^0-9.]/', '', $val3);
                        $suffix3 = str_replace($num3, '', $val3);
                        echo htmlspecialchars($num3);
                    ?><span><?php echo htmlspecialchars($suffix3); ?></span></div>
                    <div class="label"><?php echo htmlspecialchars(get_site_setting('home_stat3_label')); ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- SOLUTIONS -->
    <section class="use-cases reveal-section" id="solutions">
        <div class="use-cases-header">
            <div class="header-left">
                <div class="section-label"><?php echo htmlspecialchars(get_site_setting('home_solutions_label')); ?></div>
                <div class="section-title"><?php echo get_site_setting('home_solutions_title'); ?></div>
            </div>
            <div class="header-right">
                <p class="section-sub"><?php echo htmlspecialchars(get_site_setting('home_solutions_desc')); ?></p>
            </div>
        </div>
        <div class="use-grid">
            <!-- 1. Leadership Offsites -->
            <div class="use-card theme-purple">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/<?php echo htmlspecialchars(get_site_setting('sol1_img')); ?>" alt="Leadership">
                </div>
                <h3><?php echo htmlspecialchars(get_site_setting('sol1_title')); ?></h3>
                <p><?php echo htmlspecialchars(get_site_setting('sol1_desc')); ?></p>
                <span class="tag"><?php echo htmlspecialchars(get_site_setting('sol1_tag')); ?></span>
            </div>

            <!-- 2. Dealer & Distributor Trips -->
            <div class="use-card theme-green">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/<?php echo htmlspecialchars(get_site_setting('sol2_img')); ?>" alt="Dealer">
                </div>
                <h3><?php echo htmlspecialchars(get_site_setting('sol2_title')); ?></h3>
                <p><?php echo htmlspecialchars(get_site_setting('sol2_desc')); ?></p>
                <span class="tag"><?php echo htmlspecialchars(get_site_setting('sol2_tag')); ?></span>
            </div>

            <!-- 3. Employee Incentives -->
            <div class="use-card theme-orange">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/<?php echo htmlspecialchars(get_site_setting('sol3_img')); ?>" alt="Employee">
                </div>
                <h3><?php echo htmlspecialchars(get_site_setting('sol3_title')); ?></h3>
                <p><?php echo htmlspecialchars(get_site_setting('sol3_desc')); ?></p>
                <span class="tag"><?php echo htmlspecialchars(get_site_setting('sol3_tag')); ?></span>
            </div>

            <!-- 4. Annual Team Offsites -->
            <div class="use-card theme-blue">
                <div class="use-icon">
                    <img src="<?php echo SITE_PATH; ?>/<?php echo htmlspecialchars(get_site_setting('sol4_img')); ?>" alt="Annual">
                </div>
                <h3><?php echo htmlspecialchars(get_site_setting('sol4_title')); ?></h3>
                <p><?php echo htmlspecialchars(get_site_setting('sol4_desc')); ?></p>
                <span class="tag"><?php echo htmlspecialchars(get_site_setting('sol4_tag')); ?></span>
            </div>
        </div>
    </section>

    <!-- WORKATION CATEGORIES GRID -->
    <section class="category-section reveal-section" id="destinations">
        <div class="category-grid">
            <!-- 01 SOUTH EAST ASIA (Large Card) -->
            <div class="cat-card cat-large" style="background-image: url('<?php echo htmlspecialchars(get_site_setting('region1_img')); ?>');">
                <div class="cat-overlay"></div>
                <div class="cat-header-top">
                    <div class="cat-index"><?php echo htmlspecialchars(get_site_setting('region1_index')); ?></div>
                    <div class="cat-circle-btn">→</div>
                </div>
                <div class="cat-body">
                    <div class="cat-label">FOR</div>
                    <h2 class="cat-title"><?php echo get_site_setting('region1_title'); ?></h2>
                    <p class="cat-desc"><?php echo htmlspecialchars(get_site_setting('region1_desc')); ?></p>
                </div>
                <div class="cat-footer">
                    <div class="cat-meta"><?php echo htmlspecialchars(get_site_setting('region1_meta')); ?></div>
                    <a href="destinations.php" class="cat-open">OPEN →</a>
                </div>
            </div>

            <div class="cat-right-stack">
                <!-- 02 EUROPE (Small Card) -->
                <div class="cat-card cat-small" style="background-image: url('<?php echo htmlspecialchars(get_site_setting('region2_img')); ?>');">
                    <div class="cat-overlay"></div>
                    <div class="cat-header-top">
                        <div class="cat-index"><?php echo htmlspecialchars(get_site_setting('region2_index')); ?></div>
                        <div class="cat-circle-btn">→</div>
                    </div>
                    <div class="cat-body">
                        <div class="cat-label">FOR</div>
                        <h2 class="cat-title"><?php echo get_site_setting('region2_title'); ?></h2>
                        <p class="cat-desc"><?php echo htmlspecialchars(get_site_setting('region2_desc')); ?></p>
                    </div>
                    <div class="cat-footer">
                        <div class="cat-meta"><?php echo htmlspecialchars(get_site_setting('region2_meta')); ?></div>
                        <a href="destinations.php" class="cat-open">OPEN →</a>
                    </div>
                </div>

                <!-- 03 DOMESTIC (Small Card) -->
                <div class="cat-card cat-small" style="background-image: url('<?php echo htmlspecialchars(get_site_setting('region3_img')); ?>');">
                    <div class="cat-overlay"></div>
                    <div class="cat-header-top">
                        <div class="cat-index"><?php echo htmlspecialchars(get_site_setting('region3_index')); ?></div>
                        <div class="cat-circle-btn">→</div>
                    </div>
                    <div class="cat-body">
                        <div class="cat-label">FOR</div>
                        <h2 class="cat-title"><?php echo get_site_setting('region3_title'); ?></h2>
                        <p class="cat-desc"><?php echo htmlspecialchars(get_site_setting('region3_desc')); ?></p>
                    </div>
                    <div class="cat-footer">
                        <div class="cat-meta"><?php echo htmlspecialchars(get_site_setting('region3_meta')); ?></div>
                        <a href="destinations.php" class="cat-open">OPEN →</a>
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
                <div class="section-label"><?php echo htmlspecialchars(get_site_setting('home_why_label')); ?></div>
                <h2 class="section-title"><?php echo get_site_setting('home_why_title'); ?></h2>
                <p class="section-sub"><?php echo htmlspecialchars(get_site_setting('home_why_desc')); ?></p>
                <img src="<?php echo SITE_PATH; ?>/assets/img/arrow.png" alt="Decorative Arrow" class="why-arrow">
            </div>

            <!-- Center: Comparison Card -->
            <div class="why-center">
                <div class="comparison-card">
                    <div class="comparison-header">
                        <div class="comp-col-label problem"><i class="fa-solid fa-circle-xmark"></i> PROBLEM</div>
                        <div class="comp-col-label wanderoo"><i class="fa-solid fa-circle-check"></i> WANDEROO</div>
                    </div>
                    <div class="comparison-row">
                        <div class="comp-problem"><?php echo htmlspecialchars(get_site_setting('comp_p1')); ?></div>
                        <div class="comp-wanderoo"><?php echo htmlspecialchars(get_site_setting('comp_w1')); ?></div>
                    </div>
                    <div class="comparison-row">
                        <div class="comp-problem"><?php echo htmlspecialchars(get_site_setting('comp_p2')); ?></div>
                        <div class="comp-wanderoo"><?php echo htmlspecialchars(get_site_setting('comp_w2')); ?></div>
                    </div>
                    <div class="comparison-row">
                        <div class="comp-problem"><?php echo htmlspecialchars(get_site_setting('comp_p3')); ?></div>
                        <div class="comp-wanderoo"><?php echo htmlspecialchars(get_site_setting('comp_w3')); ?></div>
                    </div>
                    <div class="comparison-row">
                        <div class="comp-problem"><?php echo htmlspecialchars(get_site_setting('comp_p4')); ?></div>
                        <div class="comp-wanderoo"><?php echo htmlspecialchars(get_site_setting('comp_w4')); ?></div>
                    </div>
                </div>
            </div>

            <!-- Right: Metrics Stack -->
            <div class="why-right">
                <div class="metric-card theme-orange">
                    <div class="metric-icon"><i class="fa-solid fa-chart-line"></i></div>
                    <div class="metric-content">
                        <div class="metric-num"><?php 
                            $m1 = get_site_setting('metric1_num');
                            $num_m1 = preg_replace('/[^0-9.]/', '', $m1);
                            $suff_m1 = str_replace($num_m1, '', $m1);
                            echo htmlspecialchars($num_m1);
                        ?><span><?php echo htmlspecialchars($suff_m1); ?></span></div>
                        <div class="metric-desc"><?php echo htmlspecialchars(get_site_setting('metric1_desc')); ?></div>
                    </div>
                </div>
                <div class="metric-card theme-purple">
                    <div class="metric-icon"><i class="fa-solid fa-clock"></i></div>
                    <div class="metric-content">
                        <div class="metric-num"><?php 
                            $m2 = get_site_setting('metric2_num');
                            $num_m2 = preg_replace('/[^0-9.]/', '', $m2);
                            $suff_m2 = str_replace($num_m2, '', $m2);
                            echo htmlspecialchars($num_m2);
                        ?><span><?php echo htmlspecialchars($suff_m2); ?></span></div>
                        <div class="metric-desc"><?php echo htmlspecialchars(get_site_setting('metric2_desc')); ?></div>
                    </div>
                </div>
                <div class="metric-card theme-green">
                    <div class="metric-icon"><i class="fa-solid fa-piggy-bank"></i></div>
                    <div class="metric-content">
                        <div class="metric-num"><?php 
                            $m3 = get_site_setting('metric3_num');
                            $num_m3 = preg_replace('/[^0-9.]/', '', $m3);
                            $suff_m3 = str_replace($num_m3, '', $m3);
                            echo htmlspecialchars($num_m3);
                        ?><span><?php echo htmlspecialchars($suff_m3); ?></span></div>
                        <div class="metric-desc"><?php echo htmlspecialchars(get_site_setting('metric3_desc')); ?></div>
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
            <?php 
            $case_studies = get_all_case_studies();
            if (empty($case_studies)):
            ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-muted);">
                    No case studies found. Please add some from the Admin Panel.
                </div>
            <?php 
            else:
                foreach ($case_studies as $cs):
            ?>
            <div class="case-card">
                <div class="case-header">
                    <div class="case-client">
                        <img src="<?php echo htmlspecialchars($cs['client_logo']); ?>" alt="<?php echo htmlspecialchars($cs['client_name']); ?>">
                    </div>
                    <div class="case-dest-badge badge-<?php echo htmlspecialchars($cs['badge_color']); ?>">
                        <span><?php echo htmlspecialchars($cs['badge_flag']); ?></span> <?php echo htmlspecialchars($cs['badge_text']); ?>
                    </div>
                </div>
                <div class="case-type"><?php echo htmlspecialchars($cs['case_type']); ?></div>
                <div class="case-stats">
                    <div>
                        <div class="case-stat-num"><?php 
                            $s1 = $cs['stat1_num'];
                            $num_s1 = preg_replace('/[^0-9.+-]/', '', $s1);
                            $suff_s1 = str_replace($num_s1, '', $s1);
                            echo htmlspecialchars($num_s1);
                        ?><span><?php echo htmlspecialchars($suff_s1); ?></span></div>
                        <div class="case-stat-label"><?php echo htmlspecialchars($cs['stat1_label']); ?></div>
                    </div>
                    <div>
                        <div class="case-stat-num"><?php 
                            $s2 = $cs['stat2_num'];
                            $num_s2 = preg_replace('/[^0-9.+-]/', '', $s2);
                            $suff_s2 = str_replace($num_s2, '', $s2);
                            echo htmlspecialchars($num_s2);
                        ?><span><?php echo htmlspecialchars($suff_s2); ?></span></div>
                        <div class="case-stat-label"><?php echo htmlspecialchars($cs['stat2_label']); ?></div>
                    </div>
                    <div>
                        <div class="case-stat-num"><?php 
                            $s3 = $cs['stat3_num'];
                            $num_s3 = preg_replace('/[^0-9.+-]/', '', $s3);
                            $suff_s3 = str_replace($num_s3, '', $s3);
                            echo htmlspecialchars($num_s3);
                        ?><span><?php echo htmlspecialchars($suff_s3); ?></span></div>
                        <div class="case-stat-label"><?php echo htmlspecialchars($cs['stat3_label']); ?></div>
                    </div>
                </div>
                <div class="case-outcome">
                    <strong>Outcome</strong>
                    <?php echo htmlspecialchars($cs['outcome']); ?>
                </div>
            </div>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how reveal-section" id="how">
        <div class="how-header">
            <div class="section-label"><?php echo htmlspecialchars(get_site_setting('how_label')); ?></div>
            <h2 class="section-title"><?php echo get_site_setting('how_title'); ?></h2>
            <p class="section-sub"><?php echo htmlspecialchars(get_site_setting('how_desc')); ?></p>
        </div>
        <div class="how-steps-container">
            <div class="how-step theme-orange">
                <div class="step-badge">1</div>
                <div class="step-icon-box">
                    <div class="step-icon"><i class="fa-solid fa-bullseye"></i></div>
                </div>
                <div class="step-text">
                    <h3><?php echo htmlspecialchars(get_site_setting('step1_title')); ?></h3>
                    <p><?php echo htmlspecialchars(get_site_setting('step1_desc')); ?></p>
                </div>
            </div>

            <div class="step-arrow">→</div>

            <div class="how-step theme-green">
                <div class="step-badge">2</div>
                <div class="step-icon-box">
                    <div class="step-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                </div>
                <div class="step-text">
                    <h3><?php echo htmlspecialchars(get_site_setting('step2_title')); ?></h3>
                    <p><?php echo htmlspecialchars(get_site_setting('step2_desc')); ?></p>
                </div>
            </div>

            <div class="step-arrow">→</div>

            <div class="how-step theme-purple">
                <div class="step-badge">3</div>
                <div class="step-icon-box">
                    <div class="step-icon"><i class="fa-solid fa-handshake-simple"></i></div>
                </div>
                <div class="step-text">
                    <h3><?php echo htmlspecialchars(get_site_setting('step3_title')); ?></h3>
                    <p><?php echo htmlspecialchars(get_site_setting('step3_desc')); ?></p>
                </div>
            </div>

            <div class="step-arrow">→</div>

            <div class="how-step theme-blue">
                <div class="step-badge">4</div>
                <div class="step-icon-box">
                    <div class="step-icon"><i class="fa-solid fa-plane-up"></i></div>
                </div>
                <div class="step-text">
                    <h3><?php echo htmlspecialchars(get_site_setting('step4_title')); ?></h3>
                    <p><?php echo htmlspecialchars(get_site_setting('step4_desc')); ?></p>
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
                    <span class="ai-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></span> ASK NORTH AI
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