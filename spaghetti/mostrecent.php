<?php
function mostrecent($id)
{

?>
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
echo "title:'".$title."'";

?>
        };

        var chart = new google.visualization.<?php echo $type;?>(document.getElementById('chart_div<?php echo $id?>'));
        chart.draw(data, options);
      }
    </script>

<div id="chart_div<?php echo $id?>" style="width: 100%; height: 300px;"></div>
<?php
}
?>

                   