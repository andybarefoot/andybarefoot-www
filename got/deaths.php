<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');

        // For each orgchart box, provide the name, manager, and tooltip to show.
        data.addRows([
<?

include_once '../../includes/db-got.php';
include_once '../../includes/dbactions.php';

$sqlStmt="SELECT * FROM `gotChars` WHERE (charID IN (SELECT charKiller FROM `gotChars` WHERE charKiller != 0 AND charFirst !=0) AND charFirst != 0) || charKiller != 0 AND charFirst != 0 ORDER BY charLast ASC";
$charResults=getData($sqlStmt);
foreach($charResults as $char){
	$id = $char['charID'];
	$url = $char['charURL'];
	$killer = $char['charKiller'];
	if($killer==0)$killer="";
	$name = htmlspecialchars($char['charName'], ENT_QUOTES);
	print "[{v:'".$id."', f:'<a href=\'".$url."\'>".$name."</a>'},'".$killer."', '']";
	if ($char !== end($charResults)){
		print ",";
	}
}

?>
        ]);

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {allowHtml:true});
      }
   </script>
    </head>
  <body>
    <div id="chart_div"></div>
  </body>
</html>