<?php
/**
 * North AI Agent Settings & Leads Dashboard
 */
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/header.php'; // Auth check triggers

$success_msg = '';
$error_msg = '';

// Handle AJAX dynamic Captured Lead Deletion Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    if ($_POST['action'] === 'delete_lead' && isset($_POST['lead_id'])) {
        $lead_id = intval($_POST['lead_id']);
        try {
            $stmt = $pdo->prepare("DELETE FROM `captured_leads` WHERE `id` = :id");
            $stmt->execute(['id' => $lead_id]);
            echo json_encode(['success' => true, 'message' => 'Lead successfully deleted from the database.']);
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }
    
    if ($_POST['action'] === 'bulk_delete_leads' && isset($_POST['lead_ids'])) {
        $lead_ids = array_map('intval', explode(',', $_POST['lead_ids']));
        if (!empty($lead_ids)) {
            try {
                $placeholders = implode(',', array_fill(0, count($lead_ids), '?'));
                $stmt = $pdo->prepare("DELETE FROM `captured_leads` WHERE `id` IN ($placeholders)");
                $stmt->execute($lead_ids);
                echo json_encode(['success' => true, 'message' => count($lead_ids) . ' leads successfully deleted from the database.']);
                exit;
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }
    }
}

// Handle save settings form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_agent_settings'])) {
    $keys_to_update = [
        'agent_name',
        'agent_role',
        'agent_logo',
        'gemini_api_key',
        'system_prompt',
        'custom_knowledge'
    ];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO `agent_settings` (`setting_key`, `setting_value`) 
                               VALUES (:key, :val) 
                               ON DUPLICATE KEY UPDATE `setting_value` = :val2");
                               
        foreach ($keys_to_update as $key) {
            if (isset($_POST[$key])) {
                $stmt->execute([
                    'key' => $key,
                    'val' => $_POST[$key],
                    'val2' => $_POST[$key]
                ]);
            }
        }

        // Handle dynamic calculations pricing matrix updates
        if (isset($_POST['dom_std']) && isset($_POST['dom_del']) && isset($_POST['dom_pre']) &&
            isset($_POST['intl_std']) && isset($_POST['intl_del']) && isset($_POST['intl_pre'])) {
            
            $rates = [
                'domestic' => [
                    'standard' => intval($_POST['dom_std']),
                    'deluxe' => intval($_POST['dom_del']),
                    'premium' => intval($_POST['dom_pre'])
                ],
                'international' => [
                    'standard' => intval($_POST['intl_std']),
                    'deluxe' => intval($_POST['intl_del']),
                    'premium' => intval($_POST['intl_pre'])
                ]
            ];
            
            $rates_json = json_encode($rates);
            $stmt->execute([
                'key' => 'default_pricing_rates',
                'val' => $rates_json,
                'val2' => $rates_json
            ]);
        }

        // Handle suggestions dynamic cards updates
        if (isset($_POST['sug_title']) && is_array($_POST['sug_title'])) {
            $suggestions_to_save = [];
            for ($i = 0; $i < count($_POST['sug_title']); $i++) {
                $suggestions_to_save[] = [
                    'id' => $_POST['sug_id'][$i] ?? ('sug_' . ($i + 1)),
                    'title' => $_POST['sug_title'][$i] ?? '',
                    'subtitle' => $_POST['sug_subtitle'][$i] ?? '',
                    'prompt' => $_POST['sug_prompt'][$i] ?? ''
                ];
            }
            $suggestions_json_to_save = json_encode($suggestions_to_save);
            $stmt->execute([
                'key' => 'agent_suggestions',
                'val' => $suggestions_json_to_save,
                'val2' => $suggestions_json_to_save
            ]);
        }

        $pdo->commit();
        $success_msg = "North AI Agent settings and pre-questions saved successfully!";
        
        // Reset query cache
        $agent_settings_cache = null;
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error_msg = "Failed to update agent knowledge: " . $e->getMessage();
    }
}

// Fetch current agent configurations
$agent_name = get_agent_setting('agent_name', 'North AI');
$agent_role = get_agent_setting('agent_role', 'Your event planning advisor');
$agent_logo = get_agent_setting('agent_logo', 'assets/img/nothai.png');
$gemini_api_key = get_agent_setting('gemini_api_key', '');
$system_prompt = get_agent_setting('system_prompt', '');
$custom_knowledge = get_agent_setting('custom_knowledge', '');

$default_pricing_rates = json_decode(get_agent_setting('default_pricing_rates', '{}'), true);
$dom_rates = $default_pricing_rates['domestic'] ?? ['standard' => 4500, 'deluxe' => 6500, 'premium' => 9500];
$intl_rates = $default_pricing_rates['international'] ?? ['standard' => 5500, 'deluxe' => 7150, 'premium' => 10725];

// Fetch agent suggestion pre-questions
$agent_suggestions_json = get_agent_setting('agent_suggestions', '[]');
$admin_suggestions = json_decode($agent_suggestions_json, true);
if (!is_array($admin_suggestions) || count($admin_suggestions) === 0) {
    $admin_suggestions = [
        ["id" => "goa", "title" => "🌴 Goa offsite", "subtitle" => "50 pax · 3 nights · Premium", "prompt" => "Plan an offsite in Goa for 50 people, 3 nights Standard pricing"],
        ["id" => "coorg", "title" => "🏔️ Coorg retreat", "subtitle" => "30 pax leadership", "prompt" => "Plan a Coorg retreat for 30 pax leadership team"],
        ["id" => "phuket", "title" => "✈️ Phuket international", "subtitle" => "60 pax · 4 nights", "prompt" => "Plan an international offsite in Phuket for 60 people, 4 nights Premium package"],
        ["id" => "bali", "title" => "🌴 Bali offsite", "subtitle" => "40 pax · Premium", "prompt" => "Plan an international offsite in Bali for 40 people, 5 nights"],
        ["id" => "munnar", "title" => "🏔️ Munnar wellness", "subtitle" => "25 pax · 3 nights", "prompt" => "We want a Munnar wellness retreat for 25 pax, 3 nights"],
        ["id" => "teambuilding", "title" => "🎯 Team building", "subtitle" => "Activities & formats", "prompt" => "What team building formats do you offer at Wanderoo?"]
    ];
}

// Fetch dynamic captured leads
$leads = [];
try {
    $leads = $pdo->query("SELECT * FROM `captured_leads` ORDER BY `id` DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}
?>

<style>
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
        font-family: var(--font-display);
        font-size: 28px;
        font-weight: 700;
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
        align-items: center;
        gap: 8px;
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
        transition: all 0.2s;
    }
    .form-control:focus {
        border-color: var(--accent);
        outline: none;
        box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.1);
    }
    
    /* Layout grid for parameters */
    .parameters-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .pricing-matrix {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
    
    @media (max-width: 768px) {
        .parameters-grid {
            grid-template-columns: 1fr;
        }
        .pricing-matrix {
            grid-template-columns: 1fr;
        }
    }
    
    /* Advanced Captured Leads Dashboard Styles */
    .leads-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        background: var(--bg2);
        padding: 15px;
        border-radius: 8px;
        border: 1px solid var(--border);
    }
    .search-box-container {
        position: relative;
        flex-grow: 1;
        max-width: 400px;
    }
    .search-box-container i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--fg2);
        font-size: 14px;
    }
    .leads-search-input {
        width: 100%;
        padding: 10px 12px 10px 38px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--bg);
        color: var(--fg);
        font-size: 13px;
        outline: none;
        transition: border 0.2s;
    }
    .leads-search-input:focus {
        border-color: var(--accent);
    }
    
    .bulk-action-banner {
        display: none;
        align-items: center;
        justify-content: space-between;
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.2);
        padding: 12px 20px;
        border-radius: 8px;
        color: #ef4444;
        font-size: 13px;
        font-weight: 600;
        width: 100%;
        margin-bottom: 20px;
        animation: fadeIn 0.2s ease;
    }
    
    .btn-delete-lead {
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.2s;
    }
    .btn-delete-lead:hover {
        background: rgba(239, 68, 68, 0.1);
    }
    
    .btn-bulk-delete {
        background: #ef4444;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .btn-bulk-delete:hover {
        background: #dc2626;
    }
    
    .leads-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid var(--border);
        flex-wrap: wrap;
        gap: 15px;
    }
    .pagination-info {
        font-size: 12px;
        color: var(--fg2);
    }
    .pagination-controls {
        display: flex;
        gap: 5px;
        align-items: center;
    }
    .page-link {
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid var(--border);
        background: var(--bg);
        color: var(--fg);
        font-size: 12px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
    }
    .page-link:hover {
        border-color: var(--accent);
        color: var(--accent);
    }
    .page-link.active {
        background: var(--accent);
        color: #ffffff;
        border-color: var(--accent);
    }
    .page-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .lead-checkbox {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: var(--accent);
    }

    /* Beautiful Confirmation Modal Overlay */
    .custom-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 99999;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .custom-modal-overlay.show {
        display: flex;
        opacity: 1;
    }
    .custom-modal {
        background: var(--bg);
        border: 1px solid var(--border);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3), 0 10px 10px -5px rgba(0,0,0,0.2);
        border-radius: 12px;
        max-width: 420px;
        width: 90%;
        padding: 24px;
        text-align: center;
        transform: scale(0.95);
        transition: transform 0.2s ease;
    }
    .custom-modal-overlay.show .custom-modal {
        transform: scale(1);
    }
    .modal-icon {
        font-size: 40px;
        color: #ef4444;
        margin-bottom: 15px;
    }
    .modal-title {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        color: var(--fg);
        margin-bottom: 8px;
    }
    .modal-text {
        font-size: 13px;
        color: var(--fg2);
        line-height: 1.5;
        margin-bottom: 20px;
    }
    .modal-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
    }
    .btn-modal-cancel {
        background: var(--bg2);
        color: var(--fg);
        border: 1px solid var(--border);
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.2s;
    }
    .btn-modal-cancel:hover {
        background: var(--bg3);
    }
    .btn-modal-confirm {
        background: #ef4444;
        color: #ffffff;
        border: none;
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: 700;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.2s;
    }
    .btn-modal-confirm:hover {
        background: #dc2626;
    }
</style>

<div class="editor-container">
    <form action="" method="POST">
        <div class="editor-header">
            <div>
                <h1><i class="fa-solid fa-wand-magic-sparkles" style="color: var(--accent); margin-right: 6px;"></i> North AI Agent Manager</h1>
                <p style="font-size: 13px; color: var(--fg2); margin-top: 4px;">Train, prompt, configure calculation parameters, and manage corporate leads for your smart travel advisor.</p>
            </div>
            <button type="submit" name="save_agent_settings" class="btn-save">
                <i class="fa-solid fa-floppy-disk"></i> Save Settings
            </button>
        </div>

        <?php if (!empty($success_msg)): ?>
            <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?php echo $success_msg; ?></div>
        <?php endif; ?>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger"><i class="fa-solid fa-circle-xmark"></i> <?php echo $error_msg; ?></div>
        <?php endif; ?>

        <!-- NAVIGATION TABS -->
        <div class="tab-nav">
            <button type="button" class="tab-btn active" onclick="switchSection('persona', this)">Persona & Configuration</button>
            <button type="button" class="tab-btn" onclick="switchSection('knowledge', this)">Agent Prompt & Knowledge Base</button>
            <button type="button" class="tab-btn" onclick="switchSection('suggestions', this)">Pre-Questions Grid</button>
            <button type="button" class="tab-btn" onclick="switchSection('leads', this)">Captured Proposal Leads (<?php echo count($leads); ?>)</button>
        </div>

        <!-- 1. PERSONA TAB -->
        <div id="section-persona" class="editor-section active">
            <div class="parameters-grid">
                <!-- Left Side: Custom Appearance -->
                <div class="form-card">
                    <div class="form-card-title"><i class="fa-solid fa-robot"></i> Advisor Identity</div>
                    
                    <div class="form-group">
                        <label class="form-label" for="agent_name">Agent Identifier Name</label>
                        <input type="text" class="form-control" id="agent_name" name="agent_name" value="<?php echo htmlspecialchars($agent_name); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="agent_role">Advisor Subtext Role</label>
                        <input type="text" class="form-control" id="agent_role" name="agent_role" value="<?php echo htmlspecialchars($agent_role); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="agent_logo">Agent Avatar Icon Path</label>
                        <input type="text" class="form-control" id="agent_logo" name="agent_logo" value="<?php echo htmlspecialchars($agent_logo); ?>" required>
                        <p style="font-size: 11px; color: var(--fg2); margin-top: 4px;">Dynamic site path to the avatar illustration. Currently loaded: <code><?php echo htmlspecialchars($agent_logo); ?></code></p>
                    </div>
                </div>

                <!-- Right Side: API Core credentials -->
                <div class="form-card">
                    <div class="form-card-title"><i class="fa-solid fa-key"></i> LLM Credentials</div>
                    
                    <div class="form-group">
                        <label class="form-label" for="gemini_api_key">Google Gemini 1.5 Flash API Key</label>
                        <input type="password" class="form-control" id="gemini_api_key" name="gemini_api_key" value="<?php echo htmlspecialchars($gemini_api_key); ?>" placeholder="Paste your AI Studio API key here">
                        <p style="font-size: 11px; color: var(--fg2); margin-top: 6px;">Used to call the free Gemini 1.5 Flash assistant model securely from your Hostinger server backend. Paste your key from Google AI Studio.</p>
                    </div>
                </div>
            </div>

            <!-- Dynamic Pricing Rules Configurations -->
            <div class="form-card">
                <div class="form-card-title"><i class="fa-solid fa-calculator"></i> Indicative Pricing Matrix (₹ Per Pax Per Night)</div>
                <p style="font-size: 12px; color: var(--fg2); margin-bottom: 20px;">These values are passed as strict context constraints to the LLM agent to calculate instant standard, deluxe, and premium proposal tables.</p>
                
                <div class="parameters-grid">
                    <div>
                        <h4 style="font-size: 13px; font-weight: 700; color: var(--fg); margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 5px;">Domestic Destinations (Goa, Munnar, Coorg etc.)</h4>
                        <div class="pricing-matrix">
                            <div class="form-group">
                                <label class="form-label">Standard (₹)</label>
                                <input type="number" class="form-control" name="dom_std" value="<?php echo intval($dom_rates['standard']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Deluxe (₹)</label>
                                <input type="number" class="form-control" name="dom_del" value="<?php echo intval($dom_rates['deluxe']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Premium (₹)</label>
                                <input type="number" class="form-control" name="dom_pre" value="<?php echo intval($dom_rates['premium']); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 style="font-size: 13px; font-weight: 700; color: var(--fg); margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 5px;">International Destinations (Phuket, Bali, Alps etc.)</h4>
                        <div class="pricing-matrix">
                            <div class="form-group">
                                <label class="form-label">Standard (₹)</label>
                                <input type="number" class="form-control" name="intl_std" value="<?php echo intval($intl_rates['standard']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Deluxe (₹)</label>
                                <input type="number" class="form-control" name="intl_del" value="<?php echo intval($intl_rates['deluxe']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Premium (₹)</label>
                                <input type="number" class="form-control" name="intl_pre" value="<?php echo intval($intl_rates['premium']); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. KNOWLEDGE TAB -->
        <div id="section-knowledge" class="editor-section">
            <div class="form-card">
                <div class="form-card-title"><i class="fa-solid fa-brain"></i> Agent System Instructions (The Brain Prompt)</div>
                <div class="form-group">
                    <textarea class="form-control" id="system_prompt" name="system_prompt" rows="8" style="font-family: monospace; font-size: 12px; line-height: 1.5;" required><?php echo htmlspecialchars($system_prompt); ?></textarea>
                    <p style="font-size: 11px; color: var(--fg2); margin-top: 6px;">This sets the primary rules for how North AI interacts with customers. Instructs on tone, pricing formatting rules, dynamic calculations, and captured lead flows.</p>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fa-solid fa-book-open"></i> Customized Knowledge Base Document Context</div>
                <div class="form-group">
                    <label class="form-label" for="custom_knowledge">Append Context Documents (Text/FAQ/Itineraries)</label>
                    <textarea class="form-control" id="custom_knowledge" name="custom_knowledge" rows="12" style="line-height: 1.5;" placeholder="Paste company history, customized guidelines, exclusive vendor hotels lists, specialized itinerary summaries..."><?php echo htmlspecialchars($custom_knowledge); ?></textarea>
                    <p style="font-size: 11px; color: var(--fg2); margin-top: 6px;">This custom knowledge is dynamically appended to the AI prompt context in real-time, functioning as a lightweight RAG system. The AI agent will instantly know these facts and details!</p>
                </div>
            </div>
        </div>

        <!-- 3. PRE-QUESTIONS TAB -->
        <div id="section-suggestions" class="editor-section">
            <div class="form-card">
                <div class="form-card-title"><i class="fa-solid fa-list-check" style="color: var(--accent);"></i> Pre-Questions Suggestion Chips Grid (6 Cards Option)</div>
                <p style="font-size: 13px; color: var(--fg2); margin-bottom: 25px;">These are the 6 suggestion chips presented to users when they first load North AI. They make starting conversations quick and effortless!</p>
                
                <div class="parameters-grid" style="grid-template-columns: 1fr 1fr; gap: 24px;">
                    <?php foreach ($admin_suggestions as $index => $s): ?>
                        <div class="form-card" style="background: var(--bg2); border: 1.5px dashed var(--border); padding: 18px; margin-bottom: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                                <h4 style="font-size: 13px; font-weight: 700; color: var(--accent); margin: 0;">📍 Card Option #<?php echo ($index + 1); ?></h4>
                                <input type="hidden" name="sug_id[]" value="<?php echo htmlspecialchars($s['id']); ?>">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label class="form-label" style="font-size: 11px;">Card Icon & Title Label</label>
                                <input type="text" class="form-control" name="sug_title[]" value="<?php echo htmlspecialchars($s['title']); ?>" required placeholder="e.g. 🌴 Goa offsite">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label class="form-label" style="font-size: 11px;">Card Subtitle Description</label>
                                <input type="text" class="form-control" name="sug_subtitle[]" value="<?php echo htmlspecialchars($s['subtitle']); ?>" required placeholder="e.g. 50 pax · 3 nights">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 11px;">Click-Submit AI Prompt Message</label>
                                <textarea class="form-control" name="sug_prompt[]" rows="2" style="font-size: 12px; line-height: 1.4;" required placeholder="What prompt message should this button execute in AI chat?"><?php echo htmlspecialchars($s['prompt']); ?></textarea>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </form>

    <!-- 4. LEADS TAB -->
    <div id="section-leads" class="editor-section">
        <!-- Floating/Top Banner for Bulk Delete Actions -->
        <div id="leads-bulk-banner" class="bulk-action-banner">
            <div>
                <i class="fa-solid fa-circle-exclamation"></i> 
                <span id="selected-leads-count">0</span> leads selected for bulk actions.
            </div>
            <button type="button" class="btn-bulk-delete" onclick="confirmBulkDelete()">
                <i class="fa-solid fa-trash-can"></i> Delete Selected Leads
            </button>
        </div>

        <div class="form-card">
            <div class="form-card-title" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 10px;">
                <span><i class="fa-solid fa-id-card-clip" style="color: var(--accent);"></i> Captured Corporate Proposal Leads</span>
            </div>
            <p style="font-size: 13px; color: var(--fg2); margin-bottom: 20px;">Whenever a corporate planner uses North AI to calculate an offsite budget and requests a customized proposal, their contact details are logged here.</p>

            <!-- Toolbar containing Search and Page Size Filter -->
            <div class="leads-toolbar">
                <div class="search-box-container">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="leads-search" class="leads-search-input" placeholder="Search by name, email, WhatsApp, or retreat details..." oninput="handleLeadsSearch()">
                </div>
                <div style="font-size: 13px; color: var(--fg2); display: flex; align-items: center; gap: 8px;">
                    <span>Rows per page:</span>
                    <select id="leads-limit" style="padding: 6px 10px; border-radius: 6px; border: 1px solid var(--border); background: var(--bg); color: var(--fg); cursor: pointer;" onchange="changeLeadsLimit()">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>

            <!-- Sleek Dynamic Alert Message Banner -->
            <div id="leads-alert-success" class="alert alert-success" style="display: none; margin-bottom: 15px;"></div>
            <div id="leads-alert-error" class="alert alert-danger" style="display: none; margin-bottom: 15px;"></div>

            <div style="overflow-x: auto;">
                <table class="crud-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 40px; padding: 12px; text-align: center;">
                                <input type="checkbox" id="select-all-leads" class="lead-checkbox" onchange="toggleSelectAllLeads(this)">
                            </th>
                            <th style="padding: 12px; font-size: 12px;">Submitted Date</th>
                            <th style="padding: 12px; font-size: 12px;">Client Name</th>
                            <th style="padding: 12px; font-size: 12px;">Work Email</th>
                            <th style="padding: 12px; font-size: 12px;">WhatsApp Line</th>
                            <th style="padding: 12px; font-size: 12px;">Captured Context</th>
                            <th style="padding: 12px; font-size: 12px; width: 60px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="leads-table-body">
                        <!-- Dynamic content populated via JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Sleek Pagination Layout -->
            <div class="leads-pagination">
                <div class="pagination-info" id="leads-pagination-info">
                    Showing 0 to 0 of 0 leads
                </div>
                <div class="pagination-controls" id="leads-pagination-controls">
                    <!-- Dynamic page links -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Beautiful Custom Confirmation Modal Popups -->
<div id="custom-confirm-modal" class="custom-modal-overlay">
    <div class="custom-modal">
        <div class="modal-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div class="modal-title" id="confirm-modal-title">Delete Lead?</div>
        <div class="modal-text" id="confirm-modal-text">Are you sure you want to permanently delete this lead? This action cannot be undone.</div>
        <div class="modal-actions">
            <button type="button" class="btn-modal-cancel" onclick="closeConfirmModal()">No, Cancel</button>
            <button type="button" class="btn-modal-confirm" id="confirm-modal-yes-btn">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
// Tab switcher section logic
function switchSection(sectionId, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.editor-section').forEach(s => s.classList.remove('active'));
    
    btn.classList.add('active');
    document.getElementById('section-' + sectionId).classList.add('active');
}

// ----------------- LEADS DASHBOARD SCRIPTING -----------------
// Inject database leads array safely into Javascript state
let allLeads = <?php echo json_encode($leads); ?>;
let filteredLeads = [...allLeads];
let currentLeadsPage = 1;
let leadsPerPageLimit = 10;
let activeLeadDeletionTarget = null;
let activeLeadDeletionType = 'single'; // 'single' or 'bulk'

// Initialize dashboard display on load
document.addEventListener("DOMContentLoaded", function() {
    renderLeadsTable();
});

// Render dynamic table rows based on filters, pagination
function renderLeadsTable() {
    const tableBody = document.getElementById("leads-table-body");
    const selectAllCheckbox = document.getElementById("select-all-leads");
    tableBody.innerHTML = "";
    
    // Clear select all checkbox state on render
    selectAllCheckbox.checked = false;
    
    if (filteredLeads.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="7" style="text-align: center; color: var(--fg2); padding: 40px; font-size: 13px;">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 24px; color: var(--border); display: block; margin-bottom: 10px;"></i>
                    No leads match your search criteria.
                </td>
            </tr>
        `;
        document.getElementById("leads-pagination-info").textContent = "Showing 0 to 0 of 0 leads";
        document.getElementById("leads-pagination-controls").innerHTML = "";
        updateBulkBanner();
        return;
    }
    
    // Paginate visible array indices
    const totalLeadsCount = filteredLeads.length;
    const totalPagesCount = Math.ceil(totalLeadsCount / leadsPerPageLimit);
    
    // Safety check on active page bounds
    if (currentLeadsPage > totalPagesCount) {
        currentLeadsPage = totalPagesCount || 1;
    }
    
    const startIndex = (currentLeadsPage - 1) * leadsPerPageLimit;
    const endIndex = Math.min(startIndex + leadsPerPageLimit, totalLeadsCount);
    
    const paginatedLeads = filteredLeads.slice(startIndex, endIndex);
    
    // Format and append rows
    paginatedLeads.forEach(lead => {
        const tr = document.createElement("tr");
        tr.id = "lead-row-" + lead.id;
        
        // Date formatting helper
        const rawDate = new Date(lead.created_at);
        const formattedDate = rawDate.toLocaleDateString('en-US', { 
            month: 'short', 
            day: '2-digit', 
            year: 'numeric' 
        }) + " " + rawDate.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit', 
            hour12: true 
        });
        
        // Escape content helpers
        const nameEscaped = escapeHtml(lead.name || 'Chat User');
        const emailEscaped = escapeHtml(lead.email || '');
        const phoneEscaped = escapeHtml(lead.phone || '');
        const contextEscaped = escapeHtml(lead.context || '');
        
        tr.innerHTML = `
            <td style="text-align: center; padding: 12px;">
                <input type="checkbox" class="lead-checkbox select-lead-item" data-id="${lead.id}" onchange="handleSelectLeadItem()">
            </td>
            <td style="padding: 12px; font-size: 12px; white-space: nowrap; color: var(--fg2);">${formattedDate}</td>
            <td style="padding: 12px; font-size: 13px; font-weight: 700; color: var(--fg);">${nameEscaped}</td>
            <td style="padding: 12px; font-size: 13px; color: var(--fg);"><a href="mailto:${emailEscaped}" style="color: var(--info); font-weight: 600; text-decoration: none;">${emailEscaped}</a></td>
            <td style="padding: 12px; font-size: 13px; color: var(--fg); font-weight: 600;">${phoneEscaped}</td>
            <td style="padding: 12px; font-size: 12px; color: var(--fg2); max-width: 300px; word-break: break-word;">${contextEscaped}</td>
            <td style="padding: 12px; text-align: center;">
                <button type="button" class="btn-delete-lead" title="Delete Lead" onclick="confirmDeleteSingle(${lead.id}, '${nameEscaped.replace(/'/g, "\\'")}')">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(tr);
    });
    
    // Update pagination details text
    document.getElementById("leads-pagination-info").textContent = `Showing ${startIndex + 1} to ${endIndex} of ${totalLeadsCount} leads`;
    
    // Generate beautiful pagination buttons
    renderPaginationButtons(totalPagesCount);
    updateBulkBanner();
}

// Generate pagination controls buttons
function renderPaginationButtons(totalPages) {
    const controlsContainer = document.getElementById("leads-pagination-controls");
    controlsContainer.innerHTML = "";
    
    if (totalPages <= 1) return;
    
    // Previous Page Button
    const prevBtn = document.createElement("button");
    prevBtn.type = "button";
    prevBtn.className = "page-link" + (currentLeadsPage === 1 ? " disabled" : "");
    prevBtn.innerHTML = '<i class="fa-solid fa-angle-left"></i>';
    if (currentLeadsPage > 1) {
        prevBtn.onclick = () => { currentLeadsPage--; renderLeadsTable(); };
    }
    controlsContainer.appendChild(prevBtn);
    
    // Page Numbers
    for (let i = 1; i <= totalPages; i++) {
        const pageBtn = document.createElement("button");
        pageBtn.type = "button";
        pageBtn.className = "page-link" + (currentLeadsPage === i ? " active" : "");
        pageBtn.textContent = i;
        pageBtn.onclick = () => { currentLeadsPage = i; renderLeadsTable(); };
        controlsContainer.appendChild(pageBtn);
    }
    
    // Next Page Button
    const nextBtn = document.createElement("button");
    nextBtn.type = "button";
    nextBtn.className = "page-link" + (currentLeadsPage === totalPages ? " disabled" : "");
    nextBtn.innerHTML = '<i class="fa-solid fa-angle-right"></i>';
    if (currentLeadsPage < totalPages) {
        nextBtn.onclick = () => { currentLeadsPage++; renderLeadsTable(); };
    }
    controlsContainer.appendChild(nextBtn);
}

// Handle live search text matching
function handleLeadsSearch() {
    const query = document.getElementById("leads-search").value.toLowerCase().trim();
    if (query === "") {
        filteredLeads = [...allLeads];
    } else {
        filteredLeads = allLeads.filter(lead => {
            return (lead.name && lead.name.toLowerCase().includes(query)) ||
                   (lead.email && lead.email.toLowerCase().includes(query)) ||
                   (lead.phone && lead.phone.includes(query)) ||
                   (lead.context && lead.context.toLowerCase().includes(query));
        });
    }
    currentLeadsPage = 1; // Reset to page 1
    renderLeadsTable();
}

// Handle limit size change
function changeLeadsLimit() {
    leadsPerPageLimit = parseInt(document.getElementById("leads-limit").value);
    currentLeadsPage = 1; // Reset to page 1
    renderLeadsTable();
}

// Toggle Select All Visible Leads Checkbox
function toggleSelectAllLeads(masterCheckbox) {
    const rowCheckboxes = document.querySelectorAll(".select-lead-item");
    rowCheckboxes.forEach(cb => {
        cb.checked = masterCheckbox.checked;
    });
    updateBulkBanner();
}

// Handle row checkbox changes
function handleSelectLeadItem() {
    const selectAllCheckbox = document.getElementById("select-all-leads");
    const rowCheckboxes = document.querySelectorAll(".select-lead-item");
    const checkedCount = Array.from(rowCheckboxes).filter(cb => cb.checked).length;
    
    selectAllCheckbox.checked = (checkedCount === rowCheckboxes.length && rowCheckboxes.length > 0);
    updateBulkBanner();
}

// Display or update Bulk Selection Banner
function updateBulkBanner() {
    const rowCheckboxes = document.querySelectorAll(".select-lead-item");
    const checkedBoxes = Array.from(rowCheckboxes).filter(cb => cb.checked);
    const banner = document.getElementById("leads-bulk-banner");
    const countSpan = document.getElementById("selected-leads-count");
    
    if (checkedBoxes.length > 0) {
        banner.style.display = "flex";
        countSpan.textContent = checkedBoxes.length;
    } else {
        banner.style.display = "none";
        countSpan.textContent = "0";
    }
}

// ----------------- MODAL DIALOG POPUPS SCRIPT -----------------
function openConfirmModal(title, text, confirmCallback) {
    const overlay = document.getElementById("custom-confirm-modal");
    document.getElementById("confirm-modal-title").textContent = title;
    document.getElementById("confirm-modal-text").textContent = text;
    
    const yesBtn = document.getElementById("confirm-modal-yes-btn");
    // Clear old click event listeners
    const newYesBtn = yesBtn.cloneNode(true);
    yesBtn.parentNode.replaceChild(newYesBtn, yesBtn);
    
    newYesBtn.onclick = function() {
        confirmCallback();
        closeConfirmModal();
    };
    
    overlay.classList.add("show");
}

function closeConfirmModal() {
    document.getElementById("custom-confirm-modal").classList.remove("show");
}

// Confirm Delete Single Lead (with name highlight)
function confirmDeleteSingle(id, name) {
    activeLeadDeletionTarget = id;
    activeLeadDeletionType = 'single';
    
    openConfirmModal(
        "Delete Lead?", 
        `Are you sure you want to permanently delete lead details of "${name}"? This will delete it from the database forever!`,
        executeDeleteAction
    );
}

// Confirm Bulk Delete Selected Leads
function confirmBulkDelete() {
    activeLeadDeletionType = 'bulk';
    const rowCheckboxes = document.querySelectorAll(".select-lead-item");
    const checkedIds = Array.from(rowCheckboxes).filter(cb => cb.checked).map(cb => cb.getAttribute("data-id"));
    
    if (checkedIds.length === 0) return;
    
    openConfirmModal(
        "Delete Selected Leads?", 
        `Are you sure you want to permanently delete all ${checkedIds.length} selected proposal leads? This will clear them from your database forever!`,
        executeDeleteAction
    );
}

// ----------------- AJAX BACKEND CALLS -----------------
function executeDeleteAction() {
    // Show loading alerts
    hideAlerts();
    
    const formData = new FormData();
    
    if (activeLeadDeletionType === 'single') {
        formData.append("action", "delete_lead");
        formData.append("lead_id", activeLeadDeletionTarget);
    } else {
        const rowCheckboxes = document.querySelectorAll(".select-lead-item");
        const checkedIds = Array.from(rowCheckboxes).filter(cb => cb.checked).map(cb => cb.getAttribute("data-id")).join(",");
        formData.append("action", "bulk_delete_leads");
        formData.append("lead_ids", checkedIds);
    }
    
    fetch("", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error("HTTP error " + response.status);
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Success! Sync JavaScript State local array
            if (activeLeadDeletionType === 'single') {
                allLeads = allLeads.filter(lead => lead.id !== activeLeadDeletionTarget);
            } else {
                const rowCheckboxes = document.querySelectorAll(".select-lead-item");
                const checkedIds = Array.from(rowCheckboxes).filter(cb => cb.checked).map(cb => parseInt(cb.getAttribute("data-id")));
                allLeads = allLeads.filter(lead => !checkedIds.includes(lead.id));
            }
            
            // Re-sync filtered states
            filteredLeads = [...allLeads];
            handleLeadsSearch(); // Keep existing query matching if searching
            
            // Render beautiful custom alert success toast banner
            showToastSuccess(data.message || "Action executed successfully!");
        } else {
            showToastError(data.error || "An error occurred while deleting database entries.");
        }
    })
    .catch(err => {
        showToastError("Connection error: Could not reach backend server to delete rows.");
        console.error(err);
    });
}

// ----------------- TOAST ALERTS HELPERS -----------------
function hideAlerts() {
    document.getElementById("leads-alert-success").style.display = "none";
    document.getElementById("leads-alert-error").style.display = "none";
}

function showToastSuccess(msg) {
    const el = document.getElementById("leads-alert-success");
    el.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${msg}`;
    el.style.display = "block";
    setTimeout(() => {
        el.style.animation = "fadeIn 0.3s reverse";
        setTimeout(() => { el.style.display = "none"; el.style.animation = ""; }, 300);
    }, 4500);
}

function showToastError(msg) {
    const el = document.getElementById("leads-alert-error");
    el.innerHTML = `<i class="fa-solid fa-circle-xmark"></i> ${msg}`;
    el.style.display = "block";
}

// Simple HTML Escaping to prevent XSS script executions
function escapeHtml(text) {
    if (!text) return "";
    return text.toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
