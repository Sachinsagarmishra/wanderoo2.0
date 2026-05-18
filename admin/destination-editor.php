<?php
/**
 * Global Destinations Editor
 */
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/header.php'; // Triggers auth check

$success_msg = '';
$error_msg = '';

// Helper for file uploading
function handle_file_upload($file_key, $upload_dir = '../assets/img/') {
    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES[$file_key]['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if (in_array($file_ext, $allowed_exts)) {
            // Ensure unique file name
            $new_filename = uniqid('img_', true) . '.' . $file_ext;
            $dest_path = $upload_dir . $new_filename;

            // Ensure destination directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $dest_path)) {
                // Return clean relative path for DB
                return str_replace('../', '', $dest_path);
            }
        }
    }
    return null;
}

// ----------------------------------------------------
// HANDLERS FOR CRUD DESTINATION CARDS
// ----------------------------------------------------
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$edit_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// POST Handlers
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. SAVE STATIC SECTIONS (Hero, Regions, Why, CTA)
    if (isset($_POST['save_static'])) {
        $settings_to_update = [
            'dest_hero_label', 'dest_hero_title', 'dest_hero_desc', 'dest_hero_badge',
            'dest_region_title',
            'region1_index', 'region1_title', 'region1_desc', 'region1_meta',
            'region2_index', 'region2_title', 'region2_desc', 'region2_meta',
            'region3_index', 'region3_title', 'region3_desc', 'region3_meta',
            'dest_why_title', 'dest_cta_title', 'dest_cta_desc'
        ];

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) 
                                   VALUES (:key, :val) 
                                   ON DUPLICATE KEY UPDATE setting_value = :val2");
            
            // Handle standard inputs
            foreach ($settings_to_update as $key) {
                if (isset($_POST[$key])) {
                    $stmt->execute(['key' => $key, 'val' => $_POST[$key], 'val2' => $_POST[$key]]);
                }
            }

            // Handle images
            $hero_img = handle_file_upload('dest_hero_img');
            if ($hero_img) {
                $stmt->execute(['key' => 'dest_hero_img', 'val' => $hero_img, 'val2' => $hero_img]);
            }

            for ($i = 1; $i <= 3; $i++) {
                $reg_img = handle_file_upload("region{$i}_img");
                if ($reg_img) {
                    $stmt->execute(['key' => "region{$i}_img", 'val' => $reg_img, 'val2' => $reg_img]);
                }
            }

            $pdo->commit();
            $success_msg = "Destinations static sections updated successfully!";
            $site_settings_cache = null; // Clear cache
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error_msg = "Failed to save: " . $e->getMessage();
        }
    }

    // 2. ADD DYNAMIC DESTINATION CARD
    if (isset($_POST['add_destination'])) {
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $duration = isset($_POST['duration']) ? trim($_POST['duration']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $tags = isset($_POST['tags']) ? trim($_POST['tags']) : '';

        if (!empty($title)) {
            $image_path = 'assets/img/dest/bali.png'; // Fallback
            $uploaded_img = handle_file_upload('dest_card_img', '../assets/img/dest/');
            if ($uploaded_img) {
                $image_path = $uploaded_img;
            }

            try {
                $stmt = $pdo->prepare("INSERT INTO destinations (title, duration, description, image_path, tags) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$title, $duration, $description, $image_path, $tags]);
                $success_msg = "Destination card '{$title}' added successfully!";
                header("Location: destination-editor.php?action=list&success=" . urlencode($success_msg));
                exit;
            } catch (PDOException $e) {
                $error_msg = "Failed to add card: " . $e->getMessage();
            }
        } else {
            $error_msg = "Destination title is required.";
        }
    }

    // 3. EDIT DYNAMIC DESTINATION CARD
    if (isset($_POST['edit_destination'])) {
        $id = intval($_POST['card_id']);
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $duration = isset($_POST['duration']) ? trim($_POST['duration']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $tags = isset($_POST['tags']) ? trim($_POST['tags']) : '';

        if ($id > 0 && !empty($title)) {
            try {
                // Fetch old image path first
                $stmt_old = $pdo->prepare("SELECT image_path FROM destinations WHERE id = ?");
                $stmt_old->execute([$id]);
                $image_path = $stmt_old->fetchColumn();

                $uploaded_img = handle_file_upload('dest_card_img', '../assets/img/dest/');
                if ($uploaded_img) {
                    $image_path = $uploaded_img;
                }

                $stmt = $pdo->prepare("UPDATE destinations SET title = ?, duration = ?, description = ?, image_path = ?, tags = ? WHERE id = ?");
                $stmt->execute([$title, $duration, $description, $image_path, $tags, $id]);
                $success_msg = "Destination card updated successfully!";
                header("Location: destination-editor.php?action=list&success=" . urlencode($success_msg));
                exit;
            } catch (PDOException $e) {
                $error_msg = "Failed to update card: " . $e->getMessage();
            }
        } else {
            $error_msg = "Card ID and Title are required.";
        }
    }
}

// GET Handlers for Success messages and Delete operations
if (isset($_GET['success'])) {
    $success_msg = $_GET['success'];
}

if ($action === 'delete' && $edit_id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM destinations WHERE id = ?");
        $stmt->execute([$edit_id]);
        $success_msg = "Destination card deleted successfully!";
        header("Location: destination-editor.php?action=list&success=" . urlencode($success_msg));
        exit;
    } catch (PDOException $e) {
        $error_msg = "Failed to delete card: " . $e->getMessage();
    }
}

// Fetch card details for editing
$edit_card = null;
if ($action === 'edit' && $edit_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM destinations WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_card = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<style>
    .editor-container {
        max-width: 1100px;
        margin: 0 auto;
        padding-bottom: 60px;
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
        margin: 0;
    }
    .btn-save, .btn-action {
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
        text-decoration: none;
        font-size: 14px;
    }
    .btn-save:hover, .btn-action:hover {
        background: var(--accent2);
        transform: translateY(-1px);
    }
    .btn-outline-action {
        background: none;
        border: 1px solid var(--border);
        color: var(--fg);
        padding: 9px 18px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        text-decoration: none;
        font-size: 13px;
    }
    .btn-outline-action:hover {
        background: var(--bg3);
        border-color: var(--fg2);
    }
    .btn-danger-action {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #b91c1c;
        padding: 8px 14px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
        text-decoration: none;
        font-size: 12px;
    }
    .btn-danger-action:hover {
        background: #b91c1c;
        color: #FFFFFF;
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

    /* Tabs */
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
    }
    
    .editor-section {
        display: none;
    }
    .editor-section.active {
        display: block;
    }

    /* Cards */
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
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
    }
    .image-preview-box {
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px dashed var(--border);
        padding: 12px;
        border-radius: 8px;
        background: var(--bg2);
    }
    .image-preview-box img {
        height: 60px;
        width: 90px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid var(--border);
    }

    /* Destination List Grid */
    .dest-table-card {
        padding: 0;
        overflow: hidden;
    }
    .dest-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .dest-table th {
        background: var(--bg2);
        color: var(--fg);
        font-weight: 700;
        font-size: 13px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
    }
    .dest-table td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        font-size: 14px;
        color: var(--fg2);
        vertical-align: middle;
    }
    .dest-table tr:last-child td {
        border-bottom: none;
    }
    .dest-table-img {
        width: 70px;
        height: 48px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid var(--border);
    }
    .tag-badge {
        display: inline-block;
        background: var(--bg3);
        color: var(--fg);
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 4px;
        margin-right: 4px;
        margin-bottom: 4px;
    }
</style>

<div class="editor-container">
    <div class="editor-header">
        <div>
            <h1>Destinations Page Editor</h1>
            <p style="color: var(--fg2); font-size: 13px; margin-top: 4px;">Easily edit the hero banner, explore regions, and manage dynamic handpicked destination cards.</p>
        </div>
        
        <?php if ($action === 'list'): ?>
            <a href="destination-editor.php?action=add" class="btn-save">
                <i class="fa-solid fa-plus"></i> Add New Destination
            </a>
        <?php else: ?>
            <a href="destination-editor.php?action=list" class="btn-outline-action">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>
        <?php endif; ?>
    </div>

    <!-- ====================================================
         LIST WORKSPACE
         ==================================================== -->
    <?php if ($action === 'list'): ?>
        <!-- Section Navigation Tabs -->
        <div class="tab-nav">
            <button class="tab-btn active" onclick="switchTab(event, 'section-cards')"><i class="fa-solid fa-map-pin"></i> Destination Cards</button>
            <button class="tab-btn" onclick="switchTab(event, 'section-hero')"><i class="fa-solid fa-image"></i> Hero Section</button>
            <button class="tab-btn" onclick="switchTab(event, 'section-regions')"><i class="fa-solid fa-globe"></i> Regions (Bento Grid)</button>
            <button class="tab-btn" onclick="switchTab(event, 'section-footer')"><i class="fa-solid fa-message"></i> Why & CTA Sections</button>
        </div>

        <!-- TAB: DESTINATION CARDS -->
        <div id="section-cards" class="editor-section active">
            <div class="form-card dest-table-card">
                <div class="form-card-title" style="padding: 20px 20px 0 20px; border-bottom: none;">Active Destination Cards</div>
                
                <table class="dest-table">
                    <thead>
                        <tr>
                            <th width="80">Image</th>
                            <th width="200">Destination</th>
                            <th width="100">Duration</th>
                            <th>Description & Tags</th>
                            <th width="180" style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $cards = get_all_destinations();
                        if (empty($cards)):
                        ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: var(--fg2);">
                                    No destinations found. Click "Add New Destination" to get started!
                                </td>
                            </tr>
                        <?php 
                        else:
                            foreach ($cards as $c):
                                $tags_list = array_map('trim', explode(',', $c['tags']));
                        ?>
                            <tr>
                                <td>
                                    <img src="../<?php echo htmlspecialchars($c['image_path']); ?>" class="dest-table-img" alt="">
                                </td>
                                <td>
                                    <strong style="color: var(--fg); font-size: 15px;"><?php echo htmlspecialchars($c['title']); ?></strong>
                                </td>
                                <td>
                                    <span style="background: rgba(249, 115, 22, 0.1); color: var(--accent); font-weight: 700; padding: 3px 8px; border-radius: 4px; font-size: 12px;"><?php echo htmlspecialchars($c['duration']); ?></span>
                                </td>
                                <td>
                                    <p style="margin-bottom: 6px; font-size: 13px;"><?php echo htmlspecialchars($c['description']); ?></p>
                                    <div>
                                        <?php foreach ($tags_list as $t): if (!empty($t)): ?>
                                            <span class="tag-badge"><?php echo htmlspecialchars($t); ?></span>
                                        <?php endif; endforeach; ?>
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <a href="destination-editor.php?action=edit&id=<?php echo $c['id']; ?>" class="btn-outline-action" style="padding: 6px 12px; font-size: 12px;">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="destination-editor.php?action=delete&id=<?php echo $c['id']; ?>" class="btn-danger-action" onclick="return confirm('Are you sure you want to delete this destination card?')">
                                        <i class="fa-solid fa-trash-can"></i> Delete
                                    </a>
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

        <!-- TAB: HERO SECTION -->
        <div id="section-hero" class="editor-section">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-card">
                    <div class="form-card-title">Destinations Hero Banner</div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Hero Tag/Label</label>
                            <input type="text" name="dest_hero_label" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('dest_hero_label')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hero Badge Text</label>
                            <input type="text" name="dest_hero_badge" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('dest_hero_badge')); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hero Section Main Title (Supports HTML tags like &lt;br&gt; and &lt;span class="accent"&gt;)</label>
                        <input type="text" name="dest_hero_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('dest_hero_title')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hero Subtitle/Description Paragraph</label>
                        <textarea name="dest_hero_desc" class="form-control" rows="3" required><?php echo htmlspecialchars(get_site_setting('dest_hero_desc')); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hero Banner Main Right Graphic Image</label>
                        <div class="image-preview-box">
                            <img src="../<?php echo htmlspecialchars(get_site_setting('dest_hero_img')); ?>" alt="Hero image">
                            <div>
                                <input type="file" name="dest_hero_img">
                                <small style="display: block; color: var(--fg2); margin-top: 4px;">Recommended size: 900x600px (WEBP/PNG/JPG)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <button type="submit" name="save_static" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i> Save Hero Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- TAB: REGIONS BENTO GRID -->
        <div id="section-regions" class="editor-section">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-card">
                    <div class="form-card-title">Regions Bento Grid Setup</div>
                    
                    <div class="form-group">
                        <label class="form-label">Bento Grid Section Title</label>
                        <input type="text" name="dest_region_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('dest_region_title')); ?>" required>
                    </div>
                </div>

                <!-- Region 1 -->
                <div class="form-card">
                    <div class="form-card-title">Region Card 1: South East Asia (Large Card Layout)</div>
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Index Number</label>
                            <input type="text" name="region1_index" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('region1_index')); ?>" required>
                        </div>
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Region Card Title (Supports &lt;br&gt; tags)</label>
                            <input type="text" name="region1_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('region1_title')); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Description</label>
                        <textarea name="region1_desc" class="form-control" rows="2" required><?php echo htmlspecialchars(get_site_setting('region1_desc')); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Metadata Row Text (e.g. 5 TO 7 DAYS · 20 TO 100 PAX)</label>
                        <input type="text" name="region1_meta" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('region1_meta')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Card Background Graphic Image</label>
                        <div class="image-preview-box">
                            <img src="../<?php echo htmlspecialchars(get_site_setting('region1_img')); ?>" alt="Region 1">
                            <div>
                                <input type="file" name="region1_img">
                                <small style="display: block; color: var(--fg2); margin-top: 4px;">Recommended size: 800x600px (WEBP/PNG/JPG)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Region 2 -->
                <div class="form-card">
                    <div class="form-card-title">Region Card 2: Europe (Small Card Layout)</div>
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Index Number</label>
                            <input type="text" name="region2_index" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('region2_index')); ?>" required>
                        </div>
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Region Card Title</label>
                            <input type="text" name="region2_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('region2_title')); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Description</label>
                        <textarea name="region2_desc" class="form-control" rows="2" required><?php echo htmlspecialchars(get_site_setting('region2_desc')); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Metadata Row Text</label>
                        <input type="text" name="region2_meta" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('region2_meta')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Card Background Graphic Image</label>
                        <div class="image-preview-box">
                            <img src="../<?php echo htmlspecialchars(get_site_setting('region2_img')); ?>" alt="Region 2">
                            <div>
                                <input type="file" name="region2_img">
                                <small style="display: block; color: var(--fg2); margin-top: 4px;">Recommended size: 600x400px (WEBP/PNG/JPG)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Region 3 -->
                <div class="form-card">
                    <div class="form-card-title">Region Card 3: Domestic (Small Card Layout)</div>
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Index Number</label>
                            <input type="text" name="region3_index" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('region3_index')); ?>" required>
                        </div>
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Region Card Title</label>
                            <input type="text" name="region3_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('region3_title')); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Description</label>
                        <textarea name="region3_desc" class="form-control" rows="2" required><?php echo htmlspecialchars(get_site_setting('region3_desc')); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Metadata Row Text</label>
                        <input type="text" name="region3_meta" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('region3_meta')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Card Background Graphic Image</label>
                        <div class="image-preview-box">
                            <img src="../<?php echo htmlspecialchars(get_site_setting('region3_img')); ?>" alt="Region 3">
                            <div>
                                <input type="file" name="region3_img">
                                <small style="display: block; color: var(--fg2); margin-top: 4px;">Recommended size: 600x400px (WEBP/PNG/JPG)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <button type="submit" name="save_static" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i> Save Region Layout
                    </button>
                </div>
            </form>
        </div>

        <!-- TAB: WHY & CTA SECTIONS -->
        <div id="section-footer" class="editor-section">
            <form action="" method="POST">
                <!-- Why Section -->
                <div class="form-card">
                    <div class="form-card-title">"Why Us" Section Settings</div>
                    <div class="form-group">
                        <label class="form-label">Why Section Main Title</label>
                        <input type="text" name="dest_why_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('dest_why_title')); ?>" required>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="form-card">
                    <div class="form-card-title">Final Call to Action Section (CTA)</div>
                    <div class="form-group">
                        <label class="form-label">CTA Box Big Heading (Supports &lt;br&gt; tags)</label>
                        <input type="text" name="dest_cta_title" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('dest_cta_title')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">CTA Supporting Paragraph</label>
                        <textarea name="dest_cta_desc" class="form-control" rows="3" required><?php echo htmlspecialchars(get_site_setting('dest_cta_desc')); ?></textarea>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <button type="submit" name="save_static" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i> Save Section Settings
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- ====================================================
         ADD WORKSPACE
         ==================================================== -->
    <?php if ($action === 'add'): ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-card">
                <div class="form-card-title">Add New Destination Card</div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Destination & Country (e.g. Bali, Indonesia)</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Bali, Indonesia">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Trip Duration Tag (e.g. 4N / 5D)</label>
                        <input type="text" name="duration" class="form-control" required placeholder="e.g. 4N / 5D">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Highlight/Intro Sentence</label>
                    <input type="text" name="description" class="form-control" required placeholder="e.g. Perfect blend of relaxation and cultural immersion.">
                </div>

                <div class="form-group">
                    <label class="form-label">Card Tags (Comma-separated - e.g. Beach, Culture, Wellness, Adventure, Luxury)</label>
                    <input type="text" name="tags" class="form-control" placeholder="e.g. Beach, Culture, Wellness">
                    <small style="color: var(--fg2); margin-top: 4px; display: block;">Supports auto tag-icon mapping on the frontend for: Beach, Culture, Wellness, Adventure, Nightlife, Mountains, Luxury, Food, Architecture, Leisure, Fun.</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Card Background Cover Graphic Image</label>
                    <input type="file" name="dest_card_img" required>
                    <small style="display: block; color: var(--fg2); margin-top: 4px;">Recommended size: 600x400px (WEBP/PNG/JPG)</small>
                </div>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button type="submit" name="add_destination" class="btn-save">
                    <i class="fa-solid fa-circle-check"></i> Add Destination Card
                </button>
            </div>
        </form>
    <?php endif; ?>

    <!-- ====================================================
         EDIT WORKSPACE
         ==================================================== -->
    <?php if ($action === 'edit' && $edit_card): ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="card_id" value="<?php echo $edit_card['id']; ?>">
            
            <div class="form-card">
                <div class="form-card-title">Edit Destination Card: <?php echo htmlspecialchars($edit_card['title']); ?></div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Destination & Country</label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($edit_card['title']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Trip Duration Tag</label>
                        <input type="text" name="duration" class="form-control" value="<?php echo htmlspecialchars($edit_card['duration']); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Highlight/Intro Sentence</label>
                    <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($edit_card['description']); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Card Tags (Comma-separated)</label>
                    <input type="text" name="tags" class="form-control" value="<?php echo htmlspecialchars($edit_card['tags']); ?>">
                    <small style="color: var(--fg2); margin-top: 4px; display: block;">Supports auto tag-icon mapping on the frontend.</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Card Background Cover Graphic Image</label>
                    <div class="image-preview-box">
                        <img src="../<?php echo htmlspecialchars($edit_card['image_path']); ?>" alt="">
                        <div>
                            <input type="file" name="dest_card_img">
                            <small style="display: block; color: var(--fg2); margin-top: 4px;">Leave empty to keep current image. Recommended size: 600x400px (WEBP/PNG/JPG)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button type="submit" name="edit_destination" class="btn-save">
                    <i class="fa-solid fa-circle-check"></i> Save Card Changes
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
function switchTab(evt, tabId) {
    const sections = document.getElementsByClassName("editor-section");
    for (let i = 0; i < sections.length; i++) {
        sections[i].classList.remove("active");
    }

    const buttons = document.getElementsByClassName("tab-btn");
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove("active");
    }

    document.getElementById(tabId).classList.add("active");
    evt.currentTarget.classList.add("active");
}
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
