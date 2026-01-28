<?php
header('Content-Type: application/json');

// Configuration
const BASE_URL = 'https://api-inference.huggingface.co/models/mistralai/Mistral-7B-Instruct-v0.3';
const API_KEY = getenv('HF_TOKEN');


// Database configuration (using MySQL as an example)
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'gnc';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
}

function getUserProfile($pdo, $username) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM profiles WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error fetching user profile: " . $e->getMessage());
        return null;
    }
}

function formatUserProfile($profile) {
    if (!$profile) return "No user profile available.";
    
    return "- Name: " . ($profile['name'] ?? 'Not provided') . "\n" .
           "- Age: " . ($profile['age'] ?? 'Not provided') . " years\n" .
           "- Preferences: " . ($profile['travel_preferences'] ?? 'Not provided') . "\n" .
           "- Budget Range: " . ($profile['budget_range'] ?? 'Not provided');
}

function saveConversation($pdo, $username, $userMessage, $aiResponse) {
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO ai_conversations (username, user_message, ai_response, created_at, context, model) 
             VALUES (?, ?, ?, NOW(), 'travel_guide', 'Mistral-7B')"
        );
        $stmt->execute([$username, $userMessage, $aiResponse]);
    } catch (Exception $e) {
        error_log("Error saving conversation: " . $e->getMessage());
    }
}

function getAIResponse($message, $userProfile) {
    $userContext = formatUserProfile($userProfile);
    $currentTime = date('c');

    $payload = [
        'inputs' => "<|im_start|>system
You are an AI travel guide assistant. You have access to the following user information:

USER PROFILE:
$userContext

TIME OF CONSULTATION: $currentTime

Please provide a single, helpful response while:
1. Considering the user's profile and preferences when giving advice
2. Keeping messages short and easy to understand
3. Recommending professional services only for critical travel issues
4. Using clear, simple language
5. Being friendly and helpful
6. Only responding once without follow-up conversations
7. Alerting about any travel-related concerns based on profile
8. Suggesting travel options when relevant
9. Acting like a professional travel advisor

<|im_start|>user
$message

<|im_start|>assistant",
        'parameters' => [
            'max_length' => 500,
            'temperature' => 0.7,
            'top_p' => 0.9,
            'stop' => ['<|im_start|>'],
            'return_full_text' => false
        ]
    ];

    $ch = curl_init(BASE_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . API_KEY,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        $data = json_decode($response, true);
        return $data[0]['generated_text'] ?? 'Sorry, I couldn’t generate a response.';
    } else {
        error_log("API Error: HTTP $httpCode - $response");
        return "Sorry, I'm having technical issues. For urgent travel needs, contact a travel agent.";
    }
}

// Handle request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = $input['message'] ?? '';
    $username = 'test_user'; // Replace with actual authentication logic
    if (empty($message)) {
        echo json_encode(['error' => 'No message provided']);
        exit;
    }

    $userProfile = getUserProfile($pdo, $username);
    $response = getAIResponse($message, $userProfile);
    saveConversation($pdo, $username, $message, $response);

    echo json_encode(['response' => $response]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>