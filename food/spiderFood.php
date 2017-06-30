<?php

include_once '../../includes/db-food.php';
include_once '../../includes/dbactions.php';


// Function for making a GET request using cURL
function curlGet($url) {
	$ch = curl_init();	// Initialising cURL session
	// Setting cURL options
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);	// Returning transfer as a string
//	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);	// Follow location
	curl_setopt($ch, CURLOPT_URL, $url);	// Setting URL
	$results = curl_exec($ch);	// Executing cURL session
	return $results;	// Return the results
}


// Funtion to return XPath object
function returnXPathObject($item) {
	$xmlPageDom = new DomDocument();	// Instantiating a new DomDocument object
	@$xmlPageDom->loadHTML($item);	// Loading the HTML from downloaded page
	$xmlPageXPath = new DOMXPath($xmlPageDom);	// Instantiating new XPath DOM object
	return $xmlPageXPath;	// Returning XPath object
}

// Function for scraping content between two strings
function scrapeBetween($item, $start, $end) {
	if (($startPos = stripos($item, $start)) === FALSE) {	// If $start string is not found
		return false;	// Return false
	} else if (($endPos = stripos($item, $end)) === FALSE) {	// If $end string is not found
		return false;	// Return false
	} else {
		$substrStart = $startPos + strlen($start);	// Assigning start position
		return substr($item, $substrStart, $endPos - $substrStart);	// Returning string between start and end positions
	}
}

function getRecipe($url){
	$sqlStmt="SELECT * FROM `foodRecipes` WHERE `recipeURL` = '".$url."'";
	$existResults=getData($sqlStmt);
	if(count($existResults)>0){
		print "already exists<br>";	
	}else{
		$thisPageUrl = $url;
		$thisPageSrc = curlGet($thisPageUrl);	// Requesting initial results page
		$xpath = returnXPathObject($thisPageSrc);	// Instantiating new XPath DOM object

		$titleElements = $xpath->query("//h1");
		$title = $titleElements->item(0)->nodeValue;
		echo "Title: ".$title."<br>";
		$attributionElements = $xpath->query("//span[@class='attribution']/a");
		$attribution = $attributionElements->item(0)->nodeValue;
		echo "Attribution: ".$attribution."<br>";
		$servingElements = $xpath->query("//div[@class='servings']/label/input/@value");
		$servings = $servingElements->item(0)->nodeValue;
		echo "Servings: ".$servings."<br>";
		$calorieElements = $xpath->query("//div[@class='recipe-summary-item nutrition']/span[@class='value']");
		$calories = $calorieElements->item(0)->nodeValue;
		echo "Calories: ".$calories."<br>";
		$ratingElements = $xpath->query("//div[@class='recipe-details-rating']/span/@data-tip");
		if($ratingElements->length > 0){
			$rating = $ratingElements->item(0)->nodeValue;
		}else{
			$rating = "";
		}
		$sqlStmt="INSERT INTO `foodRecipes` (`recipeID`, `recipeURL`, `recipeName`, `recipeSource`, `recipeServings`, `recipeCalories`, `recipeRating`) VALUES (NULL, '".$thisPageUrl."', '".addslashes ($title)."', '".addslashes ($attribution)."', '".$servings."', '".$calories."', '".addslashes ($rating)."');";
		$thisRecipe=insertDataReturnID($sqlStmt);

		echo "Rating: ".$rating."<br>";
		$ingredientElements = $xpath->query("//div[@class='IngredientLine']");
		foreach ($ingredientElements as $child) {
		    $amountChildren = $xpath->query("descendant::span[@class='amount']/span", $child);
	        $amount = "";
		    foreach ($amountChildren as $n) {
		        echo $n->nodeValue.' | ';
		        $amount = $n->nodeValue;
		    }
		    $unitChildren = $xpath->query("descendant::span[@class='unit']", $child);
	        $unit = "";
		    foreach ($unitChildren as $n) {
		        echo $n->nodeValue.' | ';
		        $unit = $n->nodeValue;
		    }
		    $ingredientChildren = $xpath->query("descendant::span[@class='ingredient']", $child);
	        $ingredient = "";
		    foreach ($ingredientChildren as $n) {
		        echo $n->nodeValue.' | ';
		        $ingredient = $n->nodeValue;
		    }
		    $remainderChildren = $xpath->query("descendant::span[@class='remainder']", $child);
	        $more = "";
		    foreach ($remainderChildren as $n) {
		        echo $n->nodeValue.' | ';
		        $more = $n->nodeValue;
		    }
		    echo '<br>';
			$sqlStmt="INSERT INTO `foodIngredients` (`ingredientID`, `ingredientRecipe`, `ingredientNumber`, `ingredientMeasure`, `ingredientName`, `ingredientMore`) VALUES (NULL, '".$thisRecipe."', '".$amount."', '".addslashes ($unit)."', '".addslashes($ingredient)."', '".addslashes($more)."');";
			$thisIngredient=insertDataReturnID($sqlStmt);
		}
	    echo '<br>';
	}
}

function getAllRecipes($file){
	$thisPageSrc = file_get_contents($file);	// Requesting initial results page
	$xpath = returnXPathObject($thisPageSrc);	// Instantiating new XPath DOM object
	$recipeLinks = $xpath->query("//div[@class='recipe-card single-recipe']/@data-url");
	for ($i = 0; $i < $recipeLinks->length; $i++) {
		$link="http://www.yummly.uk/recipe/".$recipeLinks->item($i)->nodeValue;
		print "<a href='".$link."'>".$link."</a><br>"; 
		getRecipe($link);
	}
}

//getRecipe("http://www.yummly.uk/recipe/Chocolate-Chip-Cookies-1532417");
getAllRecipes("allCookies.html");



?>