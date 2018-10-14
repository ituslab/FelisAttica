<?php

namespace Felis\Attica;

class AtticaClient { 


    private static function initCurl($url , $whichMethod) {
        $tCurl = \curl_init($url);
        curl_setopt($tCurl , $whichMethod , true );
        return $tCurl;
    }

    public static function POST($url) {
        $tCurl = self::initCurl($url, CURLOPT_POST);
        return new \Felis\Attica\AtticaExecutioner($tCurl);
    }
    
    public static function GET($url) {
        $tCurl = self::initCurl($url ,  CURLOPT_HTTPGET);
        return new \Felis\Attica\AtticaExecutioner($tCurl);
    }

}