<?php

// ## Prepare your credentials, these are non-working example values, fill in values from your partner eshop, URL /admin/api-partner/?action=oauth

// Your client ID in the OAuth server
// This is an example only. For a specific value,
// refer to Partner e-shop administration -> Connections -> API partner -> Access to API
$clientId = 'ae5d72b8964a08ed';

// Your secret string for communicating with the OAuth server
// If, in Partner e-shop administration -> Connections -> API partner -> Access to API,
// you do not see the value, clientSecret has not been activated (older API partners),
// so do not send it in communication // with OAuth server
$clientSecret = 'dqwffewfsgdrgwefsfgdtjtkyodg';

// URL for authorization vs. OAuth server
// This is an example only. For a specific value,
// refer to Partner e-shop administration -> Connections -> API partner -> Access to API
$oAuthServerTokenUrl = 'https://12345.myshoptet.com/action/ApiOAuthServer/token';

// ## 1. Get OAuth Access Token (long-term secret token)
/*
    For more information, please visit
    https://developers.shoptet.com/api/documentation/installing-the-addon/

    We consider the installation of the addon to have been *UNsuccessful*, if upon a request with the code:
        You respond after more than 5 seconds.
        If you respond with an HTTP code other than 200
*/

// Received value of code
$code = $_GET['code'];

// OAuth server authorization type, always enter 'authorization_code'
$grantType = 'authorization_code';

// OAuth server rights group, always enter 'api'
$scope = 'api';

// URL entered on the addon settings page that you expect a request with the parameter 'code' for example:
$redirectUri = 'https://www.my-server.com/shoptet-installation';

// Sending the request to get secret_token
$data = [
    'client_id' => $clientId,
    'client_secret' => $clientSecret, // Enter only if set for you
    'code' => $code,
    'grant_type' => $grantType,
    'redirect_uri' => $redirectUri,
    'scope' => $scope,
];
$curl = curl_init($oAuthServerTokenUrl);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
$response = curl_exec($curl);
curl_close($curl);

/*
Expected response
{
   "access_token":"5wty54dv2y5jxaj9lu2glnb6upv2z7a6b3v92xsy06wfaeygmcfa3alg2gx2rdp8ozjqytb3l4eqfub4nbnbm7somfgup58wf6jjjstwyvdtp3kjmh08nhskl0z06qyso27l0q6op5udooofq15zhq7w3h1k4b6jj0j4o83hyar2fu9847e802t56xa87v81lblzed5kgvutjzrp3afvpsefit304q6g3pat0m09pzbd5iyu0qk55zwu6a31sq9",
   "expires_in": null,
   "token_type": "Bearer",
   "scope": "api",
   "eshopId": 222651,
   "eshopUrl": "https:\/\/12345.myshoptet.com\/",
   "contactEmail": "customer@example.com"
}
*/
$response = json_decode($response, TRUE);
echo "oAuth access token: " . $response['access_token'];
$oAuthAccessToken = $response['access_token']; // secret permanent token

// ## 2. Get API Access Token (short-term access token)
/*
    For more information, please visit
    https://developers.shoptet.com/api/documentation/getting-api-access-token/
*/

// The URL to gain an API access token, this is an example only; The specific value can be found in
// the partner e-shop administration -> Connection -> API partner -> Access to API
$apiAccessTokenUrl = 'https://12345.myshoptet.com/action/ApiOAuthServer/getAccessToken';

// OAuth access token is to be added to the request hader
$curl = curl_init($apiAccessTokenUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $oAuthAccessToken]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($curl);
curl_close($curl);

/*
Expected response
{
    "access_token":"123456-a-fltqc2nn5zg8y5h69jx8976ltwi2p1qg",
    "expires_in":1800
}
*/
$response = json_decode($response, TRUE);
$apiAccessToken = $response['access_token']; // Access Token (valid for 30 minutes)

// ## 3. Get eshop identity/id - sample API call
/*
    For more information, please visit
    https://shoptet.docs.apiary.io/#introduction/basic-principles-of-working-with-api/how-to-call-api
    https://shoptet.docs.apiary.io/#reference/eshop/eshop-info/eshop-info
*/

$curl = curl_init("https://api.myshoptet.com/api/eshop");
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    "Shoptet-Access-Token: ". $apiAccessToken,
    "Content-Type: application/vnd.shoptet.v1.0"
]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$jsonEndpointResponse = curl_exec($curl);
$endpointResponse = json_decode($jsonEndpointResponse, true);
curl_close($curl);

/*
Expected response
{
  "data": {
    "contactInformation": {
      "eshopId": 9993,
      "eshopName": "Shoptet",
      "eshopTitle": "Shoptet",
      "eshopCategory": "Technology",
      "eshopSubtitle": "Shop quickly and easily",
      "url": "http://www.domena-eshopu.cz",
      "contactPerson": "John Doe",
      "email": "info@domena-eshopu.cz",
      "phone": "+420777888999",
      "mobilePhone": "+420777888999",
      "skypeAccount": "shoptet_123",
      "contactPhotoUrl": "http://www.domena-eshopu.cz/...picture.jpg"
    },
(...)
}
*/
$eshopId = $endpointResponse['data']['contactInformation']['eshopId'];
