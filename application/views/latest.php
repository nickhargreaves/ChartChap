<script type="text/javascript" src="https://www.google.com/jsapi"></script>


<?php
    $i = 0;
    foreach($latest_charts as $chart){
?>

        <div class="col-sm-5 portfolio-item">
            <a href="#portfolioModal<?php echo $i?>" class="portfolio-link" data-toggle="modal">

                    <script type="text/javascript">
                        google.load("visualization", "1", {packages:["corechart"]});
                        google.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                <?php echo $chart['data'];?>
                            ]);
            
                            var options = {
                                <?php
                       echo "title:'".$chart['title']."'";
                       ?>
                            };
            
                            var chart = new google.visualization.<?php echo $chart['type'];?>(document.getElementById('chart_div<?php echo $i;?>'));
                            chart.draw(data, options);
                        }
                    </script>
            
                    <div id="chart_div<?php echo $i?>" style="width: 500px; height: 300px;"></div>

            </a>
        </div>

<?php
        $i++;
    }
?>