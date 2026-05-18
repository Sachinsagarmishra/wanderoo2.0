<?php
/**
 * Global Utility Functions
 */
require_once __DIR__ . '/db.php';

// Automatic Table Setup and Seeding for About Us Page
try {
    // 1. Create table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `about_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `setting_key` varchar(255) NOT NULL UNIQUE,
        `setting_value` text DEFAULT NULL,
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 2. Check if table is empty
    $count = $pdo->query("SELECT COUNT(*) FROM `about_settings`")->fetchColumn();
    if ($count == 0) {
        // Seed default values matching exactly the current static about.php
        $default_settings = [
            // HERO
            'hero_bg' => 'assets/img/aboutusbg.png',
            'hero_label' => 'ABOUT WANDEROO',
            'hero_title' => 'Redefining Corporate<br>Travel Into <span class="accent">Performance-Led<br>Experiences.</span>',
            'hero_text' => 'We design incentive journeys that reward ambition, strengthen relationships, and drive measurable business outcomes across India and beyond.',
            
            // STATS BAR
            'stat1_val' => '500+',
            'stat1_label' => 'Trips Executed',
            'stat2_val' => '48K+',
            'stat2_label' => 'Happy Travellers',
            'stat3_val' => '250+',
            'stat3_label' => 'Enterprise Clients',
            'stat4_val' => '4.9/5',
            'stat4_label' => 'Average Rating',

            // STORY & MISSION
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

            // FOUNDER
            'founder_img' => 'assets/img/himanshu-cfounder.png',
            'founder_label' => 'FROM THE FOUNDER',
            'founder_title' => 'IIT-BHU Alumnus Disrupting<br>the Outdoors & Travel.',
            'founder_text1' => 'Hailing from the small village of Mewat in Haryana and a proud B.Tech graduate from IIT-BHU Varanasi, Himanshu Singla brings a unique blend of corporate strategy and raw passion for the wilderness to Wanderoo.',
            'founder_text2' => 'After three years at OYO Rooms, he chose to trade the corporate ladder for the mighty Himalayas. Since 2014, his journey from solo treks to leading wilderness communities has been driven by one goal: to create experiences that are as resilient as they are unforgettable.',
            'founder_name' => 'Himanshu Singla',
            'founder_title_sub' => 'Co-Founder, Wanderoo',
            'founder_quote' => 'We believe every high-performance team deserves experiences that reward their hard work and fuel their next milestone.',

            // WHY CHOOSE US
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

            // EXPERIENCE
            'exp_img' => 'assets/img/team-terrace.png',
            'exp_label' => '20 YEARS OF EXPERIENCE',
            'exp_title' => 'Two decades of creating<br>moments that matter.',
            'exp_text' => 'With 20+ years of combined experience in travel, events, and employee engagement, our leadership team brings excellence to every program.',
            'exp_point1' => 'Deep industry expertise',
            'exp_point2' => 'Strong vendor & partner network',
            'exp_point3' => 'Passionate team of travel experts',
            'exp_badge_num' => '20+',
            'exp_badge_text' => 'Years of combined<br>industry experience'
        ];

        $stmt = $pdo->prepare("INSERT INTO `about_settings` (`setting_key`, `setting_value`) VALUES (:key, :value)");
        foreach ($default_settings as $key => $value) {
            $stmt->execute(['key' => $key, 'value' => $value]);
        }
    }
} catch (PDOException $e) {
    // Graceful error logging or display
}

// Global cache variable
$about_settings_cache = null;

/**
 * Get setting value from database or fallback to default
 */
function get_about_setting($key, $default = '') {
    global $pdo, $about_settings_cache;

    if ($about_settings_cache === null) {
        $about_settings_cache = [];
        try {
            $stmt = $pdo->query("SELECT `setting_key`, `setting_value` FROM `about_settings`");
            while ($row = $stmt->fetch()) {
                $about_settings_cache[$row['setting_key']] = $row['setting_value'];
            }
        } catch (PDOException $e) {
            // Suppress fallback error
        }
    }

    return isset($about_settings_cache[$key]) ? $about_settings_cache[$key] : $default;
}
?>
