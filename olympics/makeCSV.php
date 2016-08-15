<?

include_once '../../includes/db-olympics.php';
include_once '../../includes/dbactions.php';


function strCheck($str){
	if(strpos($str,"Ivoire")!==false){
		return htmlentities("Cote d'Ivoire");
	}else{
		return $str;
	}
}

$sqlStmt="SELECT * FROM `TABLE 1` ORDER BY `Competitors` DESC, `Country` ASC ";
$total=getData($sqlStmt);

$totalStr="name,value,continent".PHP_EOL;
for($i=0; $i<count($total); $i++){
	$totalStr.=strCheck($total[$i]['Country']).",".$total[$i]['Competitors'].",".$total[$i]['Continent'].PHP_EOL;
}

file_put_contents ('csv/compsTotal.csv', $totalStr);
print nl2br($totalStr);
print ("<br><br><br>");

$sqlStmt="SELECT * FROM `TABLE 1` ORDER BY `Total` DESC, `Gold` DESC, `Silver` DESC, `Bronze` DESC, `Country` ASC ";
$total=getData($sqlStmt);

$totalStr="name,value,continent".PHP_EOL;
for($i=0; $i<count($total); $i++){
	$totalStr.=strCheck($total[$i]['Country']).",".$total[$i]['Total'].",".$total[$i]['Continent'].PHP_EOL;
}

file_put_contents ('csv/medalsTotal.csv', $totalStr);

$sqlStmt="SELECT * FROM `TABLE 1` ORDER BY `Gold` DESC, `Silver` DESC, `Bronze` DESC, `Country` ASC ";
$total=getData($sqlStmt);

$totalStr="name,value,continent".PHP_EOL;
for($i=0; $i<count($total); $i++){
	$totalStr.=strCheck($total[$i]['Country']).",".$total[$i]['Gold'].",".$total[$i]['Continent'].PHP_EOL;
}

file_put_contents ('csv/golds.csv', $totalStr);

$sqlStmt="SELECT `Country`, `Continent`, ROUND (1000000*(`Competitors`/`Population`),2) AS `Sporty` FROM `TABLE 1` ORDER BY `Sporty` DESC, `Country` ASC ";
$total=getData($sqlStmt);

$totalStr="name,value,continent".PHP_EOL;
for($i=0; $i<count($total); $i++){
	$totalStr.=strCheck($total[$i]['Country']).",".$total[$i]['Sporty'].",".$total[$i]['Continent'].PHP_EOL;
}

file_put_contents ('csv/sporty.csv', $totalStr);
print nl2br($totalStr);
print ("<br><br><br>");


$sqlStmt="SELECT `Country`, `Continent`, ROUND (100*(`Total`/`Competitors`),2) AS `efficiency` FROM `TABLE 1` ORDER BY `efficiency` DESC, `Country` ASC ";
$total=getData($sqlStmt);

$totalStr="name,value,continent".PHP_EOL;
for($i=0; $i<count($total); $i++){
	$totalStr.=strCheck($total[$i]['Country']).",".$total[$i]['efficiency'].",".$total[$i]['Continent'].PHP_EOL;
}

file_put_contents ('csv/efficiency.csv', $totalStr);

$sqlStmt="SELECT `Country`, `Continent`, ROUND (100*(`Gold`/`Competitors`),2) AS `efficiency` FROM `TABLE 1` ORDER BY `efficiency` DESC, `Country` ASC ";
$total=getData($sqlStmt);

$totalStr="name,value,continent".PHP_EOL;
for($i=0; $i<count($total); $i++){
	$totalStr.=strCheck($total[$i]['Country']).",".$total[$i]['efficiency'].",".$total[$i]['Continent'].PHP_EOL;
}

file_put_contents ('csv/goldEfficiency.csv', $totalStr);

print nl2br($totalStr);
print ("<br><br><br>");




$sqlStmt="SELECT `Country`, `Continent`, ROUND (1000000*(`Total`/`Population`),2) AS `talented` FROM `TABLE 1` ORDER BY `talented` DESC, `Country` ASC ";
$total=getData($sqlStmt);

$totalStr="name,value,continent".PHP_EOL;
for($i=0; $i<count($total); $i++){
	$totalStr.=strCheck($total[$i]['Country']).",".$total[$i]['talented'].",".$total[$i]['Continent'].PHP_EOL;
}

file_put_contents ('csv/talented.csv', $totalStr);


$sqlStmt="SELECT `Country`, `Continent`, ROUND (1000000*(`Gold`/`Population`),2) AS `talented` FROM `TABLE 1` ORDER BY `talented` DESC, `Country` ASC ";
$total=getData($sqlStmt);

$totalStr="name,value,continent".PHP_EOL;
for($i=0; $i<count($total); $i++){
	$totalStr.=strCheck($total[$i]['Country']).",".$total[$i]['talented'].",".$total[$i]['Continent'].PHP_EOL;
}

file_put_contents ('csv/goldTalent.csv', $totalStr);


print nl2br($totalStr);
print ("<br><br><br>");




?>