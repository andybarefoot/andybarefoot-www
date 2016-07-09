<?

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';

$sqlStmt="SELECT * FROM `gotChars` WHERE charDead = 1 AND charKiller = 0";
$charResults=getData($sqlStmt);
foreach($charResults as $char){
	$id = $char['charID'];
	$killer = $char['charKiller'];
	$name = htmlspecialchars($char['charName'], ENT_QUOTES);
	$url = $char['charURL'];
	print '<a href="'.$url.'" target="_blank">'.$name.'</a><br/>';
}

$sqlStmt="SELECT * FROM `gotEpisodes` ORDER BY episodeID ASC";
$charResults=getData($sqlStmt);
foreach($charResults as $char){
	$season = $char['episodeSeason'];
	$number = $char['episodeNumber'];
	$id = $char['episodeID'];
	$name = $char['episodeName'];
	$url = $char['episodeURL'];
	print '<a href="'.$url.'" target="_blank">'.$season.' '.$number.' '.$name.'</a><br/>';
}


?>
