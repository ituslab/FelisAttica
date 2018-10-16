<?php

namespace Felis\Attica;

class AtticaExecutioner { 
    
    private $tCurl;
    private $tResult;
    private $tInfo;
    private $tError;
    private $tErrMessage;



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

    public function jsonDecoded() {
        $decode = json_decode($this->tResult);
        if($decode === NULL) {
            return '';
        }
        return $decode;
    }

    public function rawResponse(){
        return $this->tResult;
    }

    public function getStatusCode() {
        return $this->tInfo['http_code'];
    }

    public function getErrCode() {
        return $this->tError;
    }

    public function getErrMessage() {
        return $this->tErrMessage;
    }

    public function execute() {
        curl_setopt($this->tCurl , CURLOPT_RETURNTRANSFER , true);
        
        $this->tResult = curl_exec($this->tCurl);
        $this->tInfo = curl_getinfo($this->tCurl);
        $this->tError = \curl_errno($this->tCurl);
        $this->tErrMessage = curl_error($this->tCurl);

        curl_close($this->tCurl);
    }
}

