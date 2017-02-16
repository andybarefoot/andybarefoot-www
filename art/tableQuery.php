<?php 
	require_once '../../includes/db-metnyc.php';
	require_once '../../includes/dbactions.php';

	if($_POST['fields']){
		$thisField = $_POST['fields'];
		$sqlQuery="SELECT count(*) AS theCount, `".$thisField."` FROM fullCatalogueOpt GROUP BY `".$thisField."` ORDER BY theCount DESC LIMIT 0,5000";
//		$sqlQuery="SELECT count(*) AS theCount, `".$thisField."` FROM fullCatalogueOpt GROUP BY `".$thisField."` ORDER BY `".$thisField."` ASC LIMIT 0,5000";
		$results=getData($sqlQuery);
	}else{
		$thisField = "";
		$results=[];
	}

	$columnNames = [
		'Object Number',
		'Is Highlight',
		'Is Public Domain',
		'Object ID',
		'Department',
		'Object Name',
		'Title',
		'Culture',
		'Period',
		'Dynasty',
		'Reign',
		'Portfolio',
		'Artist Role',
		'Artist Prefix',
		'Artist Display Name',
		'Artist Display Bio',
		'Artist Suffix',
		'Artist Alpha Sort',
		'Artist Nationality',
		'Artist Begin Date',
		'Artist End Date',
		'Object Date',
		'Object Begin Date',
		'Object End Date',
		'Medium',
		'Dimensions',
		'Credit Line',
		'Geography Type',
		'City',
		'State',
		'County',
		'Country',
		'Region',
		'Subregion',
		'Locale',
		'Locus',
		'Excavation',
		'River',
		'Classification',
		'ClassificationMedium',
		'ClassificationShort',
		'ClassificationMin',
		'Rights and Reproduction',
		'Link Resource',
		'Metadata Date',
		'Repository'
	];

?>
<form action="tableQuery.php" method="POST">
	<select name="fields">
<?php
	foreach($columnNames as $column){
		if($column==$thisField){
			print '<option value="'.$column.'" selected>'.$column.'</option>';
		}else{
			print '<option value="'.$column.'">'.$column.'</option>';
		}
	}
?>
</select>
<input type="submit">
</form>

<?php
	foreach($results as $result){
		print $result[1].' ('.$result[0].')<br>';
	}

/*
print '<br><br><br>';

		$sqlQuery="SELECT count(*) AS theCount, `Artist Display Name` FROM fullCatalogueOpt WHERE `ClassificationShort` = 'Paintings' GROUP BY `Artist Display Name` ORDER BY `Artist Alpha Sort` ASC LIMIT 0,5000";
		$sqlQuery="SELECT count(*) AS theCount, `Artist Display Name` FROM fullCatalogueOpt WHERE `ClassificationShort` = 'Paintings' GROUP BY `Artist Display Name` ORDER BY theCount DESC LIMIT 0,5000";
		$paintingResults=getData($sqlQuery);
	
		foreach($paintingResults as $paintingResult){
			print $paintingResult[1].' ('.$paintingResult[0].')<br>';
		}
*/

?>