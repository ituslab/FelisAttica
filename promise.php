<?php

use Felis\Attica\AtticaPromise;

require_once __DIR__ . '/vendor/autoload.php';


$atticaPromise = new AtticaPromise();
$wrongUrl = $atticaPromise->asyncGET("blasdaosd");

var_dump("before wrongUrl...");
$wrongUrl->then(function($v) {
    var_dump($v);
});
var_dump("after wrongUrl...");


try {
    $wrongUrl->wait();
    var_dump("promise resolved");
}catch(Exception $ex){
    var_dump($ex->getMessage());
}