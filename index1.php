<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\ChatbotHelper;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// Create the chatbot helper instance
$chatbotHelper = new ChatbotHelper();
$log = new Logger('general');
$log->pushHandler(new StreamHandler('debug.log'));
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $chatbotHelper->verify_token();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {   
    $chatbotHelper->check_hub_signature();

    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    $chatbotHelper->handle_msg($data);
}