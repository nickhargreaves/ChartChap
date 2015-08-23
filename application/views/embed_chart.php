<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            <?php echo $data;?>
        ]);

        var options = {
            <?php

   $title=$_GET['title'];
   $height=$_GET['height'];
   $width=$_GET['width'];
   $backgroundColor=$_GET['backgroundColor'];
   $backgroundColorstroke=$_GET['backgroundColorstroke'];
   $backgroundColorstrokeWidth=$_GET['backgroundColorstrokeWidth'];
   $fill=$_GET['fill'];
   $fontSize=$_GET['fontSize'];
   $fontName=$_GET['fontName'];
   $type=$_GET['type'];
   $is3D=$_GET['is3D'];
   echo "title:'".$title."',\nheight:'".$height."',\nwidth:'".$width."',\nbackgroundColor:'".$backgroundColor."',\nbackgroundColor:{stroke: '".$backgroundColorstroke."', strokeWidth: ".$backgroundColorstrokeWidth.", fill: '".$fill."'},\nfontName:'".$fontName."',\nfontSize:'".$fontSize."',\nis3D:".$is3D;

   ?>
        };

        var chart = new google.visualization.<?php echo $type;?>(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>

<div align='center'>    <div id="chart_div" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px;"></div>
</div>