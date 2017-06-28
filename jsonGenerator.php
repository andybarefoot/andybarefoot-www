<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

$jsonItems = [];

$colorArray = ["#DDD8B8", "#B3CBB9", "#84A9C0", "#6A66A3", "#995D81", "#8E9B90"];
$letterArray = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];

for($i=0;$i<500;$i++){
	$thisItem =[];
	$randCol = rand(0,5);
	$thisItem['colourID'] = $randCol+1;
	$thisItem['colourHex'] = $colorArray[$randCol];
	$randSize = rand(1,100);
	if($randSize<=30){
		$thisItem['size'] = 1;
	}else if($randSize<=50){
		$thisItem['size'] = 2;
	}else if($randSize<=70){
		$thisItem['size'] = 3;
	}else if($randSize<=80){
		$thisItem['size'] = 4;
	}else if($randSize<=90){
		$thisItem['size'] = 5;
	}else if($randSize<=95){
		$thisItem['size'] = 6;
	}else {
		$thisItem['size'] = 7;
	}
	$randCat = rand(1,100);
	if($randCat<=15){
		$thisItem['category'] = "A";
	}else if($randCat<=20){
		$thisItem['category'] = "B";
	}else if($randCat<=30){
		$thisItem['category'] = "C";
	}else if($randCat<=38){
		$thisItem['category'] = "D";
	}else if($randCat<=45){
		$thisItem['category'] = "E";
	}else if($randCat<=55){
		$thisItem['category'] = "F";
	}else if($randCat<=58){
		$thisItem['category'] = "G";
	}else if($randCat<=76){
		$thisItem['category'] = "H";
	}else if($randCat<=82){
		$thisItem['category'] = "I";
	}else if($randCat<=88){
		$thisItem['category'] = "J";
	}else if($randCat<=96){
		$thisItem['category'] = "K";
	}else {
		$thisItem['category'] = "L";
	}
	$thisItem['string'] = $letterArray[rand(0,25)].$letterArray[rand(0,25)].$letterArray[rand(0,25)];
	array_push($jsonItems,$thisItem);
}

// print("<pre>".print_r($charResults,true)."</pre>");

//$allData = ["characters"=>$charResults];
// print("<pre>".print_r($allData,true)."</pre>");

$jsonContent['griditems'] = $jsonItems;
$json = json_encode($jsonContent);
print_r($json);

?>