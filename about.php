<?php
$pageTitle = "About Us";
include_once 'includes/functions.php';
include_once 'includes/header.php';
?>

<main>
    <!-- ABOUT HERO -->
    <section class="about-hero reveal-section" style="background-image: url('<?php echo htmlspecialchars(get_about_setting('hero_bg', 'assets/img/aboutusbg.png')); ?>');">
        <div class="about-hero-container">
            <div class="about-hero-content">
                <div class="section-label"><?php echo htmlspecialchars(get_about_setting('hero_label', 'ABOUT WANDEROO')); ?></div>
                <h1><?php echo get_about_setting('hero_title', 'Redefining Corporate<br>Travel Into <span class="accent">Performance-Led<br>Experiences.</span>'); ?></h1>
                <p><?php echo htmlspecialchars(get_about_setting('hero_text', 'We design incentive journeys that reward ambition, strengthen relationships, and drive measurable business outcomes across India and beyond.')); ?></p>
                <div class="about-hero-actions">
                    <button class="btn-primary"><i class="fa-solid fa-play"></i> Watch Our Story</button>
                    <a href="#founder" class="btn-secondary">Our Journey →</a>
                </div>
            </div>

            <!-- STATS BAR INSIDE HERO -->
            <div class="stats-bar-wrapper">
                <div class="stats-bar-container">
                    <div class="stat-item">
                        <div class="stat-icon-circle theme-orange"><i class="fa-solid fa-plane-up"></i></div>
                        <div class="stat-text">
                            <h3><?php echo htmlspecialchars(get_about_setting('stat1_val', '500+')); ?></h3>
                            <p><?php echo htmlspecialchars(get_about_setting('stat1_label', 'Trips Executed')); ?></p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon-circle theme-green"><i class="fa-solid fa-users"></i></div>
                        <div class="stat-text">
                            <h3><?php echo htmlspecialchars(get_about_setting('stat2_val', '48K+')); ?></h3>
                            <p><?php echo htmlspecialchars(get_about_setting('stat2_label', 'Happy Travellers')); ?></p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon-circle theme-purple"><i class="fa-solid fa-building"></i></div>
                        <div class="stat-text">
                            <h3><?php echo htmlspecialchars(get_about_setting('stat3_val', '250+')); ?></h3>
                            <p><?php echo htmlspecialchars(get_about_setting('stat3_label', 'Enterprise Clients')); ?></p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon-circle theme-amber"><i class="fa-solid fa-star"></i></div>
                        <div class="stat-text">
                            <h3><?php echo htmlspecialchars(get_about_setting('stat4_val', '4.9/5')); ?></h3>
                            <p><?php echo htmlspecialchars(get_about_setting('stat4_label', 'Average Rating')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MISSION SECTION -->
    <section class="mission-section reveal-section">
        <div class="mission-container">
            <div class="mission-left">
                <div class="section-label"><?php echo htmlspecialchars(get_about_setting('mission_label', 'OUR STORY')); ?></div>
                <h2><?php echo get_about_setting('mission_title', 'Built on experience.<br>Driven by purpose.'); ?></h2>
                <p><?php echo htmlspecialchars(get_about_setting('mission_text1', 'Wanderoo was born out of a simple belief – that recognition should be more than just a token. It should be an experience people remember for a lifetime.')); ?></p>
                <p><?php echo htmlspecialchars(get_about_setting('mission_text2', 'What started as a small team of travel enthusiasts and strategy thinkers is now India\'s trusted incentive travel partner for high-performing teams and forward-thinking companies.')); ?></p>
            </div>
            <div class="mission-right">
                <div class="mission-list">
                    <div class="mission-item">
                        <div class="m-icon orange">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>
                        <div class="m-content">
                            <h4><?php echo htmlspecialchars(get_about_setting('mission1_title', 'Our Mission')); ?></h4>
                            <p><?php echo htmlspecialchars(get_about_setting('mission1_text', 'To make performance recognition more meaningful through seamless, well-crafted travel experiences.')); ?></p>
                        </div>
                    </div>
                    <div class="mission-item">
                        <div class="m-icon green">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <div class="m-content">
                            <h4><?php echo htmlspecialchars(get_about_setting('mission2_title', 'Our Vision')); ?></h4>
                            <p><?php echo htmlspecialchars(get_about_setting('mission2_text', 'To be the most trusted incentive travel platform for enterprises in India and APAC.')); ?></p>
                        </div>
                    </div>
                    <div class="mission-item">
                        <div class="m-icon purple">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="m-content">
                            <h4><?php echo htmlspecialchars(get_about_setting('mission3_title', 'Our Promise')); ?></h4>
                            <p><?php echo htmlspecialchars(get_about_setting('mission3_text', 'End-to-end execution. Zero hassle. Maximum impact.')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOUNDER SECTION -->
    <section id="founder" class="founder-section reveal-section">
        <div class="founder-container">
            <div class="founder-image">
                <img src="<?php echo htmlspecialchars(get_about_setting('founder_img', 'assets/img/himanshu-cfounder.png')); ?>" alt="<?php echo htmlspecialchars(get_about_setting('founder_name', 'Himanshu Singla')); ?>">
            </div>
            <div class="founder-content">
                <div class="section-label"><?php echo htmlspecialchars(get_about_setting('founder_label', 'FROM THE FOUNDER')); ?></div>
                <h3><?php echo get_about_setting('founder_title', 'IIT-BHU Alumnus Disrupting<br>the Outdoors & Travel.'); ?></h3>
                <p><?php echo get_about_setting('founder_text1', 'Hailing from the small village of Mewat in Haryana and a proud B.Tech graduate from <strong>IIT-BHU Varanasi</strong>, Himanshu Singla brings a unique blend of corporate strategy and raw passion for the wilderness to Wanderoo.'); ?></p>
                <p><?php echo get_about_setting('founder_text2', 'After three years at OYO Rooms, he chose to trade the corporate ladder for the mighty Himalayas. Since 2014, his journey from solo treks to leading wilderness communities has been driven by one goal: to create experiences that are as resilient as they are unforgettable.'); ?></p>
                <div class="founder-signature-block">
                    <div class="f-info">
                        <strong><?php echo htmlspecialchars(get_about_setting('founder_name', 'Himanshu Singla')); ?></strong>
                        <span><?php echo htmlspecialchars(get_about_setting('founder_title_sub', 'Co-Founder, Wanderoo')); ?></span>
                    </div>
                </div>
            </div>
            <div class="founder-quote">
                <div class="quote-icon">“</div>
                <p><?php echo htmlspecialchars(get_about_setting('founder_quote', 'We believe every high-performance team deserves experiences that reward their hard work and fuel their next milestone.')); ?></p>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="why-choose-section reveal-section">
        <div class="why-choose-header">
            <div class="section-label"><?php echo htmlspecialchars(get_about_setting('why_label', 'WHY COMPANIES CHOOSE WANDEROO')); ?></div>
            <h2><?php echo htmlspecialchars(get_about_setting('why_title', 'We go beyond travel. We drive outcomes.')); ?></h2>
        </div>
        <div class="why-choose-grid">
            <div class="choice-card theme-orange">
                <div class="c-icon"><i class="fa-solid fa-trophy"></i></div>
                <h4><?php echo htmlspecialchars(get_about_setting('card1_title', 'Performance-First Approach')); ?></h4>
                <p><?php echo htmlspecialchars(get_about_setting('card1_text', 'Every trip is designed to inspire, motivate and reward performance.')); ?></p>
            </div>
            <div class="choice-card theme-green">
                <div class="c-icon"><i class="fa-solid fa-handshake"></i></div>
                <h4><?php echo htmlspecialchars(get_about_setting('card2_title', 'End-to-End Execution')); ?></h4>
                <p><?php echo htmlspecialchars(get_about_setting('card2_text', 'From planning to on-ground support – we handle everything.')); ?></p>
            </div>
            <div class="choice-card theme-purple">
                <div class="c-icon"><i class="fa-solid fa-gem"></i></div>
                <h4><?php echo htmlspecialchars(get_about_setting('card3_title', 'Curated Experiences')); ?></h4>
                <p><?php echo htmlspecialchars(get_about_setting('card3_text', 'Handpicked destinations, hotels and activities that create lasting impact.')); ?></p>
            </div>
            <div class="choice-card theme-blue">
                <div class="c-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                <h4><?php echo htmlspecialchars(get_about_setting('card4_title', 'Transparent & Reliable')); ?></h4>
                <p><?php echo htmlspecialchars(get_about_setting('card4_text', 'Clear pricing, no surprises, and 24/7 support you can count on.')); ?></p>
            </div>
            <div class="choice-card theme-rose">
                <div class="c-icon"><i class="fa-solid fa-user-check"></i></div>
                <h4><?php echo htmlspecialchars(get_about_setting('card5_title', 'Trusted by Leaders')); ?></h4>
                <p><?php echo htmlspecialchars(get_about_setting('card5_text', 'Preferred partner for India\'s top-performing teams and enterprises.')); ?></p>
            </div>
        </div>
    </section>

    <!-- EXPERIENCE SECTION -->
    <section class="experience-section reveal-section">
        <div class="exp-container">
            <div class="exp-image">
                <img src="<?php echo htmlspecialchars(get_about_setting('exp_img', 'assets/img/team-terrace.png')); ?>" alt="Team Experience">
            </div>
            <div class="exp-content-wrapper">
                <div class="exp-text-block">
                    <div class="section-label"><?php echo htmlspecialchars(get_about_setting('exp_label', '20 YEARS OF EXPERIENCE')); ?></div>
                    <h2><?php echo get_about_setting('exp_title', 'Two decades of creating<br>moments that matter.'); ?></h2>
                    <p><?php echo htmlspecialchars(get_about_setting('exp_text', 'With 20+ years of combined experience in travel, events, and employee engagement, our leadership team brings excellence to every program.')); ?></p>
                </div>
                <ul class="exp-list">
                    <li><i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars(get_about_setting('exp_point1', 'Deep industry expertise')); ?></li>
                    <li><i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars(get_about_setting('exp_point2', 'Strong vendor & partner network')); ?></li>
                    <li><i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars(get_about_setting('exp_point3', 'Passionate team of travel experts')); ?></li>
                </ul>
                <div class="exp-badge">
                    <div class="badge-num"><?php echo htmlspecialchars(get_about_setting('exp_badge_num', '20+')); ?></div>
                    <div class="badge-text"><?php echo get_about_setting('exp_badge_text', 'Years of combined<br>industry experience'); ?></div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once 'includes/footer.php'; ?>
