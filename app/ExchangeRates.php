<?php

class ExchangeRates
{
    private $baseUrl;
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getExchangeRate($currency)
    {
        $response = json_decode(file_get_contents($this->baseUrl),true);        
        $rates = 0;
        if(isset($response['rates'][$currency])){
            $rates = $response['rates'][$currency];            
        }        
        return $rates;
    }
}