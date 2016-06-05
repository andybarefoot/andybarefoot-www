<?

function findPhotos($url){
	$thisPageUrl = $url;
	$thisPageSrc = curlGet($thisPageUrl);	// Requesting initial results page
	$thisPageXPath = returnXPathObject($thisPageSrc);	// Instantiating new XPath DOM object
	$thisPageUrls = $thisPageXPath->query('//script');	// Querying for href attributes of pagination
	
	// If results exist
	if ($thisPageUrls->length > 0) {
		// For each results page URL
		for ($i = 0; $i < $thisPageUrls->length; $i++) {
			$checkStr = 'window._sharedData = ';
			$jscriptString = $thisPageUrls->item($i)->nodeValue;
			$isThis = strpos($jscriptString,$checkStr);
			if ($isThis !== false){
				$data = rtrim(substr($jscriptString, $isThis + strlen($checkStr)), ";");
				$json = json_decode($data, true);
				$nodes = $json['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
				return $nodes;
			}
		}
	}
}


// Function for making a GET request using cURL
function curlGet($url) {
	$ch = curl_init();	// Initialising cURL session
	// Setting cURL options
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);	// Returning transfer as a string
//	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);	// Follow location
	curl_setopt($ch, CURLOPT_URL, $url);	// Setting URL
	$results = curl_exec($ch);	// Executing cURL session
	return $results;	// Return the results
}

// Funtion to return XPath object
function returnXPathObject($item) {
	$xmlPageDom = new DomDocument();	// Instantiating a new DomDocument object
	@$xmlPageDom->loadHTML($item);	// Loading the HTML from downloaded page
	$xmlPageXPath = new DOMXPath($xmlPageDom);	// Instantiating new XPath DOM object
	return $xmlPageXPath;	// Returning XPath object
}

$newNodes = findPhotos('https://www.instagram.com/andybarefoot/');

$andyText = file_get_contents('../html/api/instagram/andybarefoot.txt');
$andyData = json_decode($andyText, true);
$andyNodes = $andyData['nodes'];


for($i = count($newNodes); $i > 0; $i--){
	$newCode = $newNodes[$i-1]['code'];
	$exists = false;
	foreach($andyNodes as $andyNode){
		if($newCode == $andyNode['code']){
			$exists = true;
		}
	}
	if(!$exists){
		array_unshift($andyNodes, $newNodes[$i-1]);
	}
}

$allData = ["nodes" => $andyNodes];
$newText = json_encode($allData);
file_put_contents ('../html/api/instagram/andybarefoot.txt', $newText);

$newNodes = findPhotos('https://www.instagram.com/gunterguntychops/');

$andyText = file_get_contents('../html/api/instagram/gunterguntychops.txt');
$andyData = json_decode($andyText, true);
$andyNodes = $andyData['nodes'];


for($i = count($newNodes); $i > 0; $i--){
	$newCode = $newNodes[$i-1]['code'];
	$exists = false;
	foreach($andyNodes as $andyNode){
		if($newCode == $andyNode['code']){
			$exists = true;
		}
	}
	if(!$exists){
		array_unshift($andyNodes, $newNodes[$i-1]);
	}
}

$allData = array("nodes" => $andyNodes);
$newText = json_encode($allData);
file_put_contents ('../html/api/instagram/gunterguntychops.txt', $newText);

?>
