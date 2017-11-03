<?php
use App\ForeignExchangeRate;
use PHPUnit\Framework\TestCase;
class EchoTest extends TestCase
{
    public function testUnusedRatesAreRemoved() {
        $foreignRate = new ForeignExchangeRate();
        $rates = $foreignRate->getRates('EUR');
        $this->assertContains('EUR', $rates);
        $this->assertNotContains('TRY', $rates);
        $this->assertNotContains('CAD', $rates);
        $this->assertNotContains('RON', $rates);
    }
    public function testFormatIsString() {
        $foreignRate = new ForeignExchangeRate();
        $rates = $foreignRate->getRates('EUR');
        $this->assertEquals('string', gettype($rates));
    }
}