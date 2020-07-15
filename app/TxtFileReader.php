<?php
class TxtFileReader 
{
    private $filePath;
    
    public function __construct($filePath)
    {        
        $this->setFilePath($filePath);
    }

    public function setFilePath($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception('Wrong path');
        }
        $this->filePath = $filePath;
    }

    public function parseContent()
    {
        $fileHandle = fopen($this->filePath, "r");
        $result = array();
        while (!feof($fileHandle) ) 
        {
            $lineOfTxt = json_decode(fgets($fileHandle),true);        
            array_push($result,$lineOfTxt);
        }
        fclose($fileHandle);
        return $result;
    }
}