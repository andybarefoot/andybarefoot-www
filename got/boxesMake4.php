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


//$sqlStmt="SELECT * FROM `gotAppearances` LEFT JOIN `gotChars` ON `appChar` = `charID` LEFT JOIN `gotPlaces` ON `appPlace` = `placeID` ORDER BY `appEpisode` ASC, `combOrder` ASC";
$sqlStmt="SELECT * FROM `gotAppearances` LEFT JOIN `gotChars` ON `appChar` = `charID` LEFT JOIN `gotPlaces` ON `appPlace` = `placeID` ORDER BY `appEpisode` ASC, `combOrder` ASC";
$appResults=getData($sqlStmt);

$appearances = array();
$thisEpisode=0;
$thisRegion=0;
$emptyKey=1;

for($i=1;$i<=60;$i++){
	foreach ($appResults as $appKey=>$app) {
		if($app['appEpisode']==$i){
			$key=false;
			$key = array_search($app['charID'], $appearances[$app['appEpisode']-1][$app['combOrder']]);
			if($key){
				$appearances[$app['appEpisode']][$app['combOrder']][$key]=$app['charID'];
			}
		}
	}
	foreach ($appResults as $app) {
		if($app['appEpisode']==$i){
			if($app['combOrder']!=$thisRegion)$emptyKey=1;
			if($app['appEpisode']!=$thisEpisode)$emptyKey=1;
			$thisRegion = $app['combOrder'];
			$thisEpisode = $app['appEpisode'];
			$key = array_search($app['charID'], $appearances[$app['appEpisode']-1][$app['combOrder']]);
			if(!$key){
				while($appearances[$app['appEpisode']][$app['combOrder']][$emptyKey]){
					$emptyKey++;
				}
				$appearances[$app['appEpisode']][$app['combOrder']][$emptyKey]=$app['charID'];
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
	if($oldRegion!=$thisRegion){
		$regionCount++;
		$placeCount = 0;
	}
	$oldRegion=$thisRegion;
	$placeCount++;
	$thisMax = $regMax;
	$regionData = ["placeCode"=>$keyReg,"regionCount"=>$regionCount,"placeCount"=>$placeCount,"start"=>$totalMax,"size"=>$thisMax,"regionName"=>utf8_encode($placeLookup[$keyReg]['placeRegion']),"placeName"=>utf8_encode($placeLookup[$keyReg]['placeName'])];
	array_push($regions, $regionData);
	$totalMax+=$thisMax;
}

//print("<pre>".print_r($regions,true)."</pre>");

//print "],\"appearances\":[";

//print("<pre>".print_r($appearances,true)."</pre>");

foreach ($appearances as $keyEpp => $episode) {
	foreach ($episode as $keyReg => $region) {
		foreach ($region as $keyChar => $character) {
			$sqlStmt="SELECT * FROM `gotAppearances` WHERE `appChar` = ".$character." AND `appEpisode` = ".$keyEpp;
			$appResult=getData($sqlStmt);
			$seen = $appResult[0]["appSeen"];
			$charData = ["char"=>$character,"charName"=>$charLookup[$character]['charName'],"charTribe"=>$charLookup[$character]['charInitTribe'],"seen"=>$seen,"episode"=>$keyEpp,"placeCode"=>$keyReg,"order"=>$keyChar];
			if(!$flows[$character])$flows[$character] = array();
			array_push($flows[$character], $charData);
		}
	}
}


//print "]}";
//print("<pre>".print_r($flows,true)."</pre>");


$newFlows = [];
foreach ($flows as $keyFlow => $flow) {
//	print("<pre>".print_r($flow,true)."</pre>");
	array_push($newFlows, $flow);
}



$allData = ["regions"=>$regions,"flows"=>$newFlows];
//print("<pre>".print_r($allData,true)."</pre>");

$json = json_encode($allData);
 print_r($json);
//print("<pre>".print_r($json,true)."</pre>");
?>