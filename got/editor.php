<?php

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';

foreach ($_GET as $key => $value) {
	$details = explode("-", $key);
	$char = $details[0];
	$episode = $details[1];
	$sqlStmt="UPDATE `gotAppearances` SET `appPlace`=$value WHERE `appEpisode`=$episode AND `appChar`=$char";
	$updatedRows = updateData($sqlStmt);
}


?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
    	<style type="text/css">
    		body {
    			font-size: 12px;
    		}
    		h2 {
    			margin: 0;
    		}
			.episodeSpan {
				color: red;
				display: inline-block;
				width: 220px;
			}
    	</style>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    	<script>
			$(document).ready(function(){
	    		$('select').on('change', function() {
	    			console.log(this.value);
	    			console.log(this);
	    			console.log($(this).nextAll('select'));
	    			$(this).nextAll('select').val(this.value);
				})
			});
    	</script>
   </head>
	<body>
<?php

$sqlStmt="SELECT * FROM `gotPlaces` ORDER BY placeRegion ASC, placeName ASC";
$placeResults=getData($sqlStmt);

$sqlStmt="SELECT * FROM `gotAppearances` LEFT JOIN `gotChars` ON `charID` = `appChar` LEFT JOIN  `gotEpisodes` ON `appEpisode` = `episodeID` LEFT JOIN  `gotPlaces` ON `appPlace` = `placeID` ORDER BY charInitTribe ASC, appChar ASC, appEpisode ASC";
$appResults=getData($sqlStmt);

$lastChar=0;
foreach($appResults as $app){
	$thisChar = $app['appChar'];
	if($thisChar!=$lastChar){
		if($lastChar!=0){
			print "<input type=\"submit\" value=\"Submit\">";
			print "</form>";
		}
		print "<hr>";
		print "<a name=\"n".$thisChar."\"></a><form action=\"editor.php#n".$thisChar."\" method=\"GET\" id=\"form".$thisChar."\">";
		print "<h2>".$thisChar."<a href=\"".$app['charURL']."\" target=\"_blank\">".$app['charName']."</a></h2><br>";
		$lastChar=$thisChar;
	}
	print "<span class=\"episodeSpan\">".$app['appEpisode'].": <a href=\"".$app['episodeURL']."\" target=\"_blank\">".$app['episodeName']."</a></span>";
	print "<select name=\"".$thisChar."-".$app['appEpisode']."\">";
	foreach($placeResults as $place){
		if($place['placeID']==$app['appPlace']){
			$thisPlace = " selected";
		}else{
			$thisPlace = "";
		}
		print "<option  value=\"".$place['placeID']."\"".$thisPlace.">".$place['placeRegion']." | ".$place['placeName']."</option>";
	}
	print "</select>";
	print "<br>";
}
print "<input type=\"submit\" value=\"Submit\">";
print "</form>";


?>
	</body>
</html>
