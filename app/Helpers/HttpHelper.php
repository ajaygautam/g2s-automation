<?php
namespace App\Helpers;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
/**
* Class to handle all RESTful requests
*/
class HttpHelper
{
private $guzzle;

/**
 *
* HttpHelper constructor.
*/

public function __construct($base_uri=null)
{

  if($base_uri==null){
      $base_uri = env('OAUTH_URL');
  }

//   $userID = 'ACUITY_USER_ID';
// $key = 'ACUITY_API_KEY';

// // URL for all appointments (just an example):
// $url = 'https://acuityscheduling.com/api/v1/appointments.json';

// // Initiate curl:
// // GET request, so no need to worry about setting post vars:
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);

// // Grab response as string:
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// // HTTP auth:
// curl_setopt($ch, CURLOPT_USERPWD, "$userID:$key");

// // Execute request:
// $result = curl_exec($ch);

// // Don't forget to close the connection!
// curl_close($ch);

// $data = json_decode($result, true);
// print_r($data);


  $base_uri = 'https://acuityscheduling.com/api/v1/'; 

  $this->guzzle = new Client([
      'base_uri' => $base_uri,
      'auth' => ['17991306','8943a1c9176ca6aac7db3a1231514ebe']
      ]);
}



/*
* @param $endpoint
* @param $array - Array of data to be JSON encoded
* @return mixed
*/
public function post($endpoint, $array) {

    $response = $this->guzzle->post($this->cleanEndpoint($endpoint), [
        'headers' => [
            'Content-Type : application/json; charset=UTF8',
            'accept : application/json',
            // 'timeout' => 10,
        ],
        'json' => $array
    ]);

    $body = json_decode($response->getBody());
    $headers = $response->getHeaders();



    if($body->statusCode=='200')
    {
        return [$body->data,$headers];
    }
    else
    {
        return $body;
    }
    // echo '<pre>';
    // print_r($body);
    // die;
    // return $body;
}


public function validateToken($endpoint, $token) {
//    echo 'token ='. $token; die;

    $response = $this->guzzle->post($this->cleanEndpoint($endpoint),
        [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token ,
            ]
        ]);

    $body = json_decode($response->getBody());

    return $body;
}



private function cleanEndpoint($endpoint) {
    $endpoint = ltrim($endpoint,"/");
    $endpoint = rtrim($endpoint,"/");
    return $endpoint;
}

}
