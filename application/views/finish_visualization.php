<div class="well">
    <div class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="#">Choose visualization type</a>
        </div>
    </div>

    <div class="info-widget">
        <div class="row-fluid">
            <?php
             if ($sql) {
                echo "Chart created! ";

                //header('Location:'.$home.'chart.php?id='.$row['id']);
                echo '<div align="center"><a href="chart?id=' . $row['id'] . '" class="btn btn-primary">View Chart</a></div>';

            }
            ?>
        </div>
        <div class="line-divider"></div>

</div>
</div>