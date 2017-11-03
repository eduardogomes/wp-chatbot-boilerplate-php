<?php
namespace App;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Dotenv\Dotenv;

class ChatbotHelper
{
    protected $facebookSend;
    protected $log;
    private $accessToken;
    public $config;
    public function __construct()
    {
        $dotenv = new Dotenv(dirname(__FILE__, 2));
        $dotenv->load();        
        $this->accessToken = getenv('PAGE_ACCESS_TOKEN');
        $this->facebookSend = new FacebookSend();
        $this->log = new Logger('general');
        $this->log->pushHandler(new StreamHandler('debug.log'));
    }

    /**
     * Send a reply back to Facebook chat
     * @param $senderId
     * @param $replyMessage
     */
    public function send($senderId, string $replyMessage)
    {
        return $this->facebookSend->send($this->accessToken, $senderId, $replyMessage);
    }

    public function verify_token(){
        $hub_mode = array_key_exists('hub_mode', $_GET) ? $_GET['hub_mode'] : '';
        $hub_challenge = array_key_exists('hub_challenge', $_GET) ? $_GET['hub_challenge'] : '';
        $hub_verify_token = array_key_exists('hub_verify_token', $_GET) ? $_GET['hub_verify_token'] : '';
        
        if ($hub_mode !== 'subscribe') {
            $this->log->debug('Invalid webhook mode');
            http_response_code(400);
            die(0);
        }
        if ($hub_verify_token !== getenv('VERIFY_TOKEN')) {
            $this->log->debug('Failed to verify token');
            http_response_code(400);
            die(0);
        }
        $this->log->info('Webhook subscribed');
        echo($hub_challenge);
        die(0);       
    }
    public function check_hub_signature($body){
        if (!array_key_exists('HTTP_X_HUB_SIGNATURE', $_SERVER)) {
            $this->log->debug('X-Hub-Signature header not found');
            http_response_code(400);
            die(0);
        }
        $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
        $expected = 'sha1=' . hash_hmac('sha1', $body, getenv('APP_SECRET'));
        if ($expected !== $signature) {
            $this->log->debug('X-Hub-Signature does not match');
            http_response_code(400);
            die(0);
        }    
    }
    public function handle_msg($data){
        if (array_key_exists('entry', $data)) {
            foreach ($data['entry'] as $entry) {
                if (array_key_exists('messaging', $entry)) {
                    foreach ($entry['messaging'] as $item) {
                        $senderId = $item->sender->id;
                        $message = $item->message->text;
                        $replyMessage = "Echo:" + $message;
                        $this->send($senderId, $replyMessage);
                    }
                }
            }
        }    
    }
}