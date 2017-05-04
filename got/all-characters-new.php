<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';


$allEpisodes = [
	1 => "Winter is Coming",
	2 => "The Kingsroad",
	3 => "Lord Snow",
	4 => "Cripples, Bastards and Broken Things",
	5 => "The Wolf and the Lion",
	6 => "A Golden Crown",
	7 => "You Win or You Die",
	8 => "The Pointy End",
	9 => "Baelor",
	10 => "Fire and Blood",
	11 => "The North Remembers",
	12 => "The Night Lands",
	13 => "What is Dead May Never Die",
	14 => "Garden of Bones",
	15 => "The Ghost of Harrenhal",
	16 => "The Old Gods and the New",
	17 => "A Man Without Honor",
	18 => "The Prince of Winterfell",
	19 => "Blackwater",
	20 => "Valar Morghulis",
	21 => "Valar Dohaeris",
	22 => "Dark Wings, Dark Words",
	23 => "Walk of Punishment",
	24 => "And Now His Watch is Ended",
	25 => "Kissed by Fire",
	26 => "The Climb",
	27 => "The Bear and the Maiden Fair",
	28 => "Second Sons",
	29 => "The Rains of Castamere",
	30 => "Mhysa",
	31 => "Two Swords",
	32 => "The Lion and the Rose",
	33 => "Breaker of Chains",
	34 => "Oathkeeper",
	35 => "First of His Name",
	36 => "The Laws of Gods and Men",
	37 => "Mockingbird",
	38 => "The Mountain and the Viper",
	39 => "The Watchers on the Wall",
	40 => "The Children",
	41 => "The Wars to Come",
	42 => "The House of Black and White",
	43 => "High Sparrow",
	44 => "Sons of the Harpy",
	45 => "Kill the Boy",
	46 => "Unbowed, Unbent, Unbroken",
	47 => "The Gift",
	48 => "Hardhome",
	49 => "The Dance of Dragons",
	50 => "Mother’s Mercy",
	51 => "The Red Woman",
	52 => "Home",
	53 => "Oathbreaker",
	54 => "Book of the Stranger",
	55 => "The Door",
	56 => "Blood of My Blood",
	57 => "The Broken Man",
	58 => "No One",
	59 => "Battle of the Bastards",
	60 => "The Winds of Winter"
];

// Function for making a GET request using cURL
function curlGet($url) {
	$ch = curl_init();	// Initialising cURL session
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);	// Returning transfer as a string
	curl_setopt($ch, CURLOPT_URL, $url);	// Setting URL
	$results = curl_exec($ch);	// Executing cURL session
	return $results;	// Return the results
}

function returnXPathObject($item) {
	$xmlPageDom = new DomDocument();	// Instantiating a new DomDocument object
	@$xmlPageDom->loadHTML($item);	// Loading the HTML from downloaded page
	$xmlPageXPath = new DOMXPath($xmlPageDom);	// Instantiating new XPath DOM object
	return $xmlPageXPath;	// Returning XPath object
}

function getAllChars(){
	$allCharacters = curlGet('http://gameofthrones.wikia.com/api/v1/Articles/List/?limit=10&category=Characters');
	$charData = json_decode($allCharacters, true);
	$charItems = $charData['items'];
	foreach ($charItems as $char) {
		print ($char['id']);
		print " : ";
		print ($char['title']);
		print " : ";
		print ($char['url']);
		$thisWikiID = $char['id'];
		$thisTitle = mysql_real_escape_string($char['title']);
		$thisURL = "http://gameofthrones.wikia.com".$char['url'];
		$sqlStmt="SELECT * FROM `gotChars` WHERE `gotChars`.`charWikiID` ='$thisWikiID';";
		$charResults=getData($sqlStmt);
		if(count($charResults)>=1){
	// edit existing char
			$message.="old stockist: ";
			$thisID=$charResults[0]['charID'];
			$sqlStmt="UPDATE  `gotChars` SET  `charWikiID` =  '$thisWikiID', `charName` =  '$thisTitle', `charURL` =  '$thisURL' WHERE  `gotChars`.`charID` ='$thisID';";
			updateData($sqlStmt);
		}else{
	// create new char
			$sqlStmt="INSERT INTO `gotChars` (`charID`, `charWikiID`, `charName`, `charURL`) VALUES (NULL, '$thisWikiID', '$thisTitle', '$thisURL');";
			$thisProduct=insertDataReturnID($sqlStmt);
		}
		print "</br>";
	}
}
function getAllInfo($start,$number){
	$sqlStmt="SELECT * FROM `gotChars` ORDER BY `charName` ASC LIMIT ".$start.",".$number.";";
	$charResults=getData($sqlStmt);
	print "<table border='1'>\n";
	print "<tr>";	
	print "<td>URL</td>";
	print "<td>Status</td>";
	print "<td>First Seen</td>";
	print "<td>ID</td>";
	print "<td>Last Seen</td>";
	print "<td>ID</td>";
	print "<td>Death Episode</td>";
	print "<td>ID</td>";
	print "</tr>";	

	foreach($charResults as $char){
		print "<tr>";	
		print "<td>".$char['charURL']."</td>";
		$charID =  $char['charID'];
		$charPageSrc =  curlGet($char['charURL']);
		$thisPageXPath = returnXPathObject($charPageSrc);	// Instantiating new XPath DOM object
		// HANDLE STATUS
		$thisStatus = $thisPageXPath->query("//h3[.='Status']/following-sibling::div[1]/a");	// Querying for href attributes of pagination
		if ($thisStatus->length > 0) {
			for ($i = 0; $i < $thisStatus->length; $i++) {
				$status=$thisStatus->item($i)->nodeValue;
				print "<td>".$status."</td>";
				if($status=="Alive"){
					$sqlStmt="UPDATE  `gotChars` SET  `charDead` =  false WHERE `gotChars`.`charID` ='$charID';";
//					updateData($sqlStmt);
				}else if($status=="Deceased"){
					$sqlStmt="UPDATE  `gotChars` SET  `charDead` =  true WHERE `gotChars`.`charID` ='$charID';";
//					updateData($sqlStmt);
				}
			}
		}else{
			print "<td> </td>";
		}
		// HANDLE FIRST SEEN
		$firstSeen = false;
		$thisFirstSeen = $thisPageXPath->query("//h3[.='First seen']/following-sibling::div[1]/a/@href");	// Querying for href attributes of pagination
		if ($thisFirstSeen->length > 0) {
			for ($i = 0; $i < $thisFirstSeen->length; $i++) {
				$firstUrl=$thisFirstSeen->item($i)->nodeValue;
				print "<td>".$firstUrl."</td>";
				$fullURL = "http://gameofthrones.wikia.com".$firstUrl;
				$sqlStmt="SELECT * FROM `gotEpisodes` WHERE `gotEpisodes`.`episodeURL` ='$fullURL';";
				$firstResults=getData($sqlStmt);
				if(count($firstResults)>=1){
					$firstID=$firstResults[0]['episodeID'];
					print "<td>".$firstID."</td>";
				}
			}
		}else{
			$thisFirstSeen = $thisPageXPath->query("//h3[.='Appeared in']/following-sibling::div[1]/a/@href");	// Querying for href attributes of pagination
			if ($thisFirstSeen->length > 0) {
				for ($i = 0; $i < $thisFirstSeen->length; $i++) {
					$firstUrl=$thisFirstSeen->item($i)->nodeValue;
					print "<td>".$firstUrl."</td>";
					$fullURL = "http://gameofthrones.wikia.com".$firstUrl;
					$sqlStmt="SELECT * FROM `gotEpisodes` WHERE `gotEpisodes`.`episodeURL` ='$fullURL';";
					$firstResults=getData($sqlStmt);
					if(count($firstResults)>=1){
						$firstID=$firstResults[0]['episodeID'];
						print "<td>".$firstID."</td>";
					}
				}
			}else{
				$firstID = 0;
				print "<td> </td>";
				print "<td> </td>";
			}
		}
		// HANDLE LAST SEEN
		$lastSeen = false;
		$thisLastSeen = $thisPageXPath->query("//h3[.='Last seen']/following-sibling::div[1]/a/@href");	// Querying for href attributes of pagination
		if ($thisLastSeen->length > 0) {
			for ($i = 0; $i < $thisLastSeen->length; $i++) {
				$lastUrl=$thisLastSeen->item($i)->nodeValue;
				print "<td>".$lastUrl."</td>";
				$fullURL = "http://gameofthrones.wikia.com".$lastUrl;
				$sqlStmt="SELECT * FROM `gotEpisodes` WHERE `gotEpisodes`.`episodeURL` ='$fullURL';";
				$lastResults=getData($sqlStmt);
				if(count($lastResults)>=1){
					$lastSeen = true;
					$lastID=$lastResults[0]['episodeID'];
				}
			}
		}
		if(!$lastSeen){
			print "<td> NO LAST</td>";
			if($firstID==0){
				$lastID=0;
			}else{
				$lastID=60;
			}
		}
		print "<td>".$lastID."</td>";

		// HANDLE DEATH EPISODE
		$deathSeen = false;
		$thisDeathSeen = $thisPageXPath->query("//h3[.='Death shown in episode']/following-sibling::div[1]/a/@href");	// Querying for href attributes of pagination
		if ($thisDeathSeen->length > 0) {
			for ($i = 0; $i < $thisDeathSeen->length; $i++) {
				$deathUrl=$thisDeathSeen->item($i)->nodeValue;
				print "<td>".$deathUrl."</td>";
				$fullURL = "http://gameofthrones.wikia.com".$deathUrl;
				$sqlStmt="SELECT * FROM `gotEpisodes` WHERE `gotEpisodes`.`episodeURL` ='$fullURL';";
				$deathResults=getData($sqlStmt);
				if(count($deathResults)>=1){
					$deathID=$deathResults[0]['episodeID'];
					print "<td>".$deathID."</td>";
				}
			}
		}else{
			$deathID=0;
			print "<td> </td>";
			print "<td> </td>";
		}

		// HANDLE DEATH DESC
		$deathDesc = "";
		$thisDeathDesc = $thisPageXPath->query("//h3[.='Death']/following-sibling::div[1]");	// Querying for href attributes of pagination
		if ($thisDeathDesc->length > 0) {
			$deathDesc=mysql_real_escape_string($thisDeathDesc->item(0)->nodeValue);
			print "<td>".$deathDesc."</td>";
		}
		// HANDLE IMAGE
		$charImage = "";
		$thisImage = $thisPageXPath->query("//aside/figure/a/img/@src");	// Querying for href attributes of pagination
		if ($thisImage->length > 0) {
			$charImage=$thisImage->item(0)->nodeValue;
			print "<td>".$charImage."</td>";
		}

		$sqlStmt="UPDATE  `gotChars` SET  `charDeathDesc` =  '$deathDesc', `charThumb` =  '$charImage' WHERE `gotChars`.`charID` ='$charID';";
		updateData($sqlStmt);


		$thisPageDeathURL = $thisPageXPath->query("//h3[.='Death']/following-sibling::div[1]/a/@href");	// Querying for href attributes of pagination
		// If results exist
		$numberOfKillers = 0;
		if ($thisPageDeathURL->length > 0) {
			// For each results page URL
			for ($i = 0; $i < $thisPageDeathURL->length; $i++) {
				$iUrl=$thisPageDeathURL->item($i)->nodeValue;
				$fullURL = "http://gameofthrones.wikia.com".$iUrl;
				$sqlStmt="SELECT * FROM `gotChars` WHERE `gotChars`.`charURL` ='$fullURL';";
				$killerResults=getData($sqlStmt);
				if(count($killerResults)>=1){
					$killerID=$killerResults[0]['charID'];
					$sqlStmt="UPDATE  `gotChars` SET  `charKiller` =  '$killerID' WHERE `gotChars`.`charID` ='$charID';";
//					updateData($sqlStmt);
				}

			}
		}
		print "</tr>";
	}
	print "</table>\n";
}

function getAllDeceased($page){
	if($page==1)$url="http://gameofthrones.wikia.com/wiki/Category:Status:_Dead?display=page&sort=mostvisited";
	if($page==2)$url="http://gameofthrones.wikia.com/wiki/Category:Status:_Dead?display=page&sort=mostvisited&pagefrom=Karstark+lookout#mw-pages";
	if($page==3)$url="http://gameofthrones.wikia.com/wiki/Category:Status:_Dead?display=page&sort=mostvisited&pagefrom=Targaryen%2C+Rhaella%0ARhaella+Targaryen#mw-pages";
	$listPageSrc =  curlGet($url);
	$thisPageXPath = returnXPathObject($listPageSrc);	// Instantiating new XPath DOM object
	$thisPageDeaths = $thisPageXPath->query("//td/ul/li/a/@href");	// Querying for href attributes of pagination
	// If results exist
	if ($thisPageDeaths->length > 0) {
		// For each results page URL
		for ($i = 0; $i < $thisPageDeaths->length; $i++) {
			$iUrl=$thisPageDeaths->item($i)->nodeValue;
			print $iUrl;
			print "<br>";
			$fullURL = "http://gameofthrones.wikia.com".$iUrl;
			$sqlStmt="UPDATE  `gotChars` SET  `charDead` =  true WHERE `gotChars`.`charURL` ='$fullURL';";
			updateData($sqlStmt);
		}
	}

}

function getAllEpisodes(){
	$allCharacters = curlGet('http://gameofthrones.wikia.com/api/v1/Articles/List/?limit=70&category=Episodes');
	$charData = json_decode($allCharacters, true);
	$charItems = $charData['items'];
	foreach ($charItems as $char) {
		print ($char['id']);
		print " : ";
		print ($char['title']);
		print " : ";
		print ($char['url']);
		$thisWikiID = $char['id'];
		$thisShortTitle = substr($char['title'], 0, 6);
		$thisTitle = mysql_real_escape_string($char['title']);
		$thisURL = "http://gameofthrones.wikia.com".$char['url'];
		$sqlStmt="SELECT * FROM `gotEpisodes` WHERE SUBSTRING(`gotEpisodes`.`episodeName`,1,6) ='$thisShortTitle';";
		print $sqlStmt;
		$charResults=getData($sqlStmt);
		if(count($charResults)>=1){
	// edit existing char
			$thisID=$charResults[0]['episodeID'];
			$sqlStmt="UPDATE  `gotEpisodes` SET  `episodeWikiID` =  '$thisWikiID', `episodeURL` =  '$thisURL' WHERE  `gotEpisodes`.`episodeID` ='$thisID';";
			updateData($sqlStmt);
		}
		print "</br>";
	}
}


function editErrors(){
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '32' WHERE `gotChars`.`charID` = 585;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '0' WHERE `gotChars`.`charID` = 174;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '7' WHERE `gotChars`.`charID` = 478;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '1' WHERE `gotChars`.`charID` = 449;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '1' WHERE `gotChars`.`charID` = 324;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '44' WHERE `gotChars`.`charID` = 696;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charKiller` =  '792' WHERE `gotChars`.`charID` = 192;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charKiller` =  '792' WHERE `gotChars`.`charID` = 948;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charKiller` =  '192' WHERE `gotChars`.`charID` = 379;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charKiller` =  '870' WHERE `gotChars`.`charID` = 34;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charKiller` =  '449' WHERE `gotChars`.`charID` = 454;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charKiller` =  '0' WHERE `gotChars`.`charID` = 747;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '0' WHERE `gotChars`.`charID` = 247;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '0' WHERE `gotChars`.`charID` = 653;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '0' WHERE `gotChars`.`charID` = 76;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '0' WHERE `gotChars`.`charID` = 252;";
	updateData($sqlStmt);
	$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  '0' WHERE `gotChars`.`charID` = 181;";
	updateData($sqlStmt);
}


function getAppearances($start,$number){
	$sqlStmt="SELECT * FROM `gotChars` WHERE `charTV` = 1 ORDER BY `charName` ASC LIMIT ".$start.",".$number.";";
//	$sqlStmt="SELECT * FROM `gotChars` WHERE `charName` = 'Meera Reed';";
	$charResults=getData($sqlStmt);
	print "<table border='1'>\n";
	print "<tr>";	
	print "<td>Name</td>";
	print "<td>No. of Appearance</td>";
	print "</tr>";	

	foreach($charResults as $char){
		global $allEpisodes;
		$charID = $char['charID'];
		print "<tr>";	
		print "<td><a href='".$char['charURL']."' target='_blank'>".$charID.":".$char['charName']."</a></td>";
		$charPageSrc =  curlGet($char['charURL']);
		$thisPageXPath = returnXPathObject($charPageSrc);	// Instantiating new XPath DOM object
//		$thisStatus = $thisPageXPath->query("//table[.='appearances']/tbody/tr/td/b/a");	// Querying for href attributes of pagination
		$thisAppearances = $thisPageXPath->query("//table[@class='appearances']/tr/td/b/a");	// Querying for href attributes of pagination
		$thisSeries = $thisPageXPath->query("//table[@class='appearances']/tr");	// Querying for href attributes of pagination
		$realApp = $thisAppearances->length - ($thisSeries->length/3);
		print "<td>".$thisSeries->length.":".$thisAppearances->length.":".$realApp."<br>";
		for ($i = 0; $i < $thisAppearances->length; $i++) {
			$episode=$thisAppearances->item($i)->nodeValue;
//			print $episode."<br>";
			$epNo = array_search(trim($episode), $allEpisodes);
			if($epNo){
				print $epNo.":".$episode."</br>";
				$sqlStmt="INSERT IGNORE INTO `gotAppearances` (`appID`, `appEpisode`, `appChar`, `appTribe`) VALUES (NULL, '$epNo', '$charID', '0');";
				$thisApp=insertDataReturnID($sqlStmt);
			}
		}
		print "</td>";
		$sqlStmt="UPDATE  `gotChars` SET  `charApp` =  '$realApp' WHERE `gotChars`.`charID` ='$charID';";
//		updateData($sqlStmt);
		print "</tr>";
	}
	print "</table>\n";
}

function fixFirstLast(){
	$sqlStmt="SELECT * FROM `gotChars` WHERE `charTV` = 1 ORDER BY `charName` ASC;";
	$charResults=getData($sqlStmt);
	foreach($charResults as $char){
		$charID = $char['charID'];
		print $char['charName']."<br>";
		print "<hr>";
		$sqlStmt="SELECT * FROM `gotAppearances` WHERE `appChar` = ".$char['charID']." ORDER BY `appEpisode` ASC;";
		$appResults=getData($sqlStmt);
		foreach($appResults as $app){
				print $app['appEpisode']."<br>";
		}
		print "<hr>";
		if(count($appResults)>0){
			$first = $appResults[0]['appEpisode'];
			$last = $appResults[count($appResults)-1]['appEpisode'];
			$total = count($appResults);
		}else{
			$first = 0;
			$last = 0;
			$total = 0;
		}
		print "First: ".$first."<br>";
		print "Last: ".$last."<br>";
		print "<hr>";
		$sqlStmt="UPDATE  `gotChars` SET  `charFirst` =  $first, `charLast` =  $last, `charApp` = $total WHERE `charID` = $charID;";
		print $sqlStmt."<hr>";
		updateData($sqlStmt);
	}
}

function giveInitTribe(){
	$sqlStmt="SELECT * FROM `gotChars` WHERE `charTV` = 1 ORDER BY `charName` ASC;";
	$charResults=getData($sqlStmt);
	foreach($charResults as $char){
		$charID = $char['charID'];
		$sqlStmt="SELECT * FROM `gotAppearances` WHERE `appChar` = ".$charID." ORDER BY `appEpisode` ASC;";
		$appResults=getData($sqlStmt);
		if(count($appResults)>0){
			$tribe = $appResults[0]['appTribe'];
		}else{
			$tribe = 99;
		}
		$sqlStmt="UPDATE  `gotChars` SET  `charInitTribe` =  $tribe WHERE `charID` = $charID;";
		updateData($sqlStmt);
	}

}

giveInitTribe();

?>