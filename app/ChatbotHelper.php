<?php
namespace App;
use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
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
        $this->config = include('config.php');
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
}