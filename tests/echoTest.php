<?php
use App\FacebookPrepareData;
use PHPUnit\Framework\TestCase;
class FacebookPrepareDataTest extends TestCase
{
    public function testFormatMessage() {
        $dataPrepare = new FacebookPrepareData();
        $json = $dataPrepare->prepare('1','m');
        $this->assert($json !== null);
    }
}