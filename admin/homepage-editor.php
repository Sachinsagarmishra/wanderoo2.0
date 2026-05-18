<?php
/**
 * Homepage Content and Case Studies CRUD Editor
 */
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/header.php'; // This also triggers authentication check

$success_msg = '';
$error_msg = '';

// Helper to handle image uploads safely
function upload_homepage_image($file_key, $setting_key, $prefix) {
    global $pdo, $error_msg;
    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES[$file_key]['tmp_name'];
        $orig_name = $_FILES[$file_key]['name'];
        $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png', 'svg', 'webp', 'gif'];
        if (!in_array($ext, $allowed)) {
            $error_msg .= "Invalid extension for $file_key. Allowed: " . implode(', ', $allowed) . ". ";
            return false;
        }

        // Generate clean name and path
        $new_name = $prefix . '_' . time() . '.' . $ext;
        $dest_dir = __DIR__ . '/../assets/img/';
        
        // Ensure path exists
        if (!is_dir($dest_dir)) {
            mkdir($dest_dir, 0755, true);
        }
        
        $dest_path = $dest_dir . $new_name;

        if (move_uploaded_file($tmp_name, $dest_path)) {
            $db_path = 'assets/img/' . $new_name;
            $stmt = $pdo->prepare("UPDATE site_settings SET setting_value = :val WHERE setting_key = :key");
            $stmt->execute(['val' => $db_path, 'key' => $setting_key]);
            return $db_path;
        } else {
            $error_msg .= "Failed to save uploaded file for $file_key. ";
            return false;
        }
    }
    return false;
}

// Case Study Image uploader
function upload_case_logo($file_key) {
    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES[$file_key]['tmp_name'];
        $orig_name = $_FILES[$file_key]['name'];
        $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png', 'svg', 'webp', 'gif'];
        if (in_array($ext, $allowed)) {
            $new_name = 'case_logo_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $dest_dir = __DIR__ . '/../assets/img/logos/';
            if (!is_dir($dest_dir)) {
                mkdir($dest_dir, 0755, true);
            }
            $dest_path = $dest_dir . $new_name;
            if (move_uploaded_file($tmp_name, $dest_path)) {
                return 'assets/img/logos/' . $new_name;
            }
        }
    }
    return null;
}

// Handle GET Delete Case Study
if (isset($_GET['delete_case_id'])) {
    $delete_id = intval($_GET['delete_case_id']);
    try {
        $stmt = $pdo->prepare("DELETE FROM `case_studies` WHERE `id` = :id");
        $stmt->execute(['id' => $delete_id]);
        header("Location: homepage-editor.php?success=Case study deleted successfully&tab=tab-case");
        exit;
    } catch (PDOException $e) {
        $error_msg = "Delete failed: " . $e->getMessage();
    }
}

// Success message forwarded via redirects
if (isset($_GET['success'])) {
    $success_msg = htmlspecialchars($_GET['success']);
}

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. DYNAMIC CASE STUDIES CRUD ACTIONS
    if (isset($_POST['action']) && $_POST['action'] === 'add_case') {
        try {
            $logo_path = upload_case_logo('client_logo_file');
            if (!$logo_path) {
                $logo_path = 'assets/img/logos/dunzo.svg'; // Default fallback
            }

            $stmt = $pdo->prepare("INSERT INTO `case_studies` 
            (client_name, client_logo, badge_text, badge_flag, badge_color, case_type, stat1_num, stat1_label, stat2_num, stat2_label, stat3_num, stat3_label, outcome) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->execute([
                $_POST['client_name'],
                $logo_path,
                $_POST['badge_text'],
                $_POST['badge_flag'],
                $_POST['badge_color'],
                $_POST['case_type'],
                $_POST['stat1_num'],
                $_POST['stat1_label'],
                $_POST['stat2_num'],
                $_POST['stat2_label'],
                $_POST['stat3_num'],
                $_POST['stat3_label'],
                $_POST['outcome']
            ]);

            header("Location: homepage-editor.php?success=New case study added successfully&tab=tab-case");
            exit;
        } catch (PDOException $e) {
            $error_msg = "Failed to add case study: " . $e->getMessage();
        }
    }
    elseif (isset($_POST['action']) && $_POST['action'] === 'edit_case') {
        try {
            $case_id = intval($_POST['case_id']);
            
            // Check if user uploaded a new logo file
            $logo_path = upload_case_logo('client_logo_file');
            
            if ($logo_path) {
                $stmt = $pdo->prepare("UPDATE `case_studies` SET 
                    client_name = ?, client_logo = ?, badge_text = ?, badge_flag = ?, badge_color = ?, case_type = ?, 
                    stat1_num = ?, stat1_label = ?, stat2_num = ?, stat2_label = ?, stat3_num = ?, stat3_label = ?, outcome = ?
                    WHERE id = ?");
                $stmt->execute([
                    $_POST['client_name'],
                    $logo_path,
                    $_POST['badge_text'],
                    $_POST['badge_flag'],
                    $_POST['badge_color'],
                    $_POST['case_type'],
                    $_POST['stat1_num'],
                    $_POST['stat1_label'],
                    $_POST['stat2_num'],
                    $_POST['stat2_label'],
                    $_POST['stat3_num'],
                    $_POST['stat3_label'],
                    $_POST['outcome'],
                    $case_id
                ]);
            } else {
                $stmt = $pdo->prepare("UPDATE `case_studies` SET 
                    client_name = ?, badge_text = ?, badge_flag = ?, badge_color = ?, case_type = ?, 
                    stat1_num = ?, stat1_label = ?, stat2_num = ?, stat2_label = ?, stat3_num = ?, stat3_label = ?, outcome = ?
                    WHERE id = ?");
                $stmt->execute([
                    $_POST['client_name'],
                    $_POST['badge_text'],
                    $_POST['badge_flag'],
                    $_POST['badge_color'],
                    $_POST['case_type'],
                    $_POST['stat1_num'],
                    $_POST['stat1_label'],
                    $_POST['stat2_num'],
                    $_POST['stat2_label'],
                    $_POST['stat3_num'],
                    $_POST['stat3_label'],
                    $_POST['outcome'],
                    $case_id
                ]);
            }

            header("Location: homepage-editor.php?success=Case study updated successfully&tab=tab-case");
            exit;
        } catch (PDOException $e) {
            $error_msg = "Failed to update case study: " . $e->getMessage();
        }
    }
    
    // 2. STATIC HOMEPAGE CONTENT UPDATES
    elseif (isset($_POST['action']) && $_POST['action'] === 'save_homepage_settings') {
        $settings_to_update = [
            // HERO
            'home_hero_badge', 'home_hero_title', 'home_hero_desc',
            'home_stat1_num', 'home_stat1_label',
            'home_stat2_num', 'home_stat2_label',
            'home_stat3_num', 'home_stat3_label',
            
            // SOLUTIONS
            'home_solutions_label', 'home_solutions_title', 'home_solutions_desc',
            'sol1_title', 'sol1_desc', 'sol1_tag',
            'sol2_title', 'sol2_desc', 'sol2_tag',
            'sol3_title', 'sol3_desc', 'sol3_tag',
            'sol4_title', 'sol4_desc', 'sol4_tag',
            
            // WHY US
            'home_why_label', 'home_why_title', 'home_why_desc',
            'comp_p1', 'comp_w1',
            'comp_p2', 'comp_w2',
            'comp_p3', 'comp_w3',
            'comp_p4', 'comp_w4',
            
            // METRICS
            'metric1_num', 'metric1_desc',
            'metric2_num', 'metric2_desc',
            'metric3_num', 'metric3_desc',
            
            // HOW IT WORKS
            'how_label', 'how_title', 'how_desc',
            'step1_title', 'step1_desc',
            'step2_title', 'step2_desc',
            'step3_title', 'step3_desc',
            'step4_title', 'step4_desc',
        ];

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("UPDATE site_settings SET setting_value = :val WHERE setting_key = :key");
            
            foreach ($settings_to_update as $key) {
                if (isset($_POST[$key])) {
                    $stmt->execute([
                        'val' => $_POST[$key],
                        'key' => $key
                    ]);
                }
            }

            // Solutions Image uploads
            upload_homepage_image('sol1_img_file', 'sol1_img', 'sol1_icon');
            upload_homepage_image('sol2_img_file', 'sol2_img', 'sol2_icon');
            upload_homepage_image('sol3_img_file', 'sol3_img', 'sol3_icon');
            upload_homepage_image('sol4_img_file', 'sol4_img', 'sol4_icon');

            $pdo->commit();
            $success_msg = "Homepage static settings updated successfully!";
            
            // Invalidate global settings cache
            $site_settings_cache = null;
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error_msg = "Homepage settings update failed: " . $e->getMessage();
        }
    }
}

// Fetch active tab
$active_tab = isset($_GET['tab']) ? htmlspecialchars($_GET['tab']) : 'tab-hero';
?>

<style>
    /* Styling adjustments specifically for editor pages */
    .editor-container {
        max-width: 1100px;
        margin: 0 auto;
        padding-bottom: 50px;
    }
    .editor-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 15px;
    }
    .editor-header h1 {
        margin-bottom: 0;
    }
    .btn-save {
        background: var(--accent);
        color: #FFFFFF;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-save:hover {
        background: var(--accent2);
        transform: translateY(-1px);
    }
    .alert {
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 14px;
    }
    .alert-success {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
        color: #15803d;
    }
    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #b91c1c;
    }
    
    /* Elegant Tab Control */
    .tab-nav {
        display: flex;
        gap: 8px;
        margin-bottom: 25px;
        border-bottom: 2px solid var(--bg3);
        padding-bottom: 2px;
        overflow-x: auto;
    }
    .tab-btn {
        background: none;
        border: none;
        padding: 12px 20px;
        font-weight: 600;
        color: var(--fg2);
        cursor: pointer;
        font-family: var(--font-body);
        font-size: 14px;
        border-radius: 8px 8px 0 0;
        transition: all 0.2s;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        white-space: nowrap;
    }
    .tab-btn:hover {
        color: var(--accent);
        background: var(--bg2);
    }
    .tab-btn.active {
        color: var(--accent);
        border-bottom: 2px solid var(--accent);
        background: var(--bg);
    }
    
    /* Form Sections layout */
    .editor-section {
        display: none;
    }
    .editor-section.active {
        display: block;
    }
    .form-card {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-main);
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 5%), 0 2px 4px -2px rgb(0 0 0 / 5%);
    }
    .form-card-title {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        color: var(--fg);
        margin-bottom: 20px;
        border-bottom: 1px solid var(--bg3);
        padding-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group:last-child {
        margin-bottom: 0;
    }
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--fg);
        margin-bottom: 8px;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: var(--radius-int);
        font-family: var(--font-body);
        font-size: 14px;
        background: var(--bg);
        color: var(--fg);
        transition: border-color 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--accent);
    }
    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
    
    /* Image Uploader previews */
    .image-uploader-wrapper {
        display: flex;
        gap: 20px;
        align-items: center;
        background: var(--bg2);
        padding: 16px;
        border-radius: var(--radius-int);
        border: 1px dashed var(--border);
    }
    .image-preview {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: contain;
        border: 1px solid var(--border);
        background: #f1f5f9;
        padding: 4px;
    }
    .upload-info {
        flex: 1;
    }
    .upload-info p {
        font-size: 11px;
        color: var(--fg2);
        margin-top: 4px;
    }

    /* CRUD Listing style */
    .crud-table {
        width: 100%;
        border-collapse: collapse;
    }
    .crud-table th, .crud-table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }
    .crud-table th {
        background: var(--bg2);
        font-weight: 700;
        font-size: 13px;
    }
    .crud-table td {
        font-size: 13px;
        vertical-align: middle;
    }
    .badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 11px;
    }
    .badge-orange { background: #FFF7ED; color: #F97316; }
    .badge-green { background: #F0FDF4; color: #22C55E; }
    .badge-red { background: #FEF2F2; color: #EF4444; }
    .badge-purple { background: #FAF5FF; color: #A855F7; }

    .btn-edit {
        background: #F1F5F9;
        color: #334155;
        border: 1px solid #CBD5E1;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        margin-right: 5px;
        cursor: pointer;
    }
    .btn-edit:hover {
        background: #E2E8F0;
    }
    .btn-delete {
        background: #FEF2F2;
        color: #EF4444;
        border: 1px solid #FCA5A5;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-delete:hover {
        background: #FEE2E2;
    }
</style>

<div class="editor-container">
    <div class="editor-header">
        <div>
            <h1>Homepage Editor Workspace</h1>
            <p style="color: var(--fg2); font-size: 13px; margin-top: 4px;">Dynamic Content Management System (CMS) for Wanderoo's Main Landing Page.</p>
        </div>
        <?php if ($active_tab !== 'tab-case'): ?>
            <button type="submit" form="homepageForm" class="btn-save">
                <i class="fa-solid fa-floppy-disk"></i> Save All Changes
            </button>
        <?php endif; ?>
    </div>

    <?php if (!empty($success_msg)): ?>
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error_msg)): ?>
        <div class="alert alert-danger">
            <i class="fa-solid fa-triangle-exclamation"></i> <?php echo $error_msg; ?>
        </div>
    <?php endif; ?>

    <!-- Navigation Tabs -->
    <div class="tab-nav">
        <button type="button" class="tab-btn <?php echo $active_tab === 'tab-hero' ? 'active' : ''; ?>" onclick="switchTab(event, 'tab-hero')"><i class="fa-solid fa-plane-departure"></i> Hero & Stats</button>
        <button type="button" class="tab-btn <?php echo $active_tab === 'tab-solutions' ? 'active' : ''; ?>" onclick="switchTab(event, 'tab-solutions')"><i class="fa-solid fa-lightbulb"></i> Use Case Solutions</button>
        <button type="button" class="tab-btn <?php echo $active_tab === 'tab-why' ? 'active' : ''; ?>" onclick="switchTab(event, 'tab-why')"><i class="fa-solid fa-shuffle"></i> Why Us & Comparison</button>
        <button type="button" class="tab-btn <?php echo $active_tab === 'tab-how' ? 'active' : ''; ?>" onclick="switchTab(event, 'tab-how')"><i class="fa-solid fa-shoe-prints"></i> How It Works</button>
        <button type="button" class="tab-btn <?php echo $active_tab === 'tab-case' ? 'active' : ''; ?>" onclick="switchTab(event, 'tab-case')"><i class="fa-solid fa-folder-open"></i> Client Case Studies (CRUD)</button>
    </div>

    <!-- MAIN FORM FOR STATIC SECTIONS -->
    <form id="homepageForm" action="homepage-editor.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="save_homepage_settings">

        <!-- TAB 1: HERO & STATS -->
        <div id="tab-hero" class="editor-section <?php echo $active_tab === 'tab-hero' ? 'active' : ''; ?>">
            <div class="form-card">
                <div class="form-card-title">Homepage Hero Banner</div>
                <div class="form-group">
                    <label class="form-label">Upper Orange Badge Tagline</label>
                    <input type="text" name="home_hero_badge" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_hero_badge')); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Hero Title H1 (Allows &lt;br&gt; and tags)</label>
                    <input type="text" name="home_hero_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_hero_title')); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Hero Subtitle Paragraph</label>
                    <textarea name="home_hero_desc" class="form-control" rows="3" required><?php echo htmlspecialchars(get_site_setting('home_hero_desc')); ?></textarea>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title">Floating Stat Cards</div>
                <div class="grid-3">
                    <div class="form-card" style="padding: 15px; margin-bottom:0; background: var(--bg2);">
                        <label class="form-label" style="color: var(--accent);">Stat Card 1 (Retention)</label>
                        <div class="form-group">
                            <label class="form-label">Number Value (e.g. 98%)</label>
                            <input type="text" name="home_stat1_num" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_stat1_num')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Label Text</label>
                            <input type="text" name="home_stat1_label" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_stat1_label')); ?>">
                        </div>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom:0; background: var(--bg2);">
                        <label class="form-label" style="color: var(--accent);">Stat Card 2 (Travellers)</label>
                        <div class="form-group">
                            <label class="form-label">Number Value (e.g. 15k)</label>
                            <input type="text" name="home_stat2_num" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_stat2_num')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Label Text</label>
                            <input type="text" name="home_stat2_label" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_stat2_label')); ?>">
                        </div>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom:0; background: var(--bg2);">
                        <label class="form-label" style="color: var(--accent);">Stat Card 3 (Avg. Rating)</label>
                        <div class="form-group">
                            <label class="form-label">Number Value (e.g. 4.9★)</label>
                            <input type="text" name="home_stat3_num" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_stat3_num')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Label Text</label>
                            <input type="text" name="home_stat3_label" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_stat3_label')); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: USE CASE SOLUTIONS -->
        <div id="tab-solutions" class="editor-section <?php echo $active_tab === 'tab-solutions' ? 'active' : ''; ?>">
            <div class="form-card">
                <div class="form-card-title">Corporate Solutions Headers</div>
                <div class="grid-3">
                    <div class="form-group">
                        <label class="form-label">Section Tag Label</label>
                        <input type="text" name="home_solutions_label" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_solutions_label')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Section Title Heading</label>
                        <input type="text" name="home_solutions_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_solutions_title')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Section Subtitle Paragraph</label>
                        <input type="text" name="home_solutions_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_solutions_desc')); ?>">
                    </div>
                </div>
            </div>

            <!-- Solutions Grid loop -->
            <div class="form-card">
                <div class="form-card-title">4 Core Use Case Cards</div>
                
                <!-- Solution Card 1 -->
                <div class="form-card" style="padding: 16px; margin-bottom: 20px; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: #A855F7;">Card 1: Leadership Offsites</div>
                    <div class="form-group">
                        <label class="form-label">Card Icon Graphic</label>
                        <div class="image-uploader-wrapper">
                            <img class="image-preview" src="../<?php echo htmlspecialchars(get_site_setting('sol1_img')); ?>" alt="Sol 1 Icon">
                            <div class="upload-info">
                                <input type="file" name="sol1_img_file" class="form-control" style="padding: 6px 12px;">
                                <p>Provide clean PNG / SVG icon asset</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Card Title</label>
                            <input type="text" name="sol1_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol1_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Card Description</label>
                            <input type="text" name="sol1_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol1_desc')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tag Badge</label>
                            <input type="text" name="sol1_tag" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol1_tag')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Solution Card 2 -->
                <div class="form-card" style="padding: 16px; margin-bottom: 20px; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: #22C55E;">Card 2: Dealer & Distributor Trips</div>
                    <div class="form-group">
                        <label class="form-label">Card Icon Graphic</label>
                        <div class="image-uploader-wrapper">
                            <img class="image-preview" src="../<?php echo htmlspecialchars(get_site_setting('sol2_img')); ?>" alt="Sol 2 Icon">
                            <div class="upload-info">
                                <input type="file" name="sol2_img_file" class="form-control" style="padding: 6px 12px;">
                                <p>Provide clean PNG / SVG icon asset</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Card Title</label>
                            <input type="text" name="sol2_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol2_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Card Description</label>
                            <input type="text" name="sol2_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol2_desc')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tag Badge</label>
                            <input type="text" name="sol2_tag" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol2_tag')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Solution Card 3 -->
                <div class="form-card" style="padding: 16px; margin-bottom: 20px; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: #F97316;">Card 3: Employee Incentives</div>
                    <div class="form-group">
                        <label class="form-label">Card Icon Graphic</label>
                        <div class="image-uploader-wrapper">
                            <img class="image-preview" src="../<?php echo htmlspecialchars(get_site_setting('sol3_img')); ?>" alt="Sol 3 Icon">
                            <div class="upload-info">
                                <input type="file" name="sol3_img_file" class="form-control" style="padding: 6px 12px;">
                                <p>Provide clean PNG / SVG icon asset</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Card Title</label>
                            <input type="text" name="sol3_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol3_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Card Description</label>
                            <input type="text" name="sol3_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol3_desc')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tag Badge</label>
                            <input type="text" name="sol3_tag" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol3_tag')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Solution Card 4 -->
                <div class="form-card" style="padding: 16px; margin-bottom: 0px; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: #3B82F6;">Card 4: Annual Team Offsites</div>
                    <div class="form-group">
                        <label class="form-label">Card Icon Graphic</label>
                        <div class="image-uploader-wrapper">
                            <img class="image-preview" src="../<?php echo htmlspecialchars(get_site_setting('sol4_img')); ?>" alt="Sol 4 Icon">
                            <div class="upload-info">
                                <input type="file" name="sol4_img_file" class="form-control" style="padding: 6px 12px;">
                                <p>Provide clean PNG / SVG icon asset</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Card Title</label>
                            <input type="text" name="sol4_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol4_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Card Description</label>
                            <input type="text" name="sol4_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol4_desc')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tag Badge</label>
                            <input type="text" name="sol4_tag" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('sol4_tag')); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: WHY WANDEROO & COMPARISONS -->
        <div id="tab-why" class="editor-section <?php echo $active_tab === 'tab-why' ? 'active' : ''; ?>">
            <div class="form-card">
                <div class="form-card-title">Why Wanderoo Headers</div>
                <div class="grid-3">
                    <div class="form-group">
                        <label class="form-label">Section Tag Label</label>
                        <input type="text" name="home_why_label" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_why_label')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Section Title</label>
                        <input type="text" name="home_why_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_why_title')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Section Subtitle</label>
                        <input type="text" name="home_why_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('home_why_desc')); ?>">
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title">Problem vs. Wanderoo Comparison Grid</div>
                
                <!-- Row 1 -->
                <div class="form-card" style="padding: 14px; margin-bottom:15px; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 8px; font-size: 12px; color: var(--accent);">Row 1 Comparison</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Problem Column Text</label>
                            <input type="text" name="comp_p1" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('comp_p1')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Wanderoo Column Text</label>
                            <input type="text" name="comp_w1" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('comp_w1')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="form-card" style="padding: 14px; margin-bottom:15px; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 8px; font-size: 12px; color: var(--accent);">Row 2 Comparison</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Problem Column Text</label>
                            <input type="text" name="comp_p2" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('comp_p2')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Wanderoo Column Text</label>
                            <input type="text" name="comp_w2" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('comp_w2')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="form-card" style="padding: 14px; margin-bottom:15px; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 8px; font-size: 12px; color: var(--accent);">Row 3 Comparison</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Problem Column Text</label>
                            <input type="text" name="comp_p3" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('comp_p3')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Wanderoo Column Text</label>
                            <input type="text" name="comp_w3" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('comp_w3')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="form-card" style="padding: 14px; margin-bottom:0; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 8px; font-size: 12px; color: var(--accent);">Row 4 Comparison</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Problem Column Text</label>
                            <input type="text" name="comp_p4" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('comp_p4')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Wanderoo Column Text</label>
                            <input type="text" name="comp_w4" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('comp_w4')); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title">Right Column Performance Metric Cards</div>
                
                <div class="grid-3">
                    <div class="form-card" style="padding: 15px; margin-bottom: 0; background: var(--bg2);">
                        <label class="form-label" style="color: var(--accent);">Metric Card 1 (Orange)</label>
                        <div class="form-group">
                            <label class="form-label">Value Number (e.g. 35%)</label>
                            <input type="text" name="metric1_num" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('metric1_num')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description Text</label>
                            <input type="text" name="metric1_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('metric1_desc')); ?>">
                        </div>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom: 0; background: var(--bg2);">
                        <label class="form-label" style="color: var(--accent);">Metric Card 2 (Purple)</label>
                        <div class="form-group">
                            <label class="form-label">Value Number (e.g. 12h)</label>
                            <input type="text" name="metric2_num" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('metric2_num')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description Text</label>
                            <input type="text" name="metric2_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('metric2_desc')); ?>">
                        </div>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom: 0; background: var(--bg2);">
                        <label class="form-label" style="color: var(--accent);">Metric Card 3 (Green)</label>
                        <div class="form-group">
                            <label class="form-label">Value Number (e.g. 30%)</label>
                            <input type="text" name="metric3_num" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('metric3_num')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description Text</label>
                            <input type="text" name="metric3_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('metric3_desc')); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: HOW IT WORKS -->
        <div id="tab-how" class="editor-section <?php echo $active_tab === 'tab-how' ? 'active' : ''; ?>">
            <div class="form-card">
                <div class="form-card-title">How It Works Headers</div>
                <div class="grid-3">
                    <div class="form-group">
                        <label class="form-label">Section Tag Label</label>
                        <input type="text" name="how_label" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('how_label')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Section Title Heading</label>
                        <input type="text" name="how_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('how_title')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Section Subtitle Paragraph</label>
                        <input type="text" name="how_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('how_desc')); ?>">
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title">4 Sequential Execution Steps</div>
                
                <div class="form-card" style="padding: 15px; margin-bottom: 15px; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 8px; font-size: 13px; color: var(--accent);">Step 1: Goal Definition</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Step Title</label>
                            <input type="text" name="step1_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('step1_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Step Description</label>
                            <input type="text" name="step1_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('step1_desc')); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-card" style="padding: 15px; margin-bottom: 15px; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 8px; font-size: 13px; color: var(--accent);">Step 2: Designing & Customizing</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Step Title</label>
                            <input type="text" name="step2_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('step2_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Step Description</label>
                            <input type="text" name="step2_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('step2_desc')); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-card" style="padding: 15px; margin-bottom: 15px; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 8px; font-size: 13px; color: var(--accent);">Step 3: Approval Confirmation</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Step Title</label>
                            <input type="text" name="step3_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('step3_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Step Description</label>
                            <input type="text" name="step3_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('step3_desc')); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-card" style="padding: 15px; margin-bottom: 0; background: var(--bg2);">
                    <div style="font-weight: 700; margin-bottom: 8px; font-size: 13px; color: var(--accent);">Step 4: Flight & On-Ground Operations</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Step Title</label>
                            <input type="text" name="step4_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('step4_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Step Description</label>
                            <input type="text" name="step4_desc" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('step4_desc')); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- TAB 5: CLIENT CASE STUDIES CRUD -->
    <div id="tab-case" class="editor-section <?php echo $active_tab === 'tab-case' ? 'active' : ''; ?>">
        <?php
        // Subrouting logic inside case tab for Edit/Add
        $subaction = isset($_GET['sub']) ? htmlspecialchars($_GET['sub']) : 'list';
        $edit_study = null;

        if ($subaction === 'edit' && isset($_GET['id'])) {
            $case_id = intval($_GET['id']);
            $stmt_cs = $pdo->prepare("SELECT * FROM `case_studies` WHERE id = ?");
            $stmt_cs->execute([$case_id]);
            $edit_study = $stmt_cs->fetch(PDO::FETCH_ASSOC);
        }
        
        if ($subaction === 'add' || ($subaction === 'edit' && $edit_study)):
        ?>
            <!-- Add or Edit Form Container -->
            <div class="form-card">
                <div class="form-card-title">
                    <span><?php echo $subaction === 'edit' ? 'Edit Existing' : 'Add New'; ?> Client Case Study Portfolio</span>
                    <a href="homepage-editor.php?tab=tab-case" class="btn-edit" style="margin-right: 0;">Back to Portfolio List</a>
                </div>
                
                <form action="homepage-editor.php?tab=tab-case" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?php echo $subaction === 'edit' ? 'edit_case' : 'add_case'; ?>">
                    <?php if ($subaction === 'edit'): ?>
                        <input type="hidden" name="case_id" value="<?php echo $edit_study['id']; ?>">
                    <?php endif; ?>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Client / Company Name</label>
                            <input type="text" name="client_name" class="form-control" value="<?php echo $edit_study ? htmlspecialchars($edit_study['client_name']) : ''; ?>" placeholder="e.g. Dunzo, Tata 1mg, Zomato" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Client Logo File</label>
                            <div class="image-uploader-wrapper">
                                <?php if ($edit_study && $edit_study['client_logo']): ?>
                                    <img class="image-preview" src="../<?php echo htmlspecialchars($edit_study['client_logo']); ?>" alt="Logo preview">
                                <?php else: ?>
                                    <div class="image-preview" style="display:flex;align-items:center;justify-content:center;font-size:24px;color:#cbd5e1;"><i class="fa-solid fa-image"></i></div>
                                <?php endif; ?>
                                <div class="upload-info">
                                    <input type="file" name="client_logo_file" class="form-control" style="padding: 6px 12px;" <?php echo $subaction === 'add' ? 'required' : ''; ?>>
                                    <p>Select a clean logo with transparent background (SVG, PNG). Recommended height: 35px</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Badge Tag (e.g. Thailand, Sri Lanka)</label>
                            <input type="text" name="badge_text" class="form-control" value="<?php echo $edit_study ? htmlspecialchars($edit_study['badge_text']) : ''; ?>" placeholder="e.g. Thailand" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Emoji Flag Icon</label>
                            <input type="text" name="badge_flag" class="form-control" value="<?php echo $edit_study ? htmlspecialchars($edit_study['badge_flag']) : ''; ?>" placeholder="e.g. 🇹🇭, 🌿" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Badge Color Accent Theme</label>
                            <select name="badge_color" class="form-control">
                                <option value="orange" <?php echo ($edit_study && $edit_study['badge_color'] === 'orange') ? 'selected' : ''; ?>>Orange theme</option>
                                <option value="green" <?php echo ($edit_study && $edit_study['badge_color'] === 'green') ? 'selected' : ''; ?>>Green theme</option>
                                <option value="red" <?php echo ($edit_study && $edit_study['badge_color'] === 'red') ? 'selected' : ''; ?>>Red theme</option>
                                <option value="purple" <?php echo ($edit_study && $edit_study['badge_color'] === 'purple') ? 'selected' : ''; ?>>Purple theme</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Subtitle Case Trip Scope</label>
                        <input type="text" name="case_type" class="form-control" value="<?php echo $edit_study ? htmlspecialchars($edit_study['case_type']) : ''; ?>" placeholder="e.g. Growth Team Offsite · 80 Employees" required>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom: 20px; background: var(--bg2);">
                        <label class="form-label" style="color: var(--accent); margin-bottom: 12px; font-weight:700;">Case Studies Stat Numbers Bar</label>
                        <div class="grid-3">
                            <div class="form-card" style="padding: 12px; margin-bottom:0;">
                                <div class="form-group">
                                    <label class="form-label">Stat 1 Value (e.g. 80)</label>
                                    <input type="text" name="stat1_num" class="form-control" value="<?php echo $edit_study ? htmlspecialchars($edit_study['stat1_num']) : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Stat 1 Label (e.g. Employees)</label>
                                    <input type="text" name="stat1_label" class="form-control" value="<?php echo $edit_study ? htmlspecialchars($edit_study['stat1_label']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-card" style="padding: 12px; margin-bottom:0;">
                                <div class="form-group">
                                    <label class="form-label">Stat 2 Value (e.g. 4D)</label>
                                    <input type="text" name="stat2_num" class="form-control" value="<?php echo $edit_study ? htmlspecialchars($edit_study['stat2_num']) : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Stat 2 Label (e.g. Duration)</label>
                                    <input type="text" name="stat2_label" class="form-control" value="<?php echo $edit_study ? htmlspecialchars($edit_study['stat2_label']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-card" style="padding: 12px; margin-bottom:0;">
                                <div class="form-group">
                                    <label class="form-label">Stat 3 Value (e.g. +25%)</label>
                                    <input type="text" name="stat3_num" class="form-control" value="<?php echo $edit_study ? htmlspecialchars($edit_study['stat3_num']) : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Stat 3 Label (e.g. Efficiency)</label>
                                    <input type="text" name="stat3_label" class="form-control" value="<?php echo $edit_study ? htmlspecialchars($edit_study['stat3_label']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Final Outcome Narrative Paragraph</label>
                        <textarea name="outcome" class="form-control" rows="3" placeholder="Tell us what the company achieved with this incentive travel program..." required><?php echo $edit_study ? htmlspecialchars($edit_study['outcome']) : ''; ?></textarea>
                    </div>

                    <div style="margin-top: 25px; display:flex; gap:10px;">
                        <button type="submit" class="btn-save"><i class="fa-solid fa-check"></i> <?php echo $subaction === 'edit' ? 'Save Case Study Details' : 'Publish Case Study'; ?></button>
                        <a href="homepage-editor.php?tab=tab-case" class="btn-edit" style="padding:10px 20px; display:flex; align-items:center;">Cancel</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <!-- Default Listing Workspace -->
            <div class="form-card">
                <div class="form-card-title">
                    <span>Portfolio Database (<?php echo count(get_all_case_studies()); ?> Case Studies)</span>
                    <a href="homepage-editor.php?tab=tab-case&sub=add" class="btn-save" style="font-size: 13px; text-decoration:none;"><i class="fa-solid fa-plus"></i> Add New Case Study</a>
                </div>
                
                <div style="overflow-x: auto;">
                    <table class="crud-table">
                        <thead>
                            <tr>
                                <th>Client Logo</th>
                                <th>Company / Client Name</th>
                                <th>Location Badge</th>
                                <th>Trip Details Scope</th>
                                <th>Stats Numbers</th>
                                <th style="text-align: right;">Workspace Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $case_studies = get_all_case_studies();
                            if (empty($case_studies)):
                            ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 30px; color: var(--fg2);">No Case Studies available in database. Start by adding a new one above.</td>
                                </tr>
                            <?php 
                            else:
                                foreach ($case_studies as $cs):
                            ?>
                                <tr>
                                    <td>
                                        <img src="../<?php echo htmlspecialchars($cs['client_logo']); ?>" alt="logo" style="max-height:22px; width:auto; max-width:80px; object-fit:contain; background:#f8fafc; padding:3px; border-radius:4px; border:1px solid #e2e8f0;">
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($cs['client_name']); ?></strong></td>
                                    <td>
                                        <span class="badge badge-<?php echo htmlspecialchars($cs['badge_color']); ?>">
                                            <?php echo htmlspecialchars($cs['badge_flag'] . ' ' . $cs['badge_text']); ?>
                                        </span>
                                    </td>
                                    <td><span style="color:#64748b; font-size:12px;"><?php echo htmlspecialchars($cs['case_type']); ?></span></td>
                                    <td>
                                        <span style="font-family:monospace; font-size:11px;"><?php echo htmlspecialchars($cs['stat1_num'] . ' ' . $cs['stat1_label']); ?></span> · 
                                        <span style="font-family:monospace; font-size:11px;"><?php echo htmlspecialchars($cs['stat2_num'] . ' ' . $cs['stat2_label']); ?></span>
                                    </td>
                                    <td style="text-align: right; white-space: nowrap;">
                                        <a href="homepage-editor.php?tab=tab-case&sub=edit&id=<?php echo $cs['id']; ?>" class="btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                        <a href="homepage-editor.php?delete_case_id=<?php echo $cs['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to permanently delete this case study?');"><i class="fa-solid fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
/**
 * Switch tabs dynamically in Javascript and preserve active tab inside URL parameter history
 */
function switchTab(evt, tabId) {
    // Hide all tab sections
    const sections = document.getElementsByClassName("editor-section");
    for (let i = 0; i < sections.length; i++) {
        sections[i].classList.remove("active");
    }

    // Deactivate all tab buttons
    const buttons = document.getElementsByClassName("tab-btn");
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove("active");
    }

    // Show selected section and activate button
    document.getElementById(tabId).classList.add("active");
    evt.currentTarget.classList.add("active");

    // Update browser URL query history cleanly
    const url = new URL(window.location);
    url.searchParams.set('tab', tabId);
    window.history.pushState({}, '', url);
}
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
