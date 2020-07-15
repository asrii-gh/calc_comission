<?php

class BinParser{
    const EU_CURRENCY = array('AT','BE','BG','CY','CZ','DE','DK','EE','ES','FI','FR','GR',
                              'HR','HU','IE','IT','LT','LU','LV','MT','NL','PO','PT','RO',
                              'SE','SI','SK');
    private $binUrl;

    private $currency;

    public function __construct($binUrl)
    {
        $this->binUrl = $binUrl;
    }

    public function getData($input)
    {
        $response = json_decode(file_get_contents($this->binUrl .'/'.$input),true);
              
        $this->currency = $response['country']['alpha2'];
        
        return $response;
    }

    public function isEuCurrency()
    {
        if(in_array($this->currency,self::EU_CURRENCY)){
            return true;
        }
        return false;
    }
}