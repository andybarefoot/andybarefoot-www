<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';


// set up an array we can query to get character details from the CharID
$sqlStmt="SELECT *, count(`appEpisode`) AS 'totalAppearances' FROM `gotChars`,`gotAppearances` WHERE `charID`=`appChar` AND `appSeen`=1
GROUP BY `charID` ORDER BY `charFirst` ASC";
$charResults=getData($sqlStmt);

foreach ($charResults as $charKey=>$char) {
	foreach ($char as $fieldKey=>$charField) {
	    if (is_numeric($fieldKey)) {
	    	unset($char[$fieldKey]);
	    }
	}
	$charResults[$charKey]=$char;
}

// print("<pre>".print_r($charResults,true)."</pre>");

$allData = ["characters"=>$charResults];
// print("<pre>".print_r($allData,true)."</pre>");

$json = json_encode($allData);
print_r($json);

?>