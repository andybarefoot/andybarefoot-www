<?php

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';



$sqlStmt="SELECT * FROM `gotChars` WHERE `charTV` = 1 ORDER BY charID ASC";
$charResults=getData($sqlStmt);

foreach($charResults as $char){
	$sqlStmt="SELECT * FROM `gotAppearances` WHERE `appChar` = ".$char['charID']." ORDER BY appEpisode ASC";
	$appResults=getData($sqlStmt);

	for ($i=0; $i<count($appResults)-1; $i++ ){
		print $appResults[$i]['appEpisode'];
		print "-";
		print $appResults[$i+1]['appEpisode'];
		print ":";
		print $appResults[$i+1]['appPlace'];
		print "<br>";
		for($j=intval($appResults[$i]['appEpisode'])+1; $j<intval($appResults[$i+1]['appEpisode']); $j++){
			print $j;
			print ":";
			$sqlStmt="INSERT INTO `gotAppearances`(`appID`, `appEpisode`, `appChar`, `appTribe`, `appPlace`, `appSeen`) VALUES (null,".$j.",".$appResults[$i]['appChar'].",".$appResults[$i]['appTribe'].",".$appResults[$i]['appPlace'].",0)";
			$insert=insertData($sqlStmt);
		}
		print "<br>";
	}
}

?>
