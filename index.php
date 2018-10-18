<?php

use Felis\Attica\AtticaClient;
require_once __DIR__ . '/vendor/autoload.php';



// ex .1
// HTTP GET request
$apiGithub = AtticaClient::GET("https://api.github.com/users/itpolsri")
    ->execute()
    // get rawResponse from server
    ->rawResponse();
echo($apiGithub . PHP_EOL);

// ex .2
// HTTP POST request (application/json)
$reqresResponse = AtticaClient::POST("https://reqres.in/api/users")
    ->sendJSON(
        array(
            'title'=>'Title',
            'body'=>"bar",
            'userId'=>1
        )
    )
    ->execute()
    // get rawResponse from server
    ->rawResponse();
echo($reqresResponse . PHP_EOL);


// ex .3
// HTTP POST request (application/x-www-form-urlencoded)
$httpBinResp = AtticaClient::POST("http://httpbin.org/post")
    ->sendFormData(
        array(
            'username'=>"asd",
            'password'=>'dsa'
        )
    )
    ->execute()
    ->jsonDecoded();

// mapping to stdClassObject
$formData = $httpBinResp->form;

$username = $formData->username;
$password = $formData->password;

echo (
    $username . PHP_EOL . $password . PHP_EOL
);



// ex .4  
// HTTP PUT request
$putResponse = AtticaClient::PUT("http://httpbin.org/put")
    ->sendJSON(
        array(
            'this'=>'is',
            'put'=>'method'
        )
    )
    ->execute()
    ->rawResponse();

echo (
    $putResponse . PHP_EOL
);

// ex .5
// HTTP DELETE REQUEST
$deleteResponse = AtticaClient::DELETE("http://httpbin.org/delete")
    ->sendJSON(
        array(
            'this'=>'is',
            'delete'=>'method'
        )
    )
    ->execute()
    ->rawResponse();

echo (
    $deleteResponse . PHP_EOL
);

