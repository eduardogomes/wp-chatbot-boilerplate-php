<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\ChatbotHelper;

// Create the chatbot helper instance
$chatbotHelper = new ChatbotHelper();
if ($_SERVER["REQUEST_METHOD"] == "GET") {  
    $chatbotHelper->verify_token();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {   
    $body = file_get_contents('php://input');
    $chatbotHelper->check_hub_signature($body);
    
    $data = json_decode($body, true);
    $chatbotHelper->handle_msg($data);
}