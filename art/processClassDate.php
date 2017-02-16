<?php

// "ClassificationMin","Object Begin Date","Object End Date","countTotal"

$allClasses = array();
$thisClass = array();
$thisYears = array();
$currentClass = "none";
$row = 1;
if (($handle = fopen("classDateDump.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        if($data[0]!=$currentClass){
	       	if($currentClass!="none"){
	       		$thisClass['years']=array();
	       		array_push($thisClass['years'],$thisYears);
        		array_push($allClasses, $thisClass);
        	}
	    	unset($thisClass);
	    	unset($thisYears);
       		$thisClass["name"]=$data[0];
        }
        $currentClass=$data[0];
        $startYear = intval($data[1]);
        $endYear = intval($data[2]);
        if($endYear>2017)$endYear=2017;
        $span = 1+($endYear-$startYear);
        $count = intval($data[3]);
        if(($span<1000)||(($count/$span)>0.001)){
	        for($i=$startYear; $i<=$endYear; $i++){
	        	$j=$i;
/*
	        	if($i<-5000){
	        		$j = -5000;
	        	}else if($i<-4000){
	        		$j = -4000;
	        	}else if($i<-3000){
	        		$j = -3000;
	        	}else if($i<-2000){
	        		$j = -2000;
	        	}else if($i<-1000){
	        		$j = -1000;
	        	}
*/
	        	$thisYears[$j]+=$count/$span;
	        }
        }

	//        $num = count($data);
	//        echo "<p> $num fields in line $row: <br /></p>\n";
	//        $row++;
	//        for ($c=0; $c < $num; $c++) {
	//            echo $data[$c] . "<br />\n";
	//        }
    }
    fclose($handle);
}

// lets try and minimise the file size 3.5MB

$deletion =[];
$rounding =[];

foreach ($allClasses as $class) {
	$name = $class["name"];
	$years = $class["years"][0];
	foreach ($years as $year => $count) {
        if($count < 0.007){
            // add to deletion array
            array_push($deletion, [$name,$year]);
        } else {
            // add to rounding array
            array_push($rounding, [$name,$year]);
        }
    	$years[$year]=1;
	}
}

for($i=0;$i<count($deletion);$i++){
	for($j=0;$j<count($allClasses);$j++){
		if ($allClasses[$j]['name'] == $deletion[$i][0]) {
	    	unset($allClasses[$j]['years'][0][$deletion[$i][1]]);
		}
	}
}

for($i=0;$i<count($rounding);$i++){
	for($j=0;$j<count($allClasses);$j++){
		if ($allClasses[$j]['name'] == $rounding[$i][0]) {
//	    	print_r($allClasses[$j]['years'][0][$rounding[$i][1]]);
	    	$allClasses[$j]['years'][0][$rounding[$i][1]]=round($allClasses[$j]['years'][0][$rounding[$i][1]],4);
		}
	}
}
?>
<hr>
<?php
print_r($allClasses);

// minimise over



$dataArray = ["classifications"=>$allClasses];
$dataJSON = json_encode($dataArray);

$file = fopen("classDate.json", "w") or die("Unable to open file!");
fwrite($file, $dataJSON);
fclose($file);

//print_r($dataJSON);

?>