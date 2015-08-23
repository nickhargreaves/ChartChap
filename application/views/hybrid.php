    <div id="context_hybrid"></div>
    <div id='formstuff_hybrid'>
        Name:<br>
        <input type="text" name="name" style='width:100%' id='name_merge' class="form-control">
        <br>
        Category:<br>
        <select style='width:100%' name='category' id='category' class="form-control">
            <option>Select Category</option>
            <option value='health'>Health</option>
            <option value='education'>Education</option>
            <option value='water'>Water</option>
            <option value='counties'>Counties</option>
        </select>
        <br>
        Description:<br>
<textarea name='description' rows='7' style='width:100%' id='description' class="form-control">
</textarea><br>
        <b>Choose correspoding fields</b>
        <br>
        <?php

        foreach($rows as $row=>$columns)
        {
            echo $row."<br>";

            if (count($columns) > 0) {
                echo"<select name='v1' style='width:100%' id='v1' class='form-control'>";

                    foreach($columns as $column){
                        echo "<option value='".$column."'>".$column."</option>";
                    }

                echo"</select>";
            }
        }
        //Dataset 2

        foreach($rows2 as $row=>$columns)
        {
            echo $row."<br>";

            if (count($columns) > 0) {
                echo"<select name='v2' style='width:100%' id='v2' class='form-control'>";

                foreach($columns as $column){
                    echo "<option value='".$column."'>".$column."</option>";
                }

                echo"</select>";
            }
        }
        ?>

        <input type='hidden' value='<?php echo $d1?>' name='d1' id='d1' class='form-control'>
        <input type='hidden' value='<?php echo $d2?>' name='d2' id='d2' class='form-control'>
        <input type='submit' value='Create hybrid' class='btn btn-primary' onclick="ajaxrequest_hybrid('<?php echo base_url();?>merge/hybrid_process')" class='form-control'>
    </div>