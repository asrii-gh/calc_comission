<?php

require('BinParser.php');
require('ExchangeRates.php');
require('CommissionInterface.php');

class Commissions implements CommissionInterface
{
    private $binParser;
    private $ratesParser;
    private $transactionList;

    public function __construct($binProviderUrl,$exchangeRateProviderUrl,$transactionList)
    {        
        $this->setBinParser($binProviderUrl);
        $this->setExchangeRates($exchangeRateProviderUrl);
        $this->setTransactionList($transactionList);
    }

    private function setBinParser($binProviderUrl)
    {
        $this->binParser = new BinParser($binProviderUrl);        
    }

    private function setExchangeRates($exchangeRateProviderUrl)
    {
        $this->ratesParser = new ExchangeRates($exchangeRateProviderUrl);        
    }

    private function setTransactionList($transactionList)
    {
        $this->transactionList = $transactionList ?: null;        
    }

    public function calculate()
    {
        $result = array();
        if(!empty($this->transactionList)){
            foreach($this->transactionList as $transaction)
            {                
                $currencyRates = $this->ratesParser->getExchangeRate($transaction['currency']);    

                if ($transaction['currency'] == 'EUR' || $currencyRates == 0) {
                    $rates = $transaction['amount'];            
                }
                else if ($transaction['currency'] != 'EUR' || $currencyRates > 0) {
                    $rates = $transaction['amount'] / $currencyRates;
                }
        
                $this->binParser->getData($transaction['bin']);
                $isEuFlag = $this->binParser->isEuCurrency();
        
                $commission = $rates * ($isEuFlag ? 0.01 : 0.02);

                array_push($result,array("commission" => number_format($commission,2)));
            }
        }
        return $result;    
    }

}