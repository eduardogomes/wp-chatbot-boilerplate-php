<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\ChatbotHelper;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Dotenv\Dotenv;
$dotenv = new Dotenv(dirname(__FILE__, 2));
$dotenv->load();

// Create the chatbot helper instance
$chatbotHelper = new ChatbotHelper();
$log = new Logger('general');
$log->pushHandler(new StreamHandler('debug.log'));

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $hub_mode = array_key_exists('hub_mode', $_GET) ? $_GET['hub_mode'] : '';
    $hub_challenge = array_key_exists('hub_challenge', $_GET) ? $_GET['hub_challenge'] : '';
    $hub_verify_token = array_key_exists('hub_verify_token', $_GET) ? $_GET['hub_verify_token'] : '';
  
    if ($hub_mode !== 'subscribe') {
        $log->debug('Invalid webhook mode');
        http_response_code(400);
        die(0);
    }
    if ($hub_verify_token !== getenv('VERIFY_TOKEN')) {
        $log->debug('Failed to verify token');
        http_response_code(400);
        die(0);
    }
    $log->info('Webhook subscribed');
    echo($hub_challenge);
    die(0);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    $body = file_get_contents('php://input');

    if (!array_key_exists('HTTP_X_HUB_SIGNATURE', $_SERVER)) {
        $log->debug('X-Hub-Signature header not found');
        http_response_code(400);
        die(0);
    }
    $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
    $expected = 'sha1=' . hash_hmac($body, getenv('APP_SECRET'), 'sha1');
    if ($expected !== $signature) {
        $log->debug('X-Hub-Signature does not match');
        http_response_code(400);
        die(0);
    }

    $data = json_decode($body, true);
    if (array_key_exists('entry', $data)) {
        foreach ($data['entry'] as $entry) {
            if (array_key_exists('messaging', $entry)) {
                foreach ($entry['messaging'] as $item) {
                    $senderId = $item->sender->id;
                    $message = $item->message->text;
                    $replyMessage = "Echo:" + $message;
                    $chatbotHelper->send($senderId, $replyMessage);
                }
            }
        }
    }
}