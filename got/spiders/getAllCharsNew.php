<?php

include_once '../../../includes/db-got.php';
include_once '../../../includes/dbactions.php';

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

function getAllChars(){
	$allCharacters = curlGet('https://gameofthrones.fandom.com/wiki/Category:Deceased_individuals');

	$charData = json_decode($allCharacters, true);
	$charItems = $charData['items'];
	foreach ($charItems as $char) {
		print ($char['id']);
		print " : ";
		print ($char['title']);
		print " : ";
		print ($char['url']);
		$thisWikiID = $char['id'];
		$thisTitle = mysql_real_escape_string($char['title']);
		$thisURL = "http://gameofthrones.wikia.com".$char['url'];
		$sqlStmt="SELECT * FROM `gotChars` WHERE `gotChars`.`charWikiID` ='$thisWikiID';";
		$charResults=getData($sqlStmt);
		if(count($charResults)>=1){
	// edit existing char
			$thisID=$charResults[0]['charID'];
			$sqlStmt="UPDATE  `gotChars` SET  `charWikiID` =  '$thisWikiID', `charName` =  '$thisTitle', `charURL` =  '$thisURL' WHERE  `gotChars`.`charID` ='$thisID';";
//			updateData($sqlStmt);
		}else{
	// create new char
			$sqlStmt="INSERT INTO `gotChars` (`charID`, `charWikiID`, `charName`, `charURL`) VALUES (NULL, '$thisWikiID', '$thisTitle', '$thisURL');";
//			$thisProduct=insertDataReturnID($sqlStmt);
		}
		print "</br>";
	}
}

function getAllDeadChars(){
	$file_string = file_get_contents('deadCharsText.html');
//	preg_match_all('/<a.*href="(.*)".*<\/a/i', $file_string, $links);


	$regexp = 'href="(.*)".*>(.*)<\/a';
	if(preg_match_all("/$regexp/siU", $file_string, $links, PREG_SET_ORDER)){
//		$localID=$matches[0][2];
//		$productArray["id"]=$localID;
//		print_r($links);
		foreach($links as $link){
			$thisURL="http://gameofthrones.wikia.com".$link[1];
			$sqlStmt="SELECT * FROM `gotChars` WHERE `gotChars`.`charURL` ='$thisURL';";
			$charResults=getData($sqlStmt);
			if(count($charResults)>=1){
				if($charResults[0]['charDead']==0){
					print_r("<a href='http://gameofthrones.wikia.com".$link[1]."'>");
					print_r($link[2]);
					print "</a><br>";
				}
			}else{

				// print_r("<a href='http://gameofthrones.wikia.com".$link[1]."'>");
				// print_r($link[2]);
				// print "</a><br>";
			}
		}
	}



//	<a href="/wiki/Aegon_Ambrose" title="Aegon Ambrose" class="category-page__member-link">Aegon Ambrose</a>


//	print_r($links);
	// foreach($links[0] as $link){
	// 	print_r($link);
	// 	print "<br>";
	// }

}

getAllDeadChars();

//getAllChars();

?>