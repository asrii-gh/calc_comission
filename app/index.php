<?php

require_once('./TxtFileReader.php');
require_once('./Commissions.php');

$txtFileReader = new TxtFileReader("input/input.txt");
$transactionList = $txtFileReader->parseContent();

$binParserProvider = "https://lookup.binlist.net";
$exchangeRateProvider = "https://api.exchangeratesapi.io/latest";
$commission = new Commissions($binParserProvider,$exchangeRateProvider,$transactionList);
$result = $commission->calculate();

foreach($result as $res){    
    echo "Result: ".$res['commission']."<br/>";  
}
