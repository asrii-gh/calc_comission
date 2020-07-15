<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require './app/Commissions.php';
require './app/TxtFileReader.php';
 
class CommissionsTest extends TestCase
{    
    public function testCanBeUsedAsString(): void
    {
        $binParserProvider = "https://lookup.binlist.net";
        $exchangeRateProvider = "https://api.exchangeratesapi.io/latest";

        $txtFileReader = new TxtFileReader("app/input/input.txt");
        $transactionList = $txtFileReader->parseContent();
        $this->assertIsArray($transactionList);

        $commissions = new Commissions($binParserProvider,$exchangeRateProvider,$transactionList);
        $result = $commissions->calculate();
        $this->assertIsArray($result);
    } 
}