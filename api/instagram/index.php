<?

$ACCESS_TOKEN = "1539646.cdc645c.ecbd4d1a0a7d4e36905e6da028726ca8";

$CALL = $_GET["call"];


$COUNT = intval($_GET["count"]);
$MIN_ID = $_GET["min_id"];
$MAX_ID = $_GET["max_id"];

if($COUNT<=0)$COUNT=0;

// PARAMETERS
// ACCESS_TOKEN	A valid access token.
// COUNT	Count of media to return.
// MIN_ID	Return media later than this min_id.
// MAX_ID	Return media earlier than this max_id.

function getPhotos($apiURL){
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $apiURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$curlout = curl_exec($ch);
	curl_close($ch);
	$instagramData = json_decode($curlout, true);
	$photos = $instagramData["data"];
	return $curlout;
}


if($CALL === 'media-self'){
	global $ACCESS_TOKEN;
	global $COUNT;
	global $MIN_ID;
	global $MAX_ID;
	$photos_url = "https://api.instagram.com/v1/users/self/media/recent/?access_token=".$ACCESS_TOKEN;
	if($COUNT!=0)$photos_url .= "&count=".$COUNT;
	if($MIN_ID!=0)$photos_url .= "&min_id=".$MIN_ID;
	if($MAX_ID!=0)$photos_url .= "&max_id=".$MAX_ID;
	print getPhotos($photos_url);
}else if($CALL === 'media-all'){
	global $ACCESS_TOKEN;
	global $COUNT;
	global $MIN_ID;
	global $MAX_ID;
	$photos_url = "https://api.instagram.com/v1/users/175694806/media/recent/?access_token=".$ACCESS_TOKEN;
	if($COUNT!=0)$photos_url .= "&count=".$COUNT;
	if($MIN_ID!=0)$photos_url .= "&min_id=".$MIN_ID;
	if($MAX_ID!=0)$photos_url .= "&max_id=".$MAX_ID;
	print getPhotos($photos_url);
}else if($CALL === 'search'){
	global $ACCESS_TOKEN;
	$photos_url = "https://api.instagram.com/v1/users/search?q=gunterguntychops&access_token=".$ACCESS_TOKEN;
	print getPhotos($photos_url);
}

?>