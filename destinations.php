<?php
$pageTitle = "Explore Destinations";
include_once 'includes/header.php';
?>

<main>
    <!-- DESTINATIONS HERO -->
    <section class="dest-hero reveal-section">
        <div class="dest-hero-container">
            <div class="dest-hero-left">
                <div class="section-label"><?php echo htmlspecialchars(get_site_setting('dest_hero_label')); ?></div>
                <h1><?php echo get_site_setting('dest_hero_title'); ?></h1>
                <p><?php echo htmlspecialchars(get_site_setting('dest_hero_desc')); ?></p>
                <div class="dest-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="destSearchInput" placeholder="Search destinations, cities or countries" onkeyup="filterDestinations()">
                </div>
            </div>
            <div class="dest-hero-right">
                <div class="hero-image-wrapper">
                    <img src="<?php echo htmlspecialchars(get_site_setting('dest_hero_img')); ?>" alt="Tropical Resort">
                    <div class="hero-image-badge">
                        <div class="badge-icon-bg"><i class="fa-solid fa-award"></i></div>
                        <span><?php echo htmlspecialchars(get_site_setting('dest_hero_badge')); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- EXPLORE BY REGION (Bento Grid) -->
    <section class="category-section reveal-section" id="destinations">
        <h2 class="section-title centered" style="margin-bottom: 50px;"><?php echo htmlspecialchars(get_site_setting('dest_region_title')); ?></h2>
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
                    <a href="#" class="cat-open">OPEN →</a>
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
                        <a href="#" class="cat-open">OPEN →</a>
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

            <div class="dest-card-grid" id="destinationsCardGrid">
                <?php 
                $dest_cards = get_all_destinations();
                if (empty($dest_cards)):
                ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--fg2);">
                        <i class="fa-solid fa-map-location-dot" style="font-size: 48px; margin-bottom: 15px; display: block; color: var(--accent);"></i>
                        No destinations found. Please add some from the Admin Panel.
                    </div>
                <?php 
                else:
                    foreach ($dest_cards as $dest):
                        $tags_arr = array_map('trim', explode(',', $dest['tags']));
                        
                        $tag_icon_map = [
                            'beach' => 'fa-umbrella-beach',
                            'culture' => 'fa-masks-theater',
                            'wellness' => 'fa-spa',
                            'adventure' => 'fa-person-hiking',
                            'nightlife' => 'fa-martini-glass-citrus',
                            'mountains' => 'fa-mountain',
                            'luxury' => 'fa-gem',
                            'food' => 'fa-utensils',
                            'architecture' => 'fa-archway',
                            'leisure' => 'fa-cocktail',
                            'fun' => 'fa-face-smile'
                        ];
                ?>
                <div class="dest-card" data-title="<?php echo htmlspecialchars(strtolower($dest['title'])); ?>" data-desc="<?php echo htmlspecialchars(strtolower($dest['description'])); ?>">
                    <div class="d-img">
                        <img src="<?php echo htmlspecialchars($dest['image_path']); ?>" alt="<?php echo htmlspecialchars($dest['title']); ?>">
                    </div>
                    <div class="d-content">
                        <div class="d-meta">
                            <h4><?php echo htmlspecialchars($dest['title']); ?></h4>
                            <span class="duration"><?php echo htmlspecialchars($dest['duration']); ?></span>
                        </div>
                        <p><?php echo htmlspecialchars($dest['description']); ?></p>
                        <div class="d-tags">
                            <?php foreach ($tags_arr as $t): 
                                if (empty($t)) continue;
                                $lower_t = strtolower($t);
                                $icon_class = isset($tag_icon_map[$lower_t]) ? $tag_icon_map[$lower_t] : 'fa-tag';
                            ?>
                                <span><i class="fa-solid <?php echo $icon_class; ?>"></i> <?php echo htmlspecialchars($t); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <a href="#" class="btn-explore">Explore</a>
                    </div>
                </div>
                <?php 
                    endforeach; 
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- WHY OUR DESTINATIONS -->
    <section class="why-dest-section reveal-section">
        <div class="section-container why-dest-flex">
            <div class="why-dest-left">
                <h2 class="why-title"><?php echo htmlspecialchars(get_site_setting('dest_why_title')); ?></h2>
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
            
            <div class="logo-marquee-wrapper">
                <div class="logo-marquee-content">
                    <!-- Logo set 1 -->
                    <img src="assets/img/logos/dunzo.svg" alt="Dunzo">
                    <img src="assets/img/logos/tata1mg.svg" alt="TATA 1mg">
                    <img src="assets/img/logos/videocon.svg" alt="Videocon">
                    <img src="assets/img/logos/isb.svg" alt="ISB">
                    <img src="assets/img/logos/dunzo.svg" alt="Dunzo">
                    <img src="assets/img/logos/tata1mg.svg" alt="TATA 1mg">
                    <img src="assets/img/logos/videocon.svg" alt="Videocon">
                    <img src="assets/img/logos/isb.svg" alt="ISB">
                    <!-- Logo set 2 -->
                    <img src="assets/img/logos/dunzo.svg" alt="Dunzo">
                    <img src="assets/img/logos/tata1mg.svg" alt="TATA 1mg">
                    <img src="assets/img/logos/videocon.svg" alt="Videocon">
                    <img src="assets/img/logos/isb.svg" alt="ISB">
                    <img src="assets/img/logos/dunzo.svg" alt="Dunzo">
                    <img src="assets/img/logos/tata1mg.svg" alt="TATA 1mg">
                    <img src="assets/img/logos/videocon.svg" alt="Videocon">
                    <img src="assets/img/logos/isb.svg" alt="ISB">
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
                    <h3><?php echo get_site_setting('dest_cta_title'); ?></h3>
                    <p><?php echo htmlspecialchars(get_site_setting('dest_cta_desc')); ?></p>
                </div>
                <button class="btn-primary" onclick="window.open('https://wa.me/<?php echo htmlspecialchars(get_site_setting('whatsapp_number', '919113515462')); ?>', '_blank')">Talk to an Expert →</button>
            </div>
        </div>
    </section>
</main>

<script>
function filterDestinations() {
    const input = document.getElementById('destSearchInput').value.toLowerCase();
    const cards = document.querySelectorAll('#destinationsCardGrid .dest-card');
    
    cards.forEach(card => {
        const title = card.getAttribute('data-title') || '';
        const desc = card.getAttribute('data-desc') || '';
        if (title.includes(input) || desc.includes(input)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

<?php include_once 'includes/footer.php'; ?>
