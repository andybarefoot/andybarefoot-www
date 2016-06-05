<?

$COUNT = intval($_GET["count"]);
if($COUNT<=0)$COUNT=5;

$OFFSET = intval($_GET["offset"]);
if($OFFSET<=0)$OFFSET=0;


function cmp($a, $b){
    return strcmp(intval($b['date']), intval($a['date']));
}



$andyText = file_get_contents('andybarefoot.txt');
$gunterText = file_get_contents('gunterguntychops.txt');
$andyData = json_decode($andyText, true);
$gunterData = json_decode($gunterText, true);
$andyNodes = $andyData['nodes'];
$gunterNodes = $gunterData['nodes'];

$allNodes = array_merge($andyNodes,$gunterNodes);
usort($allNodes, "cmp");
$nodes = array_slice($allNodes, $OFFSET, $COUNT);
$data = [
	"offset" => $OFFSET,
	"count" => $COUNT,
];
$data["nodes"] = $nodes;
print json_encode($data);

?>