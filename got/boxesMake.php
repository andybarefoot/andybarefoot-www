<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';




// $sqlStmt="SELECT * FROM `gotChars` WHERE `charTV` = 1 AND `charFirst` != 0 ORDER BY `charFirst` ASC, `charInitTribe` ASC, `charApp` DESC";
// $charResults=getData($sqlStmt);
// $i=0;
// foreach ($charResults as $char) {
// 	print "{\"charStart\":\"".$i."\",<br>\"charID\":\"".$char['charID']."\",<br>\"charName\":\"".$char['charName']."\",<br>\"charPath\":\"[[".$char['charFirst'].",0],[".$char['charLast'].",0]]\",<br>\"charTribes\":\"[";
// 	$sqlStmt="SELECT * FROM `gotAppearances` WHERE `appChar` = ".$char['charID']." GROUP BY `appTribe` ORDER BY `appEpisode` ASC;";
// 	$appResults=getData($sqlStmt);
// 	print "[".$appResults[0]['appEpisode'].",".$appResults[0]['appTribe']."]";
// 	for($j=1;$j<count($appResults);$j++){
// 		print ",[".$appResults[$j]['appEpisode'].",".$appResults[$j]['appTribe']."]";
// 	}
// 	print "]\"<br>},<br>";
// 	$i++;
// }


$sqlStmt="SELECT * FROM `gotAppearances` LEFT JOIN `gotChars` ON `appChar` = `charID` LEFT JOIN `gotPlaces` ON `appPlace` = `placeID` ORDER BY `appEpisode` ASC, `regionOrder` ASC, `placeOrder` ASC";
$appResults=getData($sqlStmt);

$i=0;
$thisEpp=0;
foreach ($appResults as $app) {
	if($app['appEpisode']!=$thisEpp)$i=0;
	$thisEpp = $app['appEpisode'];
	print "{\"order\":\"".$i."\",<br>\"appEpisode\":\"".$app['appEpisode']."\",<br>\"charID\":\"".$app['charID']."\",<br>\"charName\":\"".$app['charName']."\",<br>\"charTribe\":\"".$app['charInitTribe']."\",<br>\"placeRegion\":\"".$app['placeRegion']."\",<br>\"placeName\":\"".$app['placeName']."\",<br>\"placeOrder\":\"".$app['placeOrder']."\",<br>\"regionOrder\":\"".$app['regionOrder']."\"<br>},<br>";
	$i++;
}


?>