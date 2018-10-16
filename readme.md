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
$postForm = AtticaClient::POST("http://httpbin.org/post");
$postForm->send(array(
    'username'=>'Hello',
    'password'=>'World'
), 'application/x-www-form-urlencoded')->execute();

// getting raw response from server
$raw = $postForm->rawResponse();
echo ("\n" . $raw . "\n");
```


More example below...


### More Examples...
```

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

```