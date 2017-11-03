<?php
namespace App;
class FacebookPrepareData
{
    public function prepare($senderId, $message)
    {
        return '{
            "recipient":{
                "id":"' . $senderId . '"
            },
            "message":{
                "text":"' . $message . '"
            }
        }';
    }
}