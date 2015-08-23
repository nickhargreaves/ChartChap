

                <div id="loading_merge" align='center'>
                    <img src='<?php echo base_url();?>assets/img/loader.gif'>
                </div>
                <script type="text/javascript">document.getElementById("loading_merge").style.display = 'none';</script>
                <div id="context_merge"></div>
                <div id='formstuff_merge' >

                    <?php

                    //first dataset
                    echo "Dataset 1: <select  class='form-control' style='width:100%' name='d1' id='d1'>";
                    foreach($datasets as $row)
                    {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";

                    }
                    echo "</select>";

                    //second dataset
                    echo "Dataset 2: <select  class='form-control' style='width:100%' name='d2' id='d2'>";
                    $datasets = array_reverse($datasets);
                    foreach($datasets as $row)
                    {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";

                    }
                    ?>
                    </select><input type='submit' value='proceed' class='btn btn-primary' onclick="ajaxrequest_merge('<?php echo base_url();?>merge/hybrid')">

                </div>
            <div class="line-divider"></div>
