<?php

require_once realpath(dirname(__FILE__).'/google-api-php-client/autoload.php');

$client_email = '1234567890-a1b2c3d4e5f6g7h8i@developer.gserviceaccount.com';
$private_key = file_get_contents('../../Image Recognition Demo-2d096a68fdc7.p12');
$scopes = array('https://www.googleapis.com/auth/cloud-platform');
$credentials = new Google_Auth_AssertionCredentials(
    $client_email,
    $scopes,
    $private_key
);

$client = new Google_Client();
$client->setAssertionCredentials($credentials);
if ($client->getAuth()->isAccessTokenExpired()) {
  $client->getAuth()->refreshTokenWithAssertion();
}

$sqladmin = new Google_Service_SQLAdmin($client);
$response = $sqladmin->instances
    ->listInstances('examinable-example-123')->getItems();
echo json_encode($response) . "\n";

?>