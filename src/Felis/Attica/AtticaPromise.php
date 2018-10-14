<?php

namespace Felis\Attica;

use GuzzleHttp\Promise\Promise;





class AtticaPromise {

    public function asyncPOST($url) {
        $promise = new Promise(function () use (&$promise , $url){
            
        });

        return $promise;
    }


    public function asyncGET($url) {
        $promise = new Promise(function () use(&$promise , $url) {
            $atticaClient = AtticaClient::GET($url);
            $atticaClient->execute();
            $tError = $atticaClient->getErrCode();
            if($tError != 0) {
                $promise->reject($atticaClient->getErrMessage());
                return;
            }
            $atticaResponse = $atticaClient->rawResponse();
            $promise->resolve($atticaResponse);
        });

        return $promise;
    }
}