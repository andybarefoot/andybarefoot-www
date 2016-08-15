<?

include_once '../../includes/db-olympics.php';
include_once '../../includes/dbactions.php';

// Function for making a GET request using cURL
function curlGet($url) {
	$ch = curl_init();	// Initialising cURL session
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);	// Returning transfer as a string
	curl_setopt($ch, CURLOPT_URL, $url);	// Setting URL
	$results = curl_exec($ch);	// Executing cURL session
	return $results;	// Return the results
}

function returnXPathObject($item) {
	$xmlPageDom = new DomDocument();	// Instantiating a new DomDocument object
	@$xmlPageDom->loadHTML($item);	// Loading the HTML from downloaded page
	$xmlPageXPath = new DOMXPath($xmlPageDom);	// Instantiating new XPath DOM object
	return $xmlPageXPath;	// Returning XPath object
}

function getMedals(){
	$pageSrc =  curlGet('http://www.bbc.co.uk/sport/olympics/rio-2016/medals/countries');
	$pageXPath = returnXPathObject($pageSrc);	// Instantiating new XPath DOM object
	// HANDLE STATUS
	$thisContent = $pageXPath->query("//tr[contains(@class, 'medals-table__row--country')]");	// Querying for href attributes of pagination
	if ($thisContent->length > 0) {
		foreach ($thisContent as $row) {
			$countries = $pageXPath->query(".//abbr/@title", $row);
			$country = $countries->item(0)->nodeValue;
			print $country."<br>";
			$golds = $pageXPath->query(".//td[@class='medals-table__total--gold']", $row);
			$gold = $golds->item(0)->nodeValue;
			print $gold."<br>";
			$silvers = $pageXPath->query(".//td[@class='medals-table__total--silver']", $row);
			$silver = $silvers->item(0)->nodeValue;
			print $silver."<br>";
			$bronzes = $pageXPath->query(".//td[@class='medals-table__total--bronze']", $row);
			$bronze = $bronzes->item(0)->nodeValue;
			print $bronze."<br>";
			$totals = $pageXPath->query(".//td[@class='medals-table__total']", $row);
			$total = $totals->item(0)->nodeValue;
			print $total."<br>";
			$sqlStmt="UPDATE `TABLE 1` SET `Gold`=$gold,`Silver`=$silver,`Bronze`=$bronze,`Total`=$total WHERE `Country`='$country'";
			$update = updateData($sqlStmt);
			print $update."<br>";
		}
	}
}

getMedals();

?>