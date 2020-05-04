<?php

// fill in values from your partner eshop, URL /admin/api-partner/?action=oauth
$clientId = 'n345d1wbbtairdpt';
$clientSecret = 'UZL8GIl9CkEhERCwUItT8ErwLFAUL4dW';
$oAuthServer = 'https://doplnek.myshoptet.com/action/ApiOAuthServer/token';
$apiAccessTokenUrl = 'https://doplnek.myshoptet.com/action/ApiOAuthServer/getAccessToken';

// 1. Get OAuth Access Token (long-term secret token)
 
$code = $_GET['code'];

$oAuthRequest = [
    'code' => $code,
    'grant_type' =>  'authorization_code',
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'redirect_uri' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'],
    'scope' => 'api'
];

$curl = curl_init($oAuthServer);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $oAuthRequest);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$jsonOAuthResponse = curl_exec($curl);
$statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($curl);

$oAuthResponse = json_decode($jsonOAuthResponse, true);
save('OAuth Access Token (permanent)', $statusCode, $oAuthResponse);
$oauthAccessToken = $oAuthResponse['access_token'];  // secret permanent token


// 2. Get API Access Token (short-term access token)

$curl = curl_init($apiAccessTokenUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $oauthAccessToken]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$jsonAccessTokenResponse = curl_exec($curl);
$statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($curl);

$accessTokenResponse = json_decode($jsonAccessTokenResponse, true);
save('Access Token (valid for 30 minutes)', $statusCode, $accessTokenResponse);
$apiAccessToken = $accessTokenResponse['access_token'];


// 3. Get eshop identity - call API

$curl = curl_init("https://api.myshoptet.com/api/eshop");
curl_setopt($curl, CURLOPT_HTTPHEADER, [
	"Shoptet-Access-Token: $apiAccessToken",
    "Content-Type: application/vnd.shoptet.v1.0"
]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$jsonEndpointResponse = curl_exec($curl);
$endpointResponse = json_decode($jsonEndpointResponse, true);
$statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($curl);

save('Eshop info', $statusCode, $endpointResponse);
$eshopId = $data['data']['contactInformation']['eshopId'];

function save($caption, $code, $struct) {
    $entry = sprintf("%s %s: %d\n%0s", date('c'), $caption, $code, print_r($struct, true));
    file_put_contents('log.txt', $entry, FILE_APPEND);
}