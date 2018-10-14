## Felis Attica (Http Client)


### Example of synchronous request
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

### Example of asynchronous request (based on Guzzle promises)

```
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

```