<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';


// set up an array we can query to get character details from the CharID
$sqlStmt="SELECT * FROM `gotChars`";
$charResults=getData($sqlStmt);
$charLookup = array();
// put all the details of the character in an array with the CharId as the key 
foreach($charResults as $char){
	$charLookup[$char['charID']]=$char;
}

// set up an array we can query to get place details from the PlaceID
$sqlStmt="SELECT * FROM `gotPlaces`";
$placeResults=getData($sqlStmt);
$placeLookup = array();
// put all the details of the place in an array with the PlaceID as the key 
foreach($placeResults as $place){
	$placeLookup[$place['combOrder']]=$place;
}
$placeLookup2 = array();
// put all the details of the place in an array with the PlaceID as the key 
foreach($placeResults as $place){
	$placeLookup2[$place['regionOrder']]=$place;
}

//$sqlStmt="SELECT * FROM `gotAppearances` LEFT JOIN `gotChars` ON `appChar` = `charID` LEFT JOIN `gotPlaces` ON `appPlace` = `placeID` ORDER BY `appEpisode` ASC, `combOrder` ASC";
//$sqlStmt="SELECT * FROM `gotAppearances` LEFT JOIN `gotChars` ON `appChar` = `charID` LEFT JOIN `gotPlaces` ON `appPlace` = `placeID` ORDER BY `appEpisode` ASC, `combOrder` ASC";
$sqlStmt="SELECT * FROM `gotAppearances` LEFT JOIN `gotChars` ON `appChar` = `charID` LEFT JOIN `gotPlaces` ON `appPlace` = `placeID` WHERE `charTravel` =1 AND `charApp` >2 ORDER BY `appEpisode` ASC, `combOrder` ASC";
$appResults=getData($sqlStmt);

$appearances = array(); // this will be filled with arrays corresponding to each episode, whihc inturn will contain arrays for each place, which in turn will hold character appearences...
$thisEpisode=0;
$thisRegion=0;
$emptyKey=1;

// loop through each episode number 
for($i=1;$i<=60;$i++){
	// loop through every appearance 
	foreach ($appResults as $appKey=>$app) {
		// if appearance matches episode
		if($app['appEpisode']==$i){
			$key=false;
			$needle = $app['charID'];
			$haystack = $appearances[$app['appEpisode']-1][$app['regionOrder']];
			// find the Character ID in the corresponding place array in the episode array in the overall appearences array...
			$key = array_search($needle, $haystack);
			if($key){
				$appearances[$app['appEpisode']][$app['regionOrder']][$key]=$app['charID'];
			}
		}
	}
	foreach ($appResults as $app) {
		if($app['appEpisode']==$i){
			if($app['regionOrder']!=$thisRegion)$emptyKey=1;
			if($app['appEpisode']!=$thisEpisode)$emptyKey=1;
			$thisRegion = $app['regionOrder'];
			$thisEpisode = $app['appEpisode'];
			$key = array_search($app['charID'], $appearances[$app['appEpisode']-1][$app['regionOrder']]);
			if(!$key){
				while($appearances[$app['appEpisode']][$app['regionOrder']][$emptyKey]){
					$emptyKey++;
				}
				$appearances[$app['appEpisode']][$app['regionOrder']][$emptyKey]=$app['charID'];
			}
		}
	}
}

//print("<pre>".print_r($appearances,true)."</pre>");

//print "<br><br>";


$regionMax = array();



foreach ($appearances as $keyEpp => $episode) {
	foreach ($episode as $keyReg => $region) {
		if($regionMax[$keyReg]<count($region)){
			$regionMax[$keyReg]=count($region);
		}
	}
}

//print_r($regionMax);

$flows = array();
$regions = array();

//print "{\"places\":[";

ksort ($regionMax);

//print("<pre>".print_r($regionMax,true)."</pre>");

$regionCount = 0;
$placeCount = 0;
$totalMax = 0;
$oldRegion = "";
foreach ($regionMax as $keyReg => $regMax) {
	$thisRegion = $placeLookup[$keyReg]['regionOrder'];
	$thisRegionName = $placeLookup2[$keyReg]['placeRegion'];
	if($oldRegion!=$thisRegion){
		$regionCount++;
		$placeCount = 0;
	}
	$oldRegion=$thisRegion;
	$placeCount++;
	$thisMax = $regMax;
	print "Key Reg = ".$keyReg;
	print "Name = ".$thisRegionName;
	$regionData = ["placeCode"=>$keyReg,"regionCount"=>$regionCount,"placeCount"=>$placeCount,"start"=>$totalMax,"size"=>$thisMax,"regionName"=>utf8_encode($placeLookup2[$keyReg]['placeRegion']),"placeName"=>utf8_encode($placeLookup2[$keyReg]['placeName'])];
	array_push($regions, $regionData);
	$totalMax+=$thisMax;
}
print_r($placeLookup);
//print("<pre>".print_r($regions,true)."</pre>");

//print "],\"appearances\":[";

//print("<pre>".print_r($appearances,true)."</pre>");

foreach ($appearances as $keyEpp => $episode) {
	foreach ($episode as $keyReg => $region) {
		foreach ($region as $keyChar => $character) {
			$sqlStmt="SELECT * FROM `gotAppearances` WHERE `appChar` = ".$character." AND `appEpisode` = ".$keyEpp;
			$appResult=getData($sqlStmt);
			$seen = $appResult[0]["appSeen"];
			$charData = ["char"=>$character,"charName"=>$charLookup[$character]['charName'],"charURL"=>$charLookup[$character]['charURL'],"charThumb"=>$charLookup[$character]['charThumb'],"charDead"=>$charLookup[$character]['charDead'],"charBackground"=>$charLookup[$character]['charBackground'],"charSigil"=>$charLookup[$character]['charSigil'],"seen"=>$seen,"episode"=>$keyEpp,"placeCode"=>$keyReg,"order"=>$keyChar];
			if(!$flows[$character])$flows[$character] = array();
			array_push($flows[$character], $charData);
		}
	}
}


//print "]}";
//print("<pre>".print_r($flows,true)."</pre>");


$newFlows = [];
foreach ($flows as $keyFlow => $flow) {
	$thisChar = [];
	$thisChar['appearances'] = [];
	$lastEpisode=0;
	$lastPlace=0;
	$lastOrder=0;
//	print("<pre>".print_r($flow,true)."</pre>");
	foreach ($flow as $subkey => $subflow) {
		if ($subflow === end($flow)){
			$subflow['isLast'] = "1";
		}
		$thisChar['charID'] = $subflow['char'];
		$thisChar['charName'] = $subflow['charName'];
		$thisChar['charURL'] = $subflow['charURL'];
		$thisChar['charThumb'] = $subflow['charThumb'];
		$thisChar['charDead'] = $subflow['charDead'];
		$thisChar['charSigil'] = $subflow['charSigil'];
		$thisChar['charBackground'] = $subflow['charBackground'];
//		unset($subflow['char']);
		unset($subflow['charName']);
		unset($subflow['charURL']);
		unset($subflow['charThumb']);
		unset($subflow['charSigil']);
		$subflow['lastEpisode'] = $lastEpisode;
		$subflow['lastPlace'] = $lastPlace;
		$subflow['lastOrder'] = $lastOrder;
		$subflow['appEpisode'] = $subflow['episode'];
		unset($subflow['episode']);
		if($subflow['seen']==0){
//			unset($flow[$subkey]);
		}else{
			$lastEpisode = $subflow['appEpisode'];
			$lastPlace = $subflow['placeCode'];
			$lastOrder = $subflow['order'];
			unset($subflow['seen']);
			array_push($thisChar['appearances'], $subflow);
		}
	}
	array_push($newFlows, $thisChar);
}




$allData = ["regions"=>$regions,"characters"=>$newFlows];
//print("<pre>".print_r($allData,true)."</pre>");

$json = json_encode($allData);
 print_r($json);
//print("<pre>".print_r($json,true)."</pre>");
?>