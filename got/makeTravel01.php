<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';

$resultsArray = array();
$resultsArray['characters'] = array();

//$sqlStmt="SELECT * FROM `gotAppearances` LEFT JOIN `gotChars` ON `appChar` = `charID` LEFT JOIN `gotPlaces` ON `appPlace` = `placeID` ORDER BY `appEpisode` ASC, `combOrder` ASC";
$sqlStmt="SELECT * FROM `gotChars` WHERE `charUse`=1 AND `charImportant`=1 ORDER BY `charSigil` DESC";
$charResults=getData($sqlStmt);

foreach ($charResults as $char){
	$newChar = array();
	$newChar['charID'] = $char['charID'];
	$newChar['charName'] = utf8_encode($char['charName']);
	$newChar['charURL'] = $char['charURL'];
	$newChar['charThumb'] = $char['charThumb'];
	$newChar['charDead'] = $char['charDead'];
	$newChar['charSigil'] = $char['charSigil'];
	$newChar['charBackground'] = $char['charBackground'];
	$newChar['appearances'] = array();
	$sqlStmt="SELECT * FROM `gotAppearances`,`gotPlaces` WHERE `appPlace`= `placeID` AND `appChar`=".$newChar['charID']." AND `appSeen`=1 ORDER BY `gotAppearances`.`appEpisode` ASC";
	$appResults=getData($sqlStmt);
	$lastEpisode = 0;
	foreach ($appResults as $app){
		$newApp = array();
		$newApp['appEpisode'] = $app['appEpisode'];
		$newApp['placeName'] = utf8_encode($app['placeName']);
		$newApp['placeRegion'] = $app['placeRegion'];
		$newApp['regionOrder'] = $app['regionOrder'];
		$newApp['placeOrder'] = $app['placeOrder'];
		$newApp['combOrder'] = $app['combOrder'];
		$newApp['charBackground'] = $char['charBackground'];
		$newApp['lastEpisode'] = $lastEpisode;
		$lastEpisode = $newApp['appEpisode'];
		array_push($newChar['appearances'], $newApp);
	}
	array_push($resultsArray['characters'], $newChar);
}

//print_r($fullArray);

$json = json_encode($resultsArray);
print $json;
//print("<pre>".print_r($json,true)."</pre>");

file_put_contents ('timeline.json', $json);

?>