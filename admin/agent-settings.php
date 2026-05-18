<?php
/**
 * North AI Agent Settings & Leads Dashboard
 */
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/header.php'; // Auth check triggers

$success_msg = '';
$error_msg = '';

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
        <div class="form-card">
            <div class="form-card-title"><i class="fa-solid fa-id-card-clip" style="color: var(--accent);"></i> Captured Corporate Proposal Leads</div>
            <p style="font-size: 13px; color: var(--fg2); margin-bottom: 20px;">Whenever a corporate planner uses North AI to calculate an offsite budget and requests a customized proposal, their contact details are logged here.</p>

            <div style="overflow-x: auto;">
                <table class="crud-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="padding: 12px; font-size: 12px;">Submitted Date</th>
                            <th style="padding: 12px; font-size: 12px;">Client Name</th>
                            <th style="padding: 12px; font-size: 12px;">Work Email</th>
                            <th style="padding: 12px; font-size: 12px;">WhatsApp Line</th>
                            <th style="padding: 12px; font-size: 12px;">Captured Context</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($leads)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--fg2); padding: 30px;">No leads captured yet. Enquiries will populate here dynamically.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($leads as $l): ?>
                                <tr>
                                    <td style="padding: 12px; font-size: 12px; white-space: nowrap; color: var(--fg2);"><?php echo date('M d, Y h:i A', strtotime($l['created_at'])); ?></td>
                                    <td style="padding: 12px; font-size: 13px; font-weight: 700; color: var(--fg);"><?php echo htmlspecialchars($l['name']); ?></td>
                                    <td style="padding: 12px; font-size: 13px; color: var(--fg);"><a href="mailto:<?php echo htmlspecialchars($l['email']); ?>" style="color: var(--info); font-weight: 600; text-decoration: none;"><?php echo htmlspecialchars($l['email']); ?></a></td>
                                    <td style="padding: 12px; font-size: 13px; color: var(--fg); font-weight: 600;"><?php echo htmlspecialchars($l['phone']); ?></td>
                                    <td style="padding: 12px; font-size: 12px; color: var(--fg2); max-width: 300px;"><?php echo htmlspecialchars($l['context']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function switchSection(sectionId, btn) {
    // Deactivate all tabs
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.editor-section').forEach(s => s.classList.remove('active'));
    
    // Activate clicked tab
    btn.classList.add('active');
    document.getElementById('section-' + sectionId).classList.add('active');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
