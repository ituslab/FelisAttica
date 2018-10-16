<?php

namespace Felis\Attica;

class AtticaExecutioner { 
    
    private $tCurl;



    public function __construct($tCurl){
        $this->tCurl = $tCurl;
        curl_setopt($this->tCurl , CURLOPT_USERAGENT , "Attica-HTTPClient");
    }

    public function setHeader($arrHeader) {
        curl_setopt($this->tCurl, CURLOPT_HTTPHEADER , $arrHeader);
        return $this;
    }

    private function expectedValue($var , $expectedValue) {
        $vGType = gettype($var);
        if($vGType !=  $expectedValue) {
            throw new \Error("Error value must be ".$expectedValue);
        }
    }

    private function setContentType($val) {
        $arrCType = array('Content-type: ' .$val);
        curl_setopt($this->tCurl , CURLOPT_HTTPHEADER , $arrCType);
    }
    
    public function sendJSON($data) {
        $this->expectedValue($data , "array");
        $this->setContentType('application/json');

        $d = json_encode($data);
        \curl_setopt($this->tCurl , CURLOPT_POSTFIELDS , $d);
        return $this;
    }

    public function send($data , $cType) {
        $this->expectedValue($data , 'array');

        if ($cType == 'application/json') {
            return $this->sendJSON($data);
        } else if ($cType == 'application/x-www-form-urlencoded') {
            return $this->sendFormData($data);
        } 

        throw new \Error("Error: parsing content type");
    }
    
    public function sendFormData($data) {
        $this->expectedValue($data , "array");
        $this->setContentType('application/x-www-form-urlencoded');

        $d = http_build_query($data);
        \curl_setopt($this->tCurl,CURLOPT_POSTFIELDS , $d);
        return $this;
    }

    public function execute() {
        curl_setopt($this->tCurl , CURLOPT_RETURNTRANSFER , true);
        
        $result = curl_exec($this->tCurl);
        $info = curl_getinfo($this->tCurl);
        $errorCode = curl_errno($this->tCurl);
        $errMessage = curl_error($this->tCurl);

        $atticaResponse = new AtticaResponse($result , $info['http_code'], $errorCode , $errMessage );

        curl_close($this->tCurl);

        return $atticaResponse;
    }
}

