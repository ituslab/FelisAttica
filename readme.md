## Felis Attica (Http Client)


Its just a simple http library to interface with php-curl 

we just provide helper method for you , so you don't need to interact with `curl_setopt` directly anymore

### php Curl to send data to server (too much `curl_setopt`)
--- 
```
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://www.example.com/tester.phtml");
curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, 
         http_build_query(array('postvar1' => 'value1')));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
curl_close ($ch);
```

### With our Attica Client (easy to use interface)
---
```
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
```


More example below...


> ### More Examples...


HTTP GET request

```
$apiGithub = AtticaClient::GET("https://api.github.com/users/itpolsri")
    ->execute()
    // get rawResponse from server
    ->rawResponse();
echo($apiGithub . PHP_EOL);
```


HTTP POST request (application/json)
```
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
```



HTTP POST request (application/x-www-form-urlencoded)
```
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
```


HTTP PUT request
```
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
```


HTTP DELETE REQUEST
```
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
```
