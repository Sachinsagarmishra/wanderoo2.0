<?php
/**
 * North AI Chat Agent API Endpoint
 */
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/functions.php';

// Verify POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

// Read raw body input
$input_data = json_decode(file_get_contents('php://input'), true);
$user_message = trim($input_data['message'] ?? '');
$history = $input_data['history'] ?? []; // Past conversation messages

if (empty($user_message)) {
    http_response_code(400);
    echo json_encode(['error' => 'Query message cannot be empty']);
    exit;
}

// 1. Check for Lead Capture Submission
// If user message is a lead submission JSON block
if (isset($input_data['lead_submission']) && $input_data['lead_submission'] === true) {
    $lead_name = trim($input_data['name'] ?? '');
    $lead_email = trim($input_data['email'] ?? '');
    $lead_phone = trim($input_data['phone'] ?? '');
    $lead_context = trim($input_data['context'] ?? '');

    if (!empty($lead_name) && !empty($lead_email) && !empty($lead_phone)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO `captured_leads` (`name`, `email`, `phone`, `context`) VALUES (:name, :email, :phone, :context)");
            $stmt->execute([
                'name' => $lead_name,
                'email' => $lead_email,
                'phone' => $lead_phone,
                'context' => $lead_context
            ]);
            echo json_encode(['success' => true, 'message' => 'Thank you! Your corporate proposal request has been captured. Our team will contact you on WhatsApp/Email within 30 minutes.']);
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'All lead capture fields are required']);
        exit;
    }
}

// 2. Fetch API key and settings
$api_key = trim(get_agent_setting('gemini_api_key'));
if (empty($api_key)) {
    echo json_encode([
        'reply' => "⚠️ **Gemini API Key is not configured yet!**\n\nPlease go to your **Admin Panel -> North AI Agent Settings** and paste your Google Gemini API Key to enable this professional travel assistant instantly."
    ]);
    exit;
}

// 3. Compile dynamic RAG Context (Destinations, Cases, Company Settings)
$dest_list = get_all_destinations();
$case_list = get_all_case_studies();
$custom_k = get_agent_setting('custom_knowledge');
$base_prompt = get_agent_setting('system_prompt');
$pricing_rates = get_agent_setting('default_pricing_rates');

// Format dynamic database objects as structured context strings
$dest_context = "LIVE CHOSEN PACKAGES & DESTINATIONS:\n";
foreach ($dest_list as $d) {
    $dest_context .= "- {$d['title']} (Duration: {$d['duration']}, Description: {$d['description']}, Key Tags: {$d['tags']})\n";
}

$case_context = "SUCCESSFUL CLIENT CASES & PORTFOLIO:\n";
foreach ($case_list as $c) {
    $case_context .= "- Client: {$c['client_name']}, Location Tag: {$c['badge_text']} {$c['badge_flag']}, Scale: {$c['case_type']}, Stats: [{$c['stat1_num']} {$c['stat1_label']} | {$c['stat2_num']} {$c['stat2_label']} | {$c['stat3_num']} {$c['stat3_label']}], Outcome: {$c['outcome']}\n";
}

$pricing_rates_decoded = json_decode($pricing_rates, true);
$dom_rates = $pricing_rates_decoded['domestic'] ?? ['standard' => 4500, 'deluxe' => 6500, 'premium' => 9500];
$intl_rates = $pricing_rates_decoded['international'] ?? ['standard' => 5500, 'deluxe' => 7150, 'premium' => 10725];

$pricing_context = "DYNAMIC CALCULATOR RATES (Per Person Per Night):\n";
$pricing_context .= "- Domestic Destinations (e.g. Goa, Coorg, Munnar): Standard: ₹{$dom_rates['standard']}, Deluxe: ₹{$dom_rates['deluxe']}, Premium: ₹{$dom_rates['premium']}\n";
$pricing_context .= "- International Destinations (e.g. Phuket, Bali, Swiss Alps): Standard: ₹{$intl_rates['standard']}, Deluxe: ₹{$intl_rates['deluxe']}, Premium: ₹{$intl_rates['premium']}\n";

$full_system_prompt = $base_prompt . "\n\n" . $custom_k . "\n\n" . $pricing_context . "\n\n" . $dest_context . "\n\n" . $case_context;

// 4. Determine Routing (Native Gemini vs OpenRouter)
$is_openrouter = (strpos($api_key, 'sk-') === 0);

if ($is_openrouter) {
    // OpenRouter / OpenAI compatible endpoint integration
    $messages = [
        ['role' => 'system', 'content' => $full_system_prompt]
    ];
    
    foreach ($history as $h) {
        $role = $h['role'] === 'user' ? 'user' : 'assistant';
        $messages[] = [
            'role' => $role,
            'content' => $h['text']
        ];
    }
    
    $messages[] = [
        'role' => 'user',
        'content' => $user_message
    ];

    $post_fields = [
        'model' => 'openrouter/free',
        'messages' => $messages,
        'temperature' => 0.4
    ];

    $ch = curl_init("https://openrouter.ai/api/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        $error_resp = json_decode($response, true);
        $error_msg = $error_resp['error']['message'] ?? 'Unknown OpenRouter Error';
        echo json_encode([
            'reply' => "⚠️ **OpenRouter API Connection Error ($http_code)**\n\n*Details: $error_msg*\n\nPlease verify your OpenRouter API key inside the settings panel."
        ]);
        exit;
    }

    $response_data = json_decode($response, true);
    $bot_reply = $response_data['choices'][0]['message']['content'] ?? "I'm sorry, I couldn't formulate a suggestion. Let's try again!";
    
    echo json_encode(['reply' => $bot_reply]);
    exit;
} else {
    // Native Google Gemini API integration
    $gemini_contents = [];
    foreach ($history as $h) {
        $role = $h['role'] === 'user' ? 'user' : 'model';
        $gemini_contents[] = [
            'role' => $role,
            'parts' => [['text' => $h['text']]]
        ];
    }
    
    $gemini_contents[] = [
        'role' => 'user',
        'parts' => [['text' => $user_message]]
    ];

    $post_fields = [
        'contents' => $gemini_contents,
        'systemInstruction' => [
            'parts' => [['text' => $full_system_prompt]]
        ],
        'safetySettings' => [
            [
                'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                'threshold' => 'BLOCK_NONE'
            ],
            [
                'category' => 'HARM_CATEGORY_HATE_SPEECH',
                'threshold' => 'BLOCK_NONE'
            ],
            [
                'category' => 'HARM_CATEGORY_HARASSMENT',
                'threshold' => 'BLOCK_NONE'
            ],
            [
                'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                'threshold' => 'BLOCK_NONE'
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.4,
            'maxOutputTokens' => 1024
        ]
    ];

    $ch = curl_init("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $api_key);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        $error_resp = json_decode($response, true);
        $error_msg = $error_resp['error']['message'] ?? 'Unknown API Error';
        echo json_encode([
            'reply' => "⚠️ **Google Gemini API Connection Error ($http_code)**\n\n*Details: $error_msg*\n\nPlease make sure your API Key is active and has no billing restrictions."
        ]);
        exit;
    }

    $response_data = json_decode($response, true);
    $bot_reply = $response_data['candidates'][0]['content']['parts'][0]['text'] ?? "I'm sorry, I couldn't formulate a suggestion. Let's try again!";
    
    echo json_encode(['reply' => $bot_reply]);
    exit;
}
