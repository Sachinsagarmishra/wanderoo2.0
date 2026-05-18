<?php 
/**
 * Premium Admin Dashboard Workspace
 */
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/header.php'; // This handles authentication check

// Calculate dynamic stats
$dest_count = 0;
try {
    $dest_count = $pdo->query("SELECT COUNT(*) FROM `destinations`")->fetchColumn();
} catch (PDOException $e) {}

$case_count = 0;
try {
    $case_count = $pdo->query("SELECT COUNT(*) FROM `case_studies`")->fetchColumn();
} catch (PDOException $e) {}

$settings_count = 0;
try {
    $settings_count = $pdo->query("SELECT COUNT(*) FROM `site_settings`")->fetchColumn();
} catch (PDOException $e) {}

// Get last 3 destinations
$recent_dests = [];
try {
    $recent_dests = $pdo->query("SELECT * FROM `destinations` ORDER BY `id` DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}

// Get last 3 case studies
$recent_cases = [];
try {
    $recent_cases = $pdo->query("SELECT * FROM `case_studies` ORDER BY `id` DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}

?>

<style>
    .welcome-banner {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        color: #FFFFFF;
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 35px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15);
        border: 1px solid #334155;
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(249,115,22,0.15) 0%, rgba(249,115,22,0) 70%);
        pointer-events: none;
    }
    .welcome-banner h1 {
        color: #FFFFFF;
        font-size: 32px;
        margin-bottom: 8px;
    }
    .welcome-banner p {
        color: #94A3B8;
        font-size: 15px;
        max-width: 600px;
        line-height: 1.6;
    }
    
    /* Stats layout overrides */
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }
    .dashboard-stat-card {
        background: #FFFFFF;
        border: 1px solid var(--border);
        border-radius: var(--radius-main);
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 2%), 0 2px 4px -2px rgb(0 0 0 / 2%);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .dashboard-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -8px rgba(15,23,42,0.08);
    }
    .stat-details h3 {
        font-size: 12px;
        color: var(--fg2);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 6px;
    }
    .stat-details .stat-val {
        font-size: 32px;
        font-weight: 700;
        color: var(--fg);
        line-height: 1;
    }
    .stat-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .stat-icon-wrapper.orange { background: #FFF7ED; color: #F97316; }
    .stat-icon-wrapper.blue { background: #EEF2FF; color: #4F46E5; }
    .stat-icon-wrapper.green { background: #F0FDF4; color: #16A34A; }
    .stat-icon-wrapper.teal { background: #F0FDFA; color: #0D9488; }
    
    /* Layout grid columns */
    .dashboard-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-bottom: 40px;
    }
    .grid-column {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    
    /* Custom Quick Action Cards */
    .action-panel-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    .action-card {
        background: #FFFFFF;
        border: 1px solid var(--border);
        border-radius: var(--radius-int);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.2s;
    }
    .action-card:hover {
        border-color: var(--accent);
        background: var(--bg2);
    }
    .action-card-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .action-card-icon.accent { background: rgba(249,115,22,0.1); color: var(--accent); }
    .action-card-icon.blue { background: rgba(59,130,246,0.1); color: var(--info); }
    .action-card-icon.green { background: rgba(34,197,94,0.1); color: var(--success); }
    
    /* Destinations List styling */
    .quick-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
    }
    .quick-list-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .quick-list-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .quick-list-thumb {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid var(--border);
    }
    .quick-list-details h4 {
        font-size: 14px;
        font-weight: 600;
        color: var(--fg);
    }
    .quick-list-details p {
        font-size: 12px;
        color: var(--fg2);
        margin-top: 2px;
    }
    
    /* Support developer card */
    .support-card {
        background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 100%);
        border: 1px solid #FED7AA;
        padding: 24px;
        border-radius: var(--radius-main);
        position: relative;
    }
    .support-card h3 {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        color: #7C2D12;
        margin-bottom: 10px;
    }
    .support-card p {
        font-size: 13px;
        color: #9A3412;
        line-height: 1.5;
        margin-bottom: 15px;
    }
    .btn-support {
        background: #25D366;
        color: #FFFFFF;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 18px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-support:hover {
        background: #20BA5A;
    }

    @media (max-width: 1024px) {
        .dashboard-stats {
            grid-template-columns: 1fr 1fr;
        }
        .dashboard-row {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 600px) {
        .dashboard-stats {
            grid-template-columns: 1fr;
        }
        .action-panel-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="welcome-banner">
    <h1>Welcome back, Chief Explorer! 👋</h1>
    <p>This is Wanderoo's command centre. From here, you can dynamically customize your front-end pages, upload fresh destinations, maintain client case study portfolios, and edit live settings seamlessly.</p>
</div>

<!-- STATS BAR -->
<div class="dashboard-stats">
    <div class="dashboard-stat-card">
        <div class="stat-details">
            <h3>Destinations</h3>
            <div class="stat-val"><?php echo $dest_count; ?></div>
        </div>
        <div class="stat-icon-wrapper orange">
            <i class="fa-solid fa-map-location-dot"></i>
        </div>
    </div>

    <div class="dashboard-stat-card">
        <div class="stat-details">
            <h3>Case Studies</h3>
            <div class="stat-val"><?php echo $case_count; ?></div>
        </div>
        <div class="stat-icon-wrapper blue">
            <i class="fa-solid fa-folder-open"></i>
        </div>
    </div>

    <div class="dashboard-stat-card">
        <div class="stat-details">
            <h3>CMS Settings</h3>
            <div class="stat-val"><?php echo $settings_count; ?></div>
        </div>
        <div class="stat-icon-wrapper teal">
            <i class="fa-solid fa-gear"></i>
        </div>
    </div>

    <div class="dashboard-stat-card">
        <div class="stat-details">
            <h3>Server Status</h3>
            <div class="stat-val" style="font-size: 16px; color: var(--success); display:flex; align-items:center; gap:6px; margin-top:8px;">
                <i class="fa-solid fa-circle" style="font-size: 10px;"></i> MySQL Active
            </div>
        </div>
        <div class="stat-icon-wrapper green">
            <i class="fa-solid fa-server"></i>
        </div>
    </div>
</div>

<!-- SECOND ROW LAYOUT -->
<div class="dashboard-row">
    
    <!-- LEFT PANEL: Dynamic lists of destinations and case studies -->
    <div class="grid-column">
        
        <!-- Recent Destinations Preview -->
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px; border-bottom:1px solid var(--border); padding-bottom:10px;">
                <h3 style="font-family: var(--font-display); font-size:18px; font-weight:700;"><i class="fa-solid fa-compass" style="color: var(--accent); margin-right:6px;"></i> Recently Added Destinations</h3>
                <a href="destination-editor.php" style="color: var(--accent); font-size: 12px; font-weight:700;">Manage All →</a>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 5px;">
                <?php if (empty($recent_dests)): ?>
                    <p style="color: var(--fg2); text-align:center; padding: 20px 0;">No destinations in database yet.</p>
                <?php else: ?>
                    <?php foreach ($recent_dests as $d): ?>
                        <div class="quick-list-item">
                            <div class="quick-list-info">
                                <img class="quick-list-thumb" src="../<?php echo htmlspecialchars($d['image_path']); ?>" alt="thumbnail">
                                <div class="quick-list-details">
                                    <h4><?php echo htmlspecialchars($d['title']); ?></h4>
                                    <p>Duration: <span style="font-family:monospace; color: var(--accent); font-weight:600;"><?php echo htmlspecialchars($d['duration']); ?></span> · Tags: <?php echo htmlspecialchars($d['tags']); ?></p>
                                </div>
                            </div>
                            <a href="destination-editor.php" class="btn-edit" style="font-size: 11px;"><i class="fa-solid fa-pen"></i> Edit</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Case Studies Preview -->
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px; border-bottom:1px solid var(--border); padding-bottom:10px;">
                <h3 style="font-family: var(--font-display); font-size:18px; font-weight:700;"><i class="fa-solid fa-folder-open" style="color: var(--info); margin-right:6px;"></i> Latest Corporate Portfolio Cases</h3>
                <a href="homepage-editor.php?tab=tab-case" style="color: var(--info); font-size: 12px; font-weight:700;">Manage Cases →</a>
            </div>
            
            <div style="overflow-x: auto;">
                <table class="crud-table" style="width:100%;">
                    <thead>
                        <tr style="background: none;">
                            <th style="padding-left:0; font-size:11px;">Client Name</th>
                            <th style="font-size:11px;">Badge Tag</th>
                            <th style="font-size:11px;">Trip Scale</th>
                            <th style="text-align: right; padding-right:0; font-size:11px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recent_cases)): ?>
                            <tr>
                                <td colspan="4" style="text-align:center; color: var(--fg2); padding: 20px 0;">No case studies available.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_cases as $rc): ?>
                                <tr>
                                    <td style="padding-left:0; font-weight:700; color: var(--fg);"><?php echo htmlspecialchars($rc['client_name']); ?></td>
                                    <td>
                                        <span class="badge <?php 
                                            if ($rc['badge_color'] === 'green') echo 'badge-success';
                                            elseif ($rc['badge_color'] === 'red') echo 'badge-danger';
                                            elseif ($rc['badge_color'] === 'purple') echo 'badge-info';
                                            else echo 'badge-warning'; // Fallback / Orange
                                        ?>" style="font-size: 10px; font-weight:700; padding: 2px 6px;">
                                            <?php echo htmlspecialchars($rc['badge_flag'] . ' ' . $rc['badge_text']); ?>
                                        </span>
                                    </td>
                                    <td><span style="font-size:12px; color: var(--fg2);"><?php echo htmlspecialchars($rc['case_type']); ?></span></td>
                                    <td style="text-align:right; padding-right:0;">
                                        <a href="homepage-editor.php?tab=tab-case&sub=edit&id=<?php echo $rc['id']; ?>" style="color: var(--accent); font-weight:700; font-size:11px;">Edit Card</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- RIGHT PANEL: Action items & WhatsApp details -->
    <div class="grid-column">
        
        <!-- Quick Action list links -->
        <div class="card">
            <h3 style="font-family: var(--font-display); font-size:16px; font-weight:700; margin-bottom:20px; border-bottom:1px solid var(--border); padding-bottom:10px;"><i class="fa-solid fa-bolt" style="color: var(--accent); margin-right:6px;"></i> Quick Admin Actions</h3>
            
            <div class="action-panel-grid">
                <a href="homepage-editor.php" class="action-card">
                    <div class="action-card-icon accent">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <div style="flex:1;">
                        <h4 style="font-size: 13px; font-weight:700;">Edit Home</h4>
                    </div>
                </a>

                <a href="about-editor.php" class="action-card">
                    <div class="action-card-icon blue">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div style="flex:1;">
                        <h4 style="font-size: 13px; font-weight:700;">Edit About</h4>
                    </div>
                </a>

                <a href="destination-editor.php" class="action-card">
                    <div class="action-card-icon green">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <div style="flex:1;">
                        <h4 style="font-size: 13px; font-weight:700;">Edit Dest</h4>
                    </div>
                </a>

                <a href="settings.php" class="action-card">
                    <div class="action-card-icon accent">
                        <i class="fa-solid fa-gears"></i>
                    </div>
                    <div style="flex:1;">
                        <h4 style="font-size: 13px; font-weight:700;">Settings</h4>
                    </div>
                </a>
            </div>
        </div>

        <!-- Premium Developer Support card -->
        <div class="support-card">
            <h3>Need CMS Assistance? 🛠️</h3>
            <p>Our dev support is active for live adjustments. If you require custom integrations, database seeding, or design tweaks, let us know instantly on WhatsApp.</p>
            <button class="btn-support" onclick="window.open('https://wa.me/919113515462', '_blank')">
                <i class="fa-brands fa-whatsapp" style="font-size: 18px;"></i> CHAT DEV SUPPORT
            </button>
        </div>

        <!-- System environment details card -->
        <div class="card" style="padding:20px;">
            <h4 style="font-size: 13px; font-weight: 700; margin-bottom: 12px; color: var(--fg); border-bottom: 1px solid var(--border); padding-bottom: 8px;">Workspace Context</h4>
            <div style="display:flex; flex-direction:column; gap:8px; font-size:12px; color: var(--fg2);">
                <div style="display:flex; justify-content:space-between;"><span>Environment</span><strong style="color:var(--success);">Production</strong></div>
                <div style="display:flex; justify-content:space-between;"><span>PHP Version</span><strong><?php echo phpversion(); ?></strong></div>
                <div style="display:flex; justify-content:space-between;"><span>Timezone</span><strong><?php echo date_default_timezone_get(); ?></strong></div>
                <div style="display:flex; justify-content:space-between;"><span>Local Time</span><strong><?php echo date('h:i A'); ?></strong></div>
            </div>
        </div>

    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
