<?php
namespace App;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
class FacebookSend
{
    protected $apiUrl = 'https://graph.facebook.com/v2.6/me/messages';
    protected $log;
    protected $facebookPrepareData;
    public function __construct()
    {
        $this->log = new Logger('general');
        $this->log->pushHandler(new \Monolog\Handler\ErrorLogHandler());
        $this->facebookPrepareData = new FacebookPrepareData();
    }

    public function send(string $accessToken, string $senderId, string $replyMessage)
    {
        $jsonDataEncoded = $this->facebookPrepareData->prepare($senderId, $replyMessage);
        $this->log->debug($jsonDataEncoded);
        $ch = curl_init($this->apiUrl);
        // Tell cURL to send POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
        // Attach JSON string to post fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        // Set the content type
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $accessToken));
        // Execute
        curl_exec($ch);
        if (curl_error($ch)) {
            $this->log->warning('Send Facebook Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}