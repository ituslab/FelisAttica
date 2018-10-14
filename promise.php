<?php

use Felis\Attica\AtticaPromise;
use GuzzleHttp\Promise\Promise;

require_once __DIR__ . '/vendor/autoload.php';


// GET Async http client example
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

// POST Async http client example (application/json)
// chaining promises
$m = $atticaPromise->asyncSendPOST("https://reqres.in/api/users",array(
    'name'=>'hello',
    'job'=>'world'
),"application/json");

$m->then(function($v) use ($atticaPromise){
    echo $v . "\n";
    return $atticaPromise->asyncSendPOST("http://httpbin.org/post",array(
        'a'=>'aaa','b'=>'bbb'
    ),'application/x-www-form-urlencoded')->wait();
})->then(function($v) {
    echo $v . "\n";
});

$m->wait();

// POST Async with asyncRequest example
$data = http_build_query(array(
    'name'=>'asd',
    'job'=>'dsa'
));
$headers = array(
    'Content-type: application/x-www-form-urlencoded'
);
$custom = $atticaPromise->asyncRequest("http://httpbin.org/post",$headers , CURLOPT_POST , $data);
$custom->then(function($v){
    echo $v;
});

$custom->wait();