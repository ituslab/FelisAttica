<?php

use Felis\Attica\AtticaClient;
require_once __DIR__ . '/vendor/autoload.php';



// ex .1
// HTTP GET request
$attica = AtticaClient::GET("https://api.github.com/users/itpolsri");
$attica->execute();
$obj = $attica->jsonDecoded();
print_r($obj);


// ex .2
// HTTP POST request (application/json)
$POSTJsonData = AtticaClient::POST("https://reqres.in/api/users");
$POSTJsonData->send(array(
    'title'=> 'foo',
    'body'=> 'bar',
    'userId'=> 1
), 'application/json')->execute();

// get json response from server and decode to stdClass object
$obj = $POSTJsonData->jsonDecoded();
echo($obj->title . "\n" . $obj->body . "\n" . $obj->userId . "\n");

// ex .3
// HTTP POST request (application/x-www-form-urlencoded)
$postForm = AtticaClient::POST("http://httpbin.org/post");
$postForm->send(array(
    'username'=>'Hello',
    'password'=>'World'
), 'application/x-www-form-urlencoded')->execute();

// getting raw response from server
$raw = $postForm->rawResponse();
echo ("\n" . $raw . "\n");


