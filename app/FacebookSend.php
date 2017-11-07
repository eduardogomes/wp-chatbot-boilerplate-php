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
        if (($handle = fopen("DevWorkshopTestUsers.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";
                }
            }
            fclose($handle);
        }
        $jsonDataEncoded = $this->facebookPrepareData->prepare($senderId, $replyMessage);
        $this->log->debug($jsonDataEncoded);
        $ch = curl_init($this->apiUrl);
        // Tell cURL to send POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
        // Attach JSON string to post fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        // Set the http headers
        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: ' . $accessToken;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
        // Execute
        curl_exec($ch);
        if (curl_error($ch)) {
            $this->log->warning('Send Facebook Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}