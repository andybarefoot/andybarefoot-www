<?php

require_once __DIR__ . '../../../../vendor/autoload.php';
date_default_timezone_set('UTC');

$fb = new Facebook\Facebook([
  'app_id' => '107647812773',
  'app_secret' => '9c4b4e125b103efe4e041974452e1455',
  'default_graph_version' => 'v2.2',
  ]);

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me/posts?fields=privacy,id,type,message,link,name,caption,description,created_time,full_picture,picture&include_hidden=false&limit=1000', 'EAAAAGRBPRKUBAOyJ8XSiYdZBZCbiyrNw3GDLJ6FMDd9uI1gm4pi0ZAPHflpaqVcAAIob2Hb0NtqrgjMNkIfh3RV6Qtn3oSWfLZBNytu9qfnrDxyzwm6ApJZAaWBRKTL8YXf737NYnlhuS3WUnX3xQPBQe5x3cgjxv6ey7I1tHZBpvnsCRj441ctzueQ8zGoaUZD');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
//print_r($response);

$graphEdge = $response->getGraphEdge();
//print_r($graphEdge);

$facebookArray = [];
$feedArray = [];

// Iterate over all the GraphNode's returned from the edge
foreach ($graphEdge as $graphNode) {
//	print_r($graphNode);
//	print "<hr>";
	$postArray = [];
	$privacy="";
	foreach ($graphNode as $key => $value) {
		print_r($key);
		print " :: ";
		print_r($value);
		print "<br>";
		$postArray['facebook']='true';
		if($key=="privacy")$privacy=$value['value'];
		print "PRIVACY";
		print_r($privacy);
		print "<br>";
		if($key=="id")$postArray['id']=$value;
		if($key=="type")$postArray['type']=$value;
		if($key=="message")$postArray['message']=nl2br($value);
		if($key=="picture")$postArray['picture']=$value;
		if($key=="full_picture")$postArray['full_picture']=$value;
		if($key=="link")$postArray['link']=$value;
		if($key=="name")$postArray['name']=$value;
		if($key=="caption")$postArray['caption']=$value;
		if($key=="description")$postArray['description']=$value;
		if($key=="created_time")$postArray['date']=$value->getTimestamp();
	}
	if(($privacy=="EVERYONE")||($privacy=="ALL_FRIENDS")){
		array_push($feedArray, $postArray);
	}
	print "<hr>";
}
$facebookArray['nodes']=$feedArray;

$string = json_encode($facebookArray);
//print "<hr>Helo<hr>";
print_r($string);
//echo 'Name: ' . $user['name'];
// OR
// echo 'Name: ' . $user->getName();


//"created_time":{"date":"2016-10-21 18:26:57.000000","timezone_type":1,"timezone":"+00:00"}},


?>