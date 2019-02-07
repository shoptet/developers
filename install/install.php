<?php

$clientId = 'n345d1wbbtairdpt';
$oAuthServer = 'https://doplnek.myshoptet.com/action/ApiOAuthServer/token';
$apiAccessTokenUrl = 'https://doplnek.myshoptet.com/action/ApiOAuthServer/getAccessToken';


// 1. Get OAuth Access Token (long-term secret token)
 
$code = $_GET['code'];

$data = [
    'code' => $code,
    'grant_type' =>  'authorization_code',
    'client_id' => $clientId,
    'redirect_uri' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'],
    'scope' => 'api'
];

$curl = curl_init($oAuthServer);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($curl);
curl_close($curl);

$response = json_decode($response, TRUE);
$oauth_access_token = $response['access_token'];  // secret token


// 2. Get API Access Token (short-term access token)

$curl = curl_init($apiAccessTokenUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $oauth_access_token]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response, TRUE);
$api_access_token = $data['access_token'];


// 3. Get eshop identity - call API

$curl = curl_init("https://api.myshoptet.com/api/eshop");
curl_setopt($curl, CURLOPT_HTTPHEADER, [
	"Shoptet-Access-Token: $api_access_token",
    "Content-Type: application/vnd.shoptet.v1.0"
]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($curl);
$data = json_decode($response, TRUE);
$code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($curl);

print "Http Response: $code\n";
print_r($data);
print "Eshop: " . $data['data']['contactInformation']['eshopId'] . "\n";
