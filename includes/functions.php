<?php
/**
 * Global Utility Functions & Dynamic Site Settings
 */
require_once __DIR__ . '/db.php';

// Global cache variable
$site_settings_cache = null;

// Prepare all default settings globally for fallback access
$default_settings = [
    // ABOUT HERO
    'hero_bg' => 'assets/img/aboutusbg.png',
    'hero_label' => 'ABOUT WANDEROO',
    'hero_title' => 'Redefining Corporate<br>Travel Into <span class="accent">Performance-Led<br>Experiences.</span>',
    'hero_text' => 'We design incentive journeys that reward ambition, strengthen relationships, and drive measurable business outcomes across India and beyond.',
    
    // ABOUT STATS BAR
    'stat1_val' => '500+',
    'stat1_label' => 'Trips Executed',
    'stat2_val' => '48K+',
    'stat2_label' => 'Happy Travellers',
    'stat3_val' => '250+',
    'stat3_label' => 'Enterprise Clients',
    'stat4_val' => '4.9/5',
    'stat4_label' => 'Average Rating',

    // ABOUT STORY & MISSION
    'mission_label' => 'OUR STORY',
    'mission_title' => 'Built on experience.<br>Driven by purpose.',
    'mission_text1' => 'Wanderoo was born out of a simple belief – that recognition should be more than just a token. It should be an experience people remember for a lifetime.',
    'mission_text2' => 'What started as a small team of travel enthusiasts and strategy thinkers is now India\'s trusted incentive travel partner for high-performing teams and forward-thinking companies.',
    'mission1_title' => 'Our Mission',
    'mission1_text' => 'To make performance recognition more meaningful through seamless, well-crafted travel experiences.',
    'mission2_title' => 'Our Vision',
    'mission2_text' => 'To be the most trusted incentive travel platform for enterprises in India and APAC.',
    'mission3_title' => 'Our Promise',
    'mission3_text' => 'End-to-end execution. Zero hassle. Maximum impact.',

    // ABOUT FOUNDER
    'founder_img' => 'assets/img/himanshu-cfounder.png',
    'founder_label' => 'FROM THE FOUNDER',
    'founder_title' => 'IIT-BHU Alumnus Disrupting<br>the Outdoors & Travel.',
    'founder_text1' => 'Hailing from the small village of Mewat in Haryana and a proud B.Tech graduate from IIT-BHU Varanasi, Himanshu Singla brings a unique blend of corporate strategy and raw passion for the wilderness to Wanderoo.',
    'founder_text2' => 'After three years at OYO Rooms, he chose to trade the corporate ladder for the mighty Himalayas. Since 2014, his journey from solo treks to leading wilderness communities has been driven by one goal: to create experiences that are as resilient as they are unforgettable.',
    'founder_name' => 'Himanshu Singla',
    'founder_title_sub' => 'Co-Founder, Wanderoo',
    'founder_quote' => 'We believe every high-performance team deserves experiences that reward their hard work and fuel their next milestone.',

    // ABOUT WHY CHOOSE US
    'why_label' => 'WHY COMPANIES CHOOSE WANDEROO',
    'why_title' => 'We go beyond travel. We drive outcomes.',
    'card1_title' => 'Performance-First Approach',
    'card1_text' => 'Every trip is designed to inspire, motivate and reward performance.',
    'card2_title' => 'End-to-End Execution',
    'card2_text' => 'From planning to on-ground support – we handle everything.',
    'card3_title' => 'Curated Experiences',
    'card3_text' => 'Handpicked destinations, hotels and activities that create lasting impact.',
    'card4_title' => 'Transparent & Reliable',
    'card4_text' => 'Clear pricing, no surprises, and 24/7 support you can count on.',
    'card5_title' => 'Trusted by Leaders',
    'card5_text' => 'Preferred partner for India\'s top-performing teams and enterprises.',

    // ABOUT EXPERIENCE
    'exp_img' => 'assets/img/team-terrace.png',
    'exp_label' => '20 YEARS OF EXPERIENCE',
    'exp_title' => 'Two decades of creating<br>moments that matter.',
    'exp_text' => 'With 20+ years of combined experience in travel, events, and employee engagement, our leadership team brings excellence to every program.',
    'exp_point1' => 'Deep industry expertise',
    'exp_point2' => 'Strong vendor & partner network',
    'exp_point3' => 'Passionate team of travel experts',
    'exp_badge_num' => '20+',
    'exp_badge_text' => 'Years of combined<br>industry experience',

    // NEW GLOBAL WEBSITE SETTINGS
    'whatsapp_number' => '919113515462',
    'site_phone' => '+91 91135 15462',
    'site_email' => 'info@wanderoo.in',
    'social_linkedin' => '#',
    'social_instagram' => '#',
    'social_facebook' => '#',
    'social_youtube' => '#',
    'header_scripts' => '<!-- Custom Header Scripts (Google Analytics, Search Console, etc.) -->',
    'footer_scripts' => '<!-- Custom Footer Scripts (Marketing Pixels, Chatbots, etc.) -->',

    // DESTINATIONS HERO
    'dest_hero_label' => 'DESTINATIONS',
    'dest_hero_title' => 'Extraordinary places.<br><span class="accent">Meaningful impact.</span>',
    'dest_hero_desc' => 'From vibrant cities to serene escapes, we bring you the world\'s most inspiring destinations — curated for performance, connection, and unforgettable experiences.',
    'dest_hero_img' => 'assets/img/dest-hero-main.png',
    'dest_hero_badge' => 'Curated with expertise. Delivered with precision.',
    
    // REGIONS TITLE
    'dest_region_title' => 'Explore by Region',
    
    // REGION 1 SEA
    'region1_img' => 'assets/img/cat-sea.png',
    'region1_index' => '01',
    'region1_title' => 'South East<br>Asia',
    'region1_desc' => 'The ultimate blend of tropical retreats, vibrant street food, and high-energy cities for team bonding.',
    'region1_meta' => '5 TO 7 DAYS · 20 TO 100 PAX · FLIGHTS & VISAS HANDLED',

    // REGION 2 EUROPE
    'region2_img' => 'assets/img/cat-europe.png',
    'region2_index' => '02',
    'region2_title' => 'Europe',
    'region2_desc' => 'Old-world charm meets modern work culture. From Swiss Alps to Mediterranean escapes.',
    'region2_meta' => '7 TO 10 DAYS · 15 TO 40 PAX · LUXURY STAYS',

    // REGION 3 DOMESTIC
    'region3_img' => 'assets/img/cat-domestic.png',
    'region3_index' => '03',
    'region3_title' => 'Domestic',
    'region3_desc' => 'Uncover the gems closer to home. Mountain retreats, coastal escapes, and heritage stays.',
    'region3_meta' => '3 TO 5 DAYS · 30 TO 200 PAX · 12 DESTINATIONS',

    // WHY TITLE & DETAILS
    'dest_why_title' => 'Why Our Destinations Deliver More',
    
    // CTA TITLE & DETAILS
    'dest_cta_title' => 'Not sure where to go?<br>We\'ll help you find the perfect fit.',
    'dest_cta_desc' => 'Share your goals and we\'ll recommend destinations that align with your team, budget and objectives.'
];

// Automatic Table Setup and Seeding for Site Settings
try {
    // 1. Backward compatibility: Rename about_settings to site_settings if exists (Standard MySQL Syntax, NO CASCADE)
    $table_check = $pdo->query("SHOW TABLES LIKE 'about_settings'")->fetch();
    $site_table_check = $pdo->query("SHOW TABLES LIKE 'site_settings'")->fetch();
    
    if ($table_check && !$site_table_check) {
        $pdo->exec("RENAME TABLE `about_settings` TO `site_settings`;");
    }

    // 2. Create site_settings table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `site_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `setting_key` varchar(255) NOT NULL UNIQUE,
        `setting_value` text DEFAULT NULL,
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 3. Seed missing items in site_settings
    $stmt = $pdo->prepare("INSERT IGNORE INTO `site_settings` (`setting_key`, `setting_value`) VALUES (:key, :value)");
    foreach ($default_settings as $key => $value) {
        $stmt->execute(['key' => $key, 'value' => $value]);
    }

    // 4. Create destinations list table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `destinations` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `duration` varchar(100) DEFAULT NULL,
        `description` text DEFAULT NULL,
        `image_path` varchar(255) DEFAULT NULL,
        `tags` varchar(255) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Seed default destinations if table is empty
    $dest_count = $pdo->query("SELECT COUNT(*) FROM `destinations`")->fetchColumn();
    if ($dest_count == 0) {
        $stmt_dest = $pdo->prepare("INSERT INTO `destinations` (`title`, `duration`, `description`, `image_path`, `tags`) VALUES (:title, :duration, :description, :image_path, :tags)");
        
        $default_dests = [
            [
                'title' => 'Bali, Indonesia',
                'duration' => '4N / 5D',
                'description' => 'Perfect blend of relaxation and cultural immersion.',
                'image_path' => 'assets/img/dest/bali.png',
                'tags' => 'Beach, Culture, Wellness'
            ],
            [
                'title' => 'Phuket, Thailand',
                'duration' => '4N / 5D',
                'description' => 'Tropical paradise with luxury resorts and exciting activities.',
                'image_path' => 'assets/img/dest/phuket.png',
                'tags' => 'Beach, Adventure, Nightlife'
            ],
            [
                'title' => 'Swiss Alps, Switzerland',
                'duration' => '5N / 6D',
                'description' => 'Breathtaking landscapes and world-class experiences.',
                'image_path' => 'assets/img/dest/swiss.png',
                'tags' => 'Mountains, Adventure, Luxury'
            ],
            [
                'title' => 'Barcelona, Spain',
                'duration' => '4N / 5D',
                'description' => 'Vibrant city, iconic architecture and Mediterranean charm.',
                'image_path' => 'assets/img/dest/barcelona.png',
                'tags' => 'Culture, Food, Architecture'
            ],
            [
                'title' => 'Goa, India',
                'duration' => '3N / 4D',
                'description' => 'Sun, sand and soulful experiences for teams.',
                'image_path' => 'assets/img/dest/goa.png',
                'tags' => 'Beach, Leisure, Fun'
            ]
        ];

        foreach ($default_dests as $d) {
            $stmt_dest->execute($d);
        }
    }
} catch (PDOException $e) {
    // Graceful fallback
}

/**
 * Get setting value from site_settings database
 */
function get_site_setting($key, $default = '') {
    global $pdo, $site_settings_cache, $default_settings;

    if ($site_settings_cache === null) {
        $site_settings_cache = [];
        try {
            $stmt = $pdo->query("SELECT `setting_key`, `setting_value` FROM `site_settings`");
            while ($row = $stmt->fetch()) {
                $site_settings_cache[$row['setting_key']] = $row['setting_value'];
            }
        } catch (PDOException $e) {
            // Suppress fallback error
        }
    }

    // 1. Return from DB cache if available
    if (isset($site_settings_cache[$key])) {
        return $site_settings_cache[$key];
    }
    
    // 2. Fall back to hardcoded default settings array
    if (isset($default_settings[$key])) {
        return $default_settings[$key];
    }

    return $default;
}

/**
 * Fetch all dynamic destination cards
 */
function get_all_destinations() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM `destinations` ORDER BY `id` DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Wrapper for backward compatibility with about page
 */
function get_about_setting($key, $default = '') {
    return get_site_setting($key, $default);
}
?>
