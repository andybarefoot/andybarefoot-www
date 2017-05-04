<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';

$sqlStmt="SELECT * FROM `gotChars` WHERE `charTV` = 1 AND `charFirst` != 0 ORDER BY `charFirst` ASC, `charInitTribe` ASC, `charApp` DESC";
$charResults=getData($sqlStmt);
$i=0;
foreach ($charResults as $char) {
	print "{\"charStart\":\"".$i."\",<br>\"charID\":\"".$char['charID']."\",<br>\"charName\":\"".$char['charName']."\",<br>\"charPath\":\"[[".$char['charFirst'].",0],[".$char['charLast'].",0]]\",<br>\"charTribes\":\"[";
	$sqlStmt="SELECT * FROM `gotAppearances` WHERE `appChar` = ".$char['charID']." GROUP BY `appTribe` ORDER BY `appEpisode` ASC;";
	$appResults=getData($sqlStmt);
	print "[".$appResults[0]['appEpisode'].",".$appResults[0]['appTribe']."]";
	for($j=1;$j<count($appResults);$j++){
		print ",[".$appResults[$j]['appEpisode'].",".$appResults[$j]['appTribe']."]";
	}
	print "]\"<br>},<br>";
	$i++;
}
?>