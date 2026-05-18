<?php
/**
 * Global Site Settings Editor
 */
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/header.php'; // Triggers auth check

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings_to_update = [
        'whatsapp_number',
        'site_phone',
        'site_email',
        'social_linkedin',
        'social_instagram',
        'social_facebook',
        'social_youtube',
        'header_scripts',
        'footer_scripts'
    ];

    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) 
                               VALUES (:key, :val) 
                               ON DUPLICATE KEY UPDATE setting_value = :val2");
        foreach ($settings_to_update as $key) {
            if (isset($_POST[$key])) {
                $stmt->execute([
                    'key' => $key,
                    'val' => $_POST[$key],
                    'val2' => $_POST[$key]
                ]);
            }
        }

        $pdo->commit();
        $success_msg = "Global site settings updated successfully!";
        
        // Reset local query cache
        $site_settings_cache = null; 
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error_msg = "Update failed: " . $e->getMessage();
    }
}
?>

<style>
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
    textarea.form-control {
        font-family: 'Courier New', Courier, monospace;
        font-size: 13px;
        background: #0f172a;
        color: #38bdf8;
    }
</style>

<div class="editor-container">
    <form action="" method="POST">
        <div class="editor-header">
            <div>
                <h1>Global Site Settings</h1>
                <p style="color: var(--fg2); font-size: 13px; margin-top: 4px;">Manage dynamic phone numbers, social profiles, tracking tags, and verification scripts.</p>
            </div>
            <button type="submit" class="btn-save">
                <i class="fa-solid fa-floppy-disk"></i> Save Site Settings
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
            <button type="button" class="tab-btn active" onclick="switchTab(event, 'tab-contacts')"><i class="fa-solid fa-phone"></i> Contacts & WhatsApp</button>
            <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-socials')"><i class="fa-solid fa-share-nodes"></i> Social Links</button>
            <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-scripts')"><i class="fa-solid fa-code"></i> Header & Footer Scripts</button>
        </div>

        <!-- TAB 1: CONTACTS -->
        <div id="tab-contacts" class="editor-section active">
            <div class="form-card">
                <div class="form-card-title">Contact & Communication Details</div>
                
                <div class="form-group">
                    <label class="form-label">WhatsApp Floating Button Phone Number (Include country code, digits only - e.g. 919113515462)</label>
                    <input type="text" name="whatsapp_number" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('whatsapp_number', '919113515462')); ?>" required placeholder="e.g. 919113515462">
                    <small style="color: var(--fg2); margin-top: 6px; display: block;">This controls the floating button link and header "Get Proposal" button redirects.</small>
                </div>

                <div class="grid-2" style="margin-top: 20px;">
                    <div class="form-group">
                        <label class="form-label">Site Contact Phone (Visible in Footer - e.g. +91 91135 15462)</label>
                        <input type="text" name="site_phone" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('site_phone', '+91 91135 15462')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Site Contact Email (e.g. info@wanderoo.in)</label>
                        <input type="email" name="site_email" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('site_email', 'info@wanderoo.in')); ?>" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: SOCIAL LINKS -->
        <div id="tab-socials" class="editor-section">
            <div class="form-card">
                <div class="form-card-title">Social Media Profiles</div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fa-brands fa-linkedin" style="color: #0a66c2;"></i> LinkedIn Profile Link</label>
                    <input type="text" name="social_linkedin" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('social_linkedin', '#')); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fa-brands fa-instagram" style="color: #e1306c;"></i> Instagram Profile Link</label>
                    <input type="text" name="social_instagram" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('social_instagram', '#')); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fa-brands fa-facebook" style="color: #1877f2;"></i> Facebook Profile Link</label>
                    <input type="text" name="social_facebook" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('social_facebook', '#')); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fa-brands fa-youtube" style="color: #ff0000;"></i> YouTube Channel Link</label>
                    <input type="text" name="social_youtube" class="form-control" value="<?php echo htmlspecialchars(get_site_setting('social_youtube', '#')); ?>">
                </div>
            </div>
        </div>

        <!-- TAB 3: CUSTOM SCRIPTS -->
        <div id="tab-scripts" class="editor-section">
            <div class="form-card">
                <div class="form-card-title">Custom Header Scripts</div>
                <div class="form-group">
                    <label class="form-label">Head Verification Scripts (Injected right before &lt;/head&gt;)</label>
                    <textarea name="header_scripts" class="form-control" rows="8" placeholder="Paste Google Analytics, Search Console, Tag Manager tags here..."><?php echo htmlspecialchars(get_site_setting('header_scripts', '')); ?></textarea>
                    <small style="color: var(--fg2); margin-top: 6px; display: block;">Perfect for Google Search Console &lt;meta name="google-site-verification" ...&gt; or global analytics triggers.</small>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title">Custom Footer Scripts</div>
                <div class="form-group">
                    <label class="form-label">Body Footer Scripts (Injected right before &lt;/body&gt;)</label>
                    <textarea name="footer_scripts" class="form-control" rows="8" placeholder="Paste custom chatbot widgets, tracking pixels, or JS scripts here..."><?php echo htmlspecialchars(get_site_setting('footer_scripts', '')); ?></textarea>
                    <small style="color: var(--fg2); margin-top: 6px; display: block;">Great for live chat float scripts, hotjar analytics, or social advertising pixels.</small>
                </div>
            </div>
        </div>
    </form>
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
