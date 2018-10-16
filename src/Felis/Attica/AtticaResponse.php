<?php

namespace Felis\Attica;

class AtticaResponse { 

    private $rawResponse;
    private $statusCode;
    private $errorCode;
    private $errorMessage;


    public function __construct(
        $rawResponse,
        $statusCode,
        $errorCode,
        $errorMessage
    ){
        $this->rawResponse = $rawResponse;
        $this->statusCode = $statusCode;
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    public function rawResponse(){
        return $this->rawResponse;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getErrCode() {
        return $this->errorCode;
    }

    public function getErrMessage() {
        return $this->errorMessage;
    }

    public function jsonDecoded() {
        $decode = json_decode($this->rawResponse);
        if($decode === NULL) {
            return '';
        }
        return $decode;
    }

}