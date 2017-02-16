<?php 
	require_once '../includes/db-metnyc.php';
	require_once '../includes/dbactions.php';

	$table="fullCatalogue";
	$file="MetObjectsDownload.csv";
//	$file="MetObjectsNoHeader.csv";
//	$file="MetObjects200sample.csv";
	echo "File: ".$file."<br>";
	$sqlQuery = 'LOAD DATA LOCAL INFILE "'.$file.'" INTO TABLE '.$table.' FIELDS TERMINATED by \',\' OPTIONALLY ENCLOSED BY \'"\' LINES TERMINATED BY \'\r\n\'';
//	$sqlQuery = 'LOAD DATA LOCAL INFILE "'.$file.'" INTO TABLE '.$table.' FIELDS TERMINATED by \',\' LINES TERMINATED BY \'\n\'';
	$dbquery=mysql_query($sqlQuery) or exit ("<p>An error has occurred when accessing data from the database in <b>dbactions.php</b>. Please try again later or contact the site administrator.</p><p> SQL was: $sqlQuery</p><p>MySQL Error: ".mysql_error()."</p>");


?>