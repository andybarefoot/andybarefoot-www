<?
include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';

//$sqlStmt="SELECT * FROM `gotChars` WHERE (charID IN (SELECT charKiller FROM `gotChars` WHERE charKiller != 0 AND charFirst !=0) AND charFirst != 0) || charKiller != 0 AND charFirst != 0 ORDER BY charLast ASC";

//$sqlStmt="SELECT * FROM `gotChars` WHERE (charID IN (SELECT charKiller FROM `gotChars` WHERE charKiller != 0 AND charTV =1) AND charFirst != 0) || charKiller != 0 AND charTV = 1 ORDER BY charDeath ASC";
//$sqlStmt="SELECT * FROM `gotChars` WHERE (charID IN (SELECT charKiller FROM `gotChars` WHERE charKiller = 792 AND charTV =1) AND charFirst != 0) || charKiller = 792 AND charTV = 1 ORDER BY charDeath ASC";
//$sqlStmt="SELECT * FROM `gotChars` WHERE (charID IN (SELECT charKiller FROM `gotChars` WHERE charKiller in (30,106,107,143,144,199,214,299,324,325,329,332,340,362,371,390,449,451,461,478,534,577,585,623,662,693,696,699,738,752,792,816,843,870,898,15,16,364,678,745,313,719,5,15,16,34,46,49,50,52,53,69,88,112,118,127,128,167,179,192,207,208,216,219,224,242,256,257,260,261,277,278,288,297,316,328,343,355,357,364,368,369,373,413,416,421,422,433,441,448,453,454,463,469,473,481,485,486,491,519,520,526,527,535,536,547,552,559,560,561,564,574,576,579,607,619,620,627,632,635,641,648,651,663,666,669,677,683,713,723,729,756,758,767,774,826,833,835,836,840,849,865,868,869,883,901,913,915,917,934,938,948,949,961,313,678,719,745,179,357,934,750,980,978)) AND charFirst != 0) || charKiller IN (30,106,107,143,144,199,214,299,324,325,329,332,340,362,371,390,449,451,461,478,534,577,585,623,662,693,696,699,738,752,792,816,843,870,898,15,16,364,678,745,313,719,5,15,16,34,46,49,50,52,53,69,88,112,118,127,128,167,179,192,207,208,216,219,224,242,256,257,260,261,277,278,288,297,316,328,343,355,357,364,368,369,373,413,416,421,422,433,441,448,453,454,463,469,473,481,485,486,491,519,520,526,527,535,536,547,552,559,560,561,564,574,576,579,607,619,620,627,632,635,641,648,651,663,666,669,677,683,713,723,729,756,758,767,774,826,833,835,836,840,849,865,868,869,883,901,913,915,917,934,938,948,949,961,313,678,719,745,179,357,934,750,980,978) AND charTV = 1 ORDER BY charKiller ASC, charDeath DESC, charID ASC";





//$sqlStmt="SELECT * FROM `gotChars` WHERE (charID IN (SELECT charKiller FROM `gotChars` WHERE charDead = 1 AND charTV =1 AND charKiller != 0)) || (charDead =1 AND charTV = 1) ORDER BY charLast ASC";
$sqlStmt="SELECT * FROM `gotEpisodes` RIGHT JOIN `gotChars` ON `charDeathTime` = `episodeID` WHERE (charID IN (SELECT charKiller FROM `gotChars` WHERE charDead = 1 AND charTV =1 AND charKiller != 0)) || (charDead =1 AND charTV = 1) ORDER BY charName ASC";
$charResults=getData($sqlStmt);

$sqlStmt="SELECT `charID`,`charName`,`charURL`,`charThumb`,`charDead`,`charDeathDesc`,`episodeName`,`episodeURL`,`episodeSeason`,`episodeNumber` FROM `gotEpisodes` RIGHT JOIN `gotChars` ON `charDeath` = `episodeID` WHERE (charID IN (SELECT charKiller FROM `gotChars` WHERE charDead = 1 AND charTV =1 AND charKiller != 0)) || (charDead =1 AND charTV = 1) ORDER BY charLast ASC";

//$sqlStmt="SELECT `charID`,`charName`,`charURL`,`charThumb`,`charDeathDesc`,`episodeName`,`episodeSeason`,`episodeNumber` FROM `gotEpisodes` RIGHT JOIN `gotChars` ON `charDeath` = `episodeID` WHERE (charID IN (SELECT charKiller FROM `gotChars` WHERE charKiller in (30,106,107,143,144,199,214,299,324,325,329,332,340,362,371,390,449,451,461,478,534,577,585,623,662,693,696,699,738,752,792,816,843,870,898,15,16,364,678,745,313,719,5,15,16,34,46,49,50,52,53,69,88,112,118,127,128,167,179,192,207,208,216,219,224,242,256,257,260,261,277,278,288,297,316,328,343,355,357,364,368,369,373,413,416,421,422,433,441,448,453,454,463,469,473,481,485,486,491,519,520,526,527,535,536,547,552,559,560,561,564,574,576,579,607,619,620,627,632,635,641,648,651,663,666,669,677,683,713,723,729,756,758,767,774,826,833,835,836,840,849,865,868,869,883,901,913,915,917,934,938,948,949,961,313,678,719,745,179,357,934,750,980,978)) AND charFirst != 0) || charKiller IN (30,106,107,143,144,199,214,299,324,325,329,332,340,362,371,390,449,451,461,478,534,577,585,623,662,693,696,699,738,752,792,816,843,870,898,15,16,364,678,745,313,719,5,15,16,34,46,49,50,52,53,69,88,112,118,127,128,167,179,192,207,208,216,219,224,242,256,257,260,261,277,278,288,297,316,328,343,355,357,364,368,369,373,413,416,421,422,433,441,448,453,454,463,469,473,481,485,486,491,519,520,526,527,535,536,547,552,559,560,561,564,574,576,579,607,619,620,627,632,635,641,648,651,663,666,669,677,683,713,723,729,756,758,767,774,826,833,835,836,840,849,865,868,869,883,901,913,915,917,934,938,948,949,961,313,678,719,745,179,357,934,750,980,978) AND charTV = 1 ORDER BY charKiller ASC, charDeath DESC, charID ASC";
$charDetailResults=getData($sqlStmt);

$contentStr = "id,value,deathSeason,deathEpisode,dead,appearances".PHP_EOL." , , , , ,".PHP_EOL;
foreach($charResults as $char){
	print $char['charName'];
	$names = array($char['charName']);
	$killer = $char['charKiller'];
	while($killer!=0){
		print " i ";
		$killerData = findKiller($killer);
		array_unshift($names,$killerData[1]);
		$killer = $killerData[3];
	}
	if($char['episodeSeason']){
		$epSeason = $char['episodeSeason'];
	}else{
		$epSeason = 0;
	}
	if($char['episodeNumber']){
		$epNumber = $char['episodeNumber'];
	}else{
		$epNumber = 0;
	}
	$contentStr .= " .".implode(".", $names).",".$char['charID'].",".$epSeason.",".$epNumber.",".$char['charDead'].",".$char['charApp'].PHP_EOL;
}

function findKiller($killerID){
	global $charResults;
	$keyKiller = array_search($killerID, array_column($charResults, 'charID'));
	$killerName = $charResults[$keyKiller]['charName'];
	$killerURL = $charResults[$keyKiller]['charURL'];
	$killerKiller = $charResults[$keyKiller]['charKiller'];
	return array($killerID, $killerName, $killerURL, $killerKiller);
}

file_put_contents ('deaths.csv', $contentStr);
file_put_contents ('characters.json', json_encode($charDetailResults));

print nl2br($contentStr);



?>