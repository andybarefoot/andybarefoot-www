<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';



$sqlStmt="SELECT * FROM `gotChars`";
$charResults=getData($sqlStmt);

$charLookup = array();
foreach($charResults as $char){
	$charLookup[$char['charID']]=$char;
}

$sqlStmt="SELECT * FROM `gotPlaces`";
$placeResults=getData($sqlStmt);

$placeLookup = array();
foreach($placeResults as $place){
	$placeLookup[$place['regionOrder']]=$place;
}


$sqlStmt="SELECT * FROM `gotAppearances` LEFT JOIN `gotChars` ON `appChar` = `charID` LEFT JOIN `gotPlaces` ON `appPlace` = `placeID` ORDER BY `appEpisode` ASC, `regionOrder` ASC, `placeOrder` ASC";
// $sqlStmt="SELECT * FROM `gotAppearances` LEFT JOIN `gotChars` ON `appChar` = `charID` LEFT JOIN `gotPlaces` ON `appPlace` = `placeID` WHERE  `regionOrder` = 1 ORDER BY `appEpisode` ASC, `regionOrder` ASC, `placeOrder` ASC LIMIT 0,50";
$appResults=getData($sqlStmt);

// $i=0;
// $thisRegion=0;
// foreach ($appResults as $app) {
// 	if($app['regionOrder']!=$thisRegion)$i=0;
// 	$thisRegion = $app['regionOrder'];
// 	print "{\"order\":\"".$i."\",<br>\"appEpisode\":\"".$app['appEpisode']."\",<br>\"charID\":\"".$app['charID']."\",<br>\"charName\":\"".$app['charName']."\",<br>\"charTribe\":\"".$app['charInitTribe']."\",<br>\"placeRegion\":\"".$app['placeRegion']."\",<br>\"placeName\":\"".$app['placeName']."\",<br>\"placeOrder\":\"".$app['placeOrder']."\",<br>\"regionOrder\":\"".$app['regionOrder']."\"<br>},<br>";
// 	$i++;
// }


$appearances = array();
$thisEpisode=0;
$thisRegion=0;
$emptyKey=1;
// foreach ($appResults as $app) {
// 	if($app['regionOrder']!=$thisRegion)$emptyKey=0;
// 	if($app['appEpisode']!=$thisEpisode)$emptyKey=0;
// 	$thisRegion = $app['regionOrder'];
// 	$thisEpisode = $app['appEpisode'];
// 	if($app['charID']==1)print $app['appEpisode']." AEMON <br>";
// 	$key = array_search($app['charID'], $appearances[$app['appEpisode']-1][$app['regionOrder']]);
// 	if(!$key){
// 		if($app['charID']==1)print " CHECK AEMON <br>";
// 		while($appearances[$app['appEpisode']][$app['regionOrder']][$emptyKey]){
// 			$emptyKey++;
// 		}
// 		$key = $emptyKey;
// 	}
// 	$appearances[$app['appEpisode']][$app['regionOrder']][$key]=$app['charID'];
// }
for($i=1;$i<=60;$i++){
	foreach ($appResults as $appKey=>$app) {
		if($app['appEpisode']==$i){
			$key=false;
			$key = array_search($app['charID'], $appearances[$app['appEpisode']-1][$app['regionOrder']]);
			if($key){
				$appearances[$app['appEpisode']][$app['regionOrder']][$key]=$app['charID'];
//				print "add:".$app['appEpisode'].":".$key."<br>";
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
//				print "add2:".$app['appEpisode'].":".$emptyKey."<br>";
			}
		}
	}
}

//print_r($appearances);

//print "<br><br>";
foreach ($appearances as $keyEpp => $episode) {
	foreach ($episode as $keyReg => $region) {
		foreach ($region as $keyChar => $character) {
//				print $characterDetails[0].":".$characterDetails[1]."<br>";
		 	print "{\"order\":\"".$keyChar."\",<br>
		 	\"appEpisode\":\"".$keyEpp."\",<br>
		 	\"charID\":\"".$character."\",<br>
		 	\"charName\":\"".$charLookup[$character]['charName']."\",<br>
		 	\"charTribe\":\"".$charLookup[$character]['charInitTribe']."\",<br>
		 	\"placeRegion\":\"".$placeLookup[$keyReg]['placeRegion']."\",<br>
		 	\"placeName\":\"null\",<br>
		 	\"placeOrder\":\"0\",<br>
		 	\"regionOrder\":\"".$keyReg."\"<br>
		 },<br>";
		}
	}
}

?>