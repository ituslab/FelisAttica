<?php

namespace Felis\Attica;

class AtticaClient { 


    private static function initCurl($url , $whichMethod) {
        $tCurl = \curl_init($url);
        curl_setopt($tCurl , $whichMethod , true );
        return $tCurl;
    }

    private static function curlWithCustom($url , $whichMethod) {
        $tCurl = curl_init($url);
        curl_setopt($tCurl , CURLOPT_CUSTOMREQUEST , $whichMethod);
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

    public static function DELETE($url) {
        $tCurl = self::curlWithCustom($url , "DELETE");
        return new AtticaExecutioner($tCurl);
    }

    public static function PATCH($url) {
        $tCurl = self::curlWithCustom($url , "PATCH");
        return new AtticaExecutioner($tCurl);
    }

    public static function PUT($url) {
        $tCurl = self::curlWithCustom($url , "PUT");
        return new AtticaExecutioner($tCurl);
    }

}