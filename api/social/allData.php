<?php

$COUNT = intval($_GET["count"]);
if($COUNT<=0)$COUNT=5;

$OFFSET = intval($_GET["offset"]);
if($OFFSET<=0)$OFFSET=0;


function cmp($a, $b){
    return strcmp(intval($b['date']), intval($a['date']));
}



$andyInsText = file_get_contents('../instagram/andybarefoot.txt');
$gunterInsText = file_get_contents('../instagram/gunterguntychops.txt');
$andyFaceText = file_get_contents('../facebook/andybarefoot.txt');

$andyInsData = json_decode($andyInsText, true);
$gunterInsData = json_decode($gunterInsText, true);
$andyFaceData = json_decode($andyFaceText, true);

$andyInsNodes = $andyInsData['nodes'];
$gunterInsNodes = $gunterInsData['nodes'];
$andyFaceNodes = $andyFaceData['nodes'];

$allNodes = array_merge($andyInsNodes,$gunterInsNodes,$andyFaceNodes);
usort($allNodes, "cmp");
$nodes = array_slice($allNodes, $OFFSET, $COUNT);
$data = array (
	"offset" => $OFFSET,
	"count" => $COUNT,
);
$data["nodes"] = $nodes;
print json_encode($data);

?>