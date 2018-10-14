<?php

namespace Felis\Attica;

use GuzzleHttp\Promise\Promise;





class AtticaPromise {

    public function asyncSendPOST($url , $data , $cType) {
        $promise = new Promise(function () use (&$promise , $url , $data , $cType){
            $atticaClient = AtticaClient::POST($url);
            $atticaClient->send($data,$cType);
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

    public function asyncRequest($url , $httpHeaders , $httpMethod , $data) {
        $promise = new Promise(function () use (&$promise , $url, $httpMethod, $httpHeaders, $data) {
            $rCurl = curl_init($url);
            curl_setopt($rCurl , $httpMethod , true);
            curl_setopt($rCurl , CURLOPT_USERAGENT , "Attica-HTTPClient");
            curl_setopt($rCurl , CURLOPT_RETURNTRANSFER , true);
            if(isset($httpHeaders)){
                curl_setopt($rCurl , CURLOPT_HTTPHEADER , $httpHeaders);
            }

            if($httpMethod == CURLOPT_POST) {
                curl_setopt($rCurl , CURLOPT_POSTFIELDS , $data);
            } 

            $out = curl_exec($rCurl);

            if(curl_errno($rCurl) != 0) {
                $promise->reject(curl_error($rCurl));
                curl_close($rCurl);
                return;
            }
            $promise->resolve($out);
            curl_close($rCurl);
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