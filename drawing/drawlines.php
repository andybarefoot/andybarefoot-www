<!DOCTYPE html>
<html lang="en-us" ng-app="andybarefoot">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />    
    <title>Andy Barefoot | Data Visualisation</title>
    <meta charset="utf-8" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="main.css">
    <script src="/jscript/d3v4+jetpack.js"></script>
    <script src="/jscript/graph-scroll.js"></script>
    <script src="/jscript/analyticstracking.js"></script>
    </head>
    <body>
    <?php echo file_get_contents("flowerdisc.svg"); ?>
    <script>
      var speed = 0.5;
      var delayTally = 0;
      paths = d3.selectAll("path");
      paths.
        attr("stroke-dasharray", function(d,i) {
          return "0,"+this.getTotalLength();
        })
      ;
      paths
        .transition()
        .delay(function(d,i) {
          delay = delayTally;
          delayTally+=this.getTotalLength()/speed;
          return delay;
        })
        .attr("stroke-dasharray", function(d,i) {
          return this.getTotalLength()+",0";
        })
        .duration(function(d,i) {
          return this.getTotalLength()/speed;
        })
        .attr("stroke-dasharray", function(d,i) {
          return this.getTotalLength()+",0";
        })
      ;
    </script>
  </body>
</html>

