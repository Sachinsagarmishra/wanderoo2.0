<?php
/**
 * About Us Page Content Editor
 */
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/header.php'; // This also triggers authentication check

$success_msg = '';
$error_msg = '';

// Helper to handle image uploads safely
function upload_about_image($file_key, $setting_key, $prefix) {
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
        $dest_path = __DIR__ . '/../assets/img/' . $new_name;

        if (move_uploaded_file($tmp_name, $dest_path)) {
            $db_path = 'assets/img/' . $new_name;
            $stmt = $pdo->prepare("UPDATE about_settings SET setting_value = :val WHERE setting_key = :key");
            $stmt->execute(['val' => $db_path, 'key' => $setting_key]);
            return $db_path;
        } else {
            $error_msg .= "Failed to save uploaded file for $file_key. ";
            return false;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and update all text settings
    $settings_to_update = [
        // Hero
        'hero_label', 'hero_title', 'hero_text',
        // Stats
        'stat1_val', 'stat1_label',
        'stat2_val', 'stat2_label',
        'stat3_val', 'stat3_label',
        'stat4_val', 'stat4_label',
        // Story / Mission
        'mission_label', 'mission_title', 'mission_text1', 'mission_text2',
        'mission1_title', 'mission1_text',
        'mission2_title', 'mission2_text',
        'mission3_title', 'mission3_text',
        // Founder
        'founder_label', 'founder_title', 'founder_text1', 'founder_text2',
        'founder_name', 'founder_title_sub', 'founder_quote',
        // Why Choose Us
        'why_label', 'why_title',
        'card1_title', 'card1_text',
        'card2_title', 'card2_text',
        'card3_title', 'card3_text',
        'card4_title', 'card4_text',
        'card5_title', 'card5_text',
        // Experience
        'exp_label', 'exp_title', 'exp_text',
        'exp_point1', 'exp_point2', 'exp_point3',
        'exp_badge_num', 'exp_badge_text'
    ];

    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("UPDATE about_settings SET setting_value = :val WHERE setting_key = :key");
        foreach ($settings_to_update as $key) {
            if (isset($_POST[$key])) {
                $stmt->execute([
                    'val' => $_POST[$key],
                    'key' => $key
                ]);
            }
        }

        // Process file uploads
        upload_about_image('hero_bg_file', 'hero_bg', 'about_hero');
        upload_about_image('founder_img_file', 'founder_img', 'founder');
        upload_about_image('exp_img_file', 'exp_img', 'experience');

        $pdo->commit();
        $success_msg = "About Us settings updated successfully!";
        
        // Clear functions cache to reload updated details
        $about_settings_cache = null; 
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error_msg .= "Update failed: " . $e->getMessage();
    }
}
?>

<style>
    /* Styling adjustments specifically for editor pages */
    .editor-container {
        max-width: 1000px;
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
        padding: 10px 18px;
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
    }
    
    /* Card Settings Design */
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
    .grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }
    
    /* Image Uploader & Preview Style */
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
        width: 120px;
        height: 80px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid var(--border);
        background: #e2e8f0;
    }
    .upload-info {
        flex: 1;
    }
    .upload-info p {
        font-size: 11px;
        color: var(--fg2);
        margin-top: 4px;
    }
</style>

    <div class="editor-container">
        
        <form action="" method="POST" enctype="multipart/form-data">
            
            <div class="editor-header">
                <div>
                    <h1>About Us Page Editor</h1>
                    <p style="color: var(--fg2); font-size: 13px; margin-top: 4px;">Easily edit all texts, stats, and graphics appearing on the About Us page.</p>
                </div>
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Save Content Updates
                </button>
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
                <button type="button" class="tab-btn active" onclick="switchTab(event, 'tab-hero')"><i class="fa-solid fa-plane"></i> Hero & Stats</button>
                <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-story')"><i class="fa-solid fa-bullseye"></i> Story & Mission</button>
                <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-founder')"><i class="fa-solid fa-user-tie"></i> Founder Block</button>
                <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-why')"><i class="fa-solid fa-award"></i> Why Choose Us</button>
                <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-experience')"><i class="fa-solid fa-calendar-check"></i> Experience & Badge</button>
            </div>

            <!-- TAB 1: HERO & STATS -->
            <div id="tab-hero" class="editor-section active">
                <div class="form-card">
                    <div class="form-card-title">Hero Banner Section</div>
                    
                    <div class="form-group">
                        <label class="form-label">Hero Background Image</label>
                        <div class="image-uploader-wrapper">
                            <img class="image-preview" src="../<?php echo htmlspecialchars(get_about_setting('hero_bg', 'assets/img/aboutusbg.png')); ?>" alt="Hero BG">
                            <div class="upload-info">
                                <input type="file" name="hero_bg_file" class="form-control" style="padding: 6px 12px;">
                                <p>Recommend landscape orientation image (PNG, JPG, WEBP). Recommended size: 1920x800px</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Hero Section Label</label>
                            <input type="text" name="hero_label" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('hero_label')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hero Title (Allows HTML tags like &lt;br&gt; and &lt;span class="accent"&gt;)</label>
                            <input type="text" name="hero_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('hero_title')); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hero Description Paragraph</label>
                        <textarea name="hero_text" class="form-control" rows="3"><?php echo htmlspecialchars(get_about_setting('hero_text')); ?></textarea>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-title">Hero Statistics Bar</div>
                    
                    <div class="grid-2">
                        <div class="form-card" style="padding: 15px; margin-bottom: 0;">
                            <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Stat 1 (e.g. Trips)</div>
                            <div class="form-group">
                                <label class="form-label">Value</label>
                                <input type="text" name="stat1_val" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('stat1_val')); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Label</label>
                                <input type="text" name="stat1_label" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('stat1_label')); ?>">
                            </div>
                        </div>

                        <div class="form-card" style="padding: 15px; margin-bottom: 0;">
                            <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Stat 2 (e.g. Travellers)</div>
                            <div class="form-group">
                                <label class="form-label">Value</label>
                                <input type="text" name="stat2_val" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('stat2_val')); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Label</label>
                                <input type="text" name="stat2_label" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('stat2_label')); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="grid-2" style="margin-top: 20px;">
                        <div class="form-card" style="padding: 15px; margin-bottom: 0;">
                            <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Stat 3 (e.g. Clients)</div>
                            <div class="form-group">
                                <label class="form-label">Value</label>
                                <input type="text" name="stat3_val" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('stat3_val')); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Label</label>
                                <input type="text" name="stat3_label" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('stat3_label')); ?>">
                            </div>
                        </div>

                        <div class="form-card" style="padding: 15px; margin-bottom: 0;">
                            <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Stat 4 (e.g. Rating)</div>
                            <div class="form-group">
                                <label class="form-label">Value</label>
                                <input type="text" name="stat4_val" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('stat4_val')); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Label</label>
                                <input type="text" name="stat4_label" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('stat4_label')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: STORY & MISSION -->
            <div id="tab-story" class="editor-section">
                <div class="form-card">
                    <div class="form-card-title">Our Story Headers</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Section Label</label>
                            <input type="text" name="mission_label" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('mission_label')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Main Title</label>
                            <input type="text" name="mission_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('mission_title')); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Story Paragraph 1</label>
                        <textarea name="mission_text1" class="form-control" rows="3"><?php echo htmlspecialchars(get_about_setting('mission_text1')); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Story Paragraph 2</label>
                        <textarea name="mission_text2" class="form-control" rows="3"><?php echo htmlspecialchars(get_about_setting('mission_text2')); ?></textarea>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-title">Mission, Vision, and Promise Pillars</div>
                    
                    <div class="form-card" style="padding: 15px; margin-bottom: 20px; background: var(--bg2);">
                        <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Pillar 1: Our Mission</div>
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" name="mission1_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('mission1_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Text</label>
                            <textarea name="mission1_text" class="form-control" rows="2"><?php echo htmlspecialchars(get_about_setting('mission1_text')); ?></textarea>
                        </div>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom: 20px; background: var(--bg2);">
                        <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Pillar 2: Our Vision</div>
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" name="mission2_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('mission2_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Text</label>
                            <textarea name="mission2_text" class="form-control" rows="2"><?php echo htmlspecialchars(get_about_setting('mission2_text')); ?></textarea>
                        </div>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom: 0; background: var(--bg2);">
                        <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Pillar 3: Our Promise</div>
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" name="mission3_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('mission3_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Text</label>
                            <textarea name="mission3_text" class="form-control" rows="2"><?php echo htmlspecialchars(get_about_setting('mission3_text')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: FOUNDER BLOCK -->
            <div id="tab-founder" class="editor-section">
                <div class="form-card">
                    <div class="form-card-title">Founder Profile & Quote</div>
                    
                    <div class="form-group">
                        <label class="form-label">Founder Profile Image</label>
                        <div class="image-uploader-wrapper">
                            <img class="image-preview" src="../<?php echo htmlspecialchars(get_about_setting('founder_img', 'assets/img/himanshu-cfounder.png')); ?>" alt="Founder Image">
                            <div class="upload-info">
                                <input type="file" name="founder_img_file" class="form-control" style="padding: 6px 12px;">
                                <p>Recommend square or vertical portait orientation (PNG or JPG). Recommended size: 600x700px</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Founder Section Label</label>
                            <input type="text" name="founder_label" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('founder_label')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Founder Title Heading</label>
                            <input type="text" name="founder_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('founder_title')); ?>">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Founder Name</label>
                            <input type="text" name="founder_name" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('founder_name')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Founder Position Subtitle</label>
                            <input type="text" name="founder_title_sub" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('founder_title_sub')); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Founder Journey Text Paragraph 1</label>
                        <textarea name="founder_text1" class="form-control" rows="3"><?php echo htmlspecialchars(get_about_setting('founder_text1')); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Founder Journey Text Paragraph 2</label>
                        <textarea name="founder_text2" class="form-control" rows="3"><?php echo htmlspecialchars(get_about_setting('founder_text2')); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Founder Highlight Quote</label>
                        <textarea name="founder_quote" class="form-control" rows="2"><?php echo htmlspecialchars(get_about_setting('founder_quote')); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- TAB 4: WHY CHOOSE US -->
            <div id="tab-why" class="editor-section">
                <div class="form-card">
                    <div class="form-card-title">Why Choose Us Headers</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Section Label</label>
                            <input type="text" name="why_label" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('why_label')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Section Title</label>
                            <input type="text" name="why_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('why_title')); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-title">5 Key Feature Cards</div>
                    
                    <div class="form-card" style="padding: 15px; margin-bottom: 20px; background: var(--bg2);">
                        <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Card 1 (Performance Approach)</div>
                        <div class="form-group">
                            <label class="form-label">Card Title</label>
                            <input type="text" name="card1_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('card1_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Card Text</label>
                            <input type="text" name="card1_text" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('card1_text')); ?>">
                        </div>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom: 20px; background: var(--bg2);">
                        <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Card 2 (Execution)</div>
                        <div class="form-group">
                            <label class="form-label">Card Title</label>
                            <input type="text" name="card2_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('card2_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Card Text</label>
                            <input type="text" name="card2_text" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('card2_text')); ?>">
                        </div>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom: 20px; background: var(--bg2);">
                        <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Card 3 (Experiences)</div>
                        <div class="form-group">
                            <label class="form-label">Card Title</label>
                            <input type="text" name="card3_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('card3_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Card Text</label>
                            <input type="text" name="card3_text" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('card3_text')); ?>">
                        </div>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom: 20px; background: var(--bg2);">
                        <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Card 4 (Transparent)</div>
                        <div class="form-group">
                            <label class="form-label">Card Title</label>
                            <input type="text" name="card4_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('card4_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Card Text</label>
                            <input type="text" name="card4_text" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('card4_text')); ?>">
                        </div>
                    </div>

                    <div class="form-card" style="padding: 15px; margin-bottom: 0; background: var(--bg2);">
                        <div style="font-weight: 700; margin-bottom: 10px; font-size: 13px; color: var(--accent);">Card 5 (Leaders)</div>
                        <div class="form-group">
                            <label class="form-label">Card Title</label>
                            <input type="text" name="card5_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('card5_title')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Card Text</label>
                            <input type="text" name="card5_text" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('card5_text')); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 5: EXPERIENCE & BADGES -->
            <div id="tab-experience" class="editor-section">
                <div class="form-card">
                    <div class="form-card-title">Experience Block</div>
                    
                    <div class="form-group">
                        <label class="form-label">Experience Section Graphic Image</label>
                        <div class="image-uploader-wrapper">
                            <img class="image-preview" src="../<?php echo htmlspecialchars(get_about_setting('exp_img', 'assets/img/team-terrace.png')); ?>" alt="Experience Block Graphic">
                            <div class="upload-info">
                                <input type="file" name="exp_img_file" class="form-control" style="padding: 6px 12px;">
                                <p>Recommend landscape orientation image (PNG, JPG, WEBP). Recommended size: 800x500px</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Section Label</label>
                            <input type="text" name="exp_label" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('exp_label')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Section Main Title</label>
                            <input type="text" name="exp_title" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('exp_title')); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Experience Description Paragraph</label>
                        <textarea name="exp_text" class="form-control" rows="3"><?php echo htmlspecialchars(get_about_setting('exp_text')); ?></textarea>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-title">Bullet Highlights</div>
                    <div class="form-group">
                        <label class="form-label">Highlight Point 1</label>
                        <input type="text" name="exp_point1" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('exp_point1')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Highlight Point 2</label>
                        <input type="text" name="exp_point2" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('exp_point2')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Highlight Point 3</label>
                        <input type="text" name="exp_point3" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('exp_point3')); ?>">
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-title">Badge Label Widget</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Badge Number (e.g. 20+)</label>
                            <input type="text" name="exp_badge_num" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('exp_badge_num')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Badge Subtitle Label</label>
                            <input type="text" name="exp_badge_text" class="form-control" value="<?php echo htmlspecialchars(get_about_setting('exp_badge_text')); ?>">
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

<script>
/**
 * Switch tabs dynamically in Javascript
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
}
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
