<script src="assets/js/html5uploader.js"></script>

<div id="box">

		<div id ='filedrag'>

            <div id="drop">

                <div class="intro-text">
                    <span class="name">Drag and Drop File To Start</span>
                </div>
                <div id="status">

                </div>
            </div>
		</div>
		<div align='center'>
            <div id="list">

            </div>
        </div>

		<div id='stuff' class="row-fluid">

            <div class="col-sm-4">
                <input id='name' type='text' name='name' placeholder='Dataset name' class="form-control">
                <select id='category' name='category'   class="form-control">
                <?php
                $cats = mysql_query("SELECT * FROM categories");
                while($cat = mysql_fetch_array($cats))
                {
                    echo '<option value="'.$cat['name'].'">'.$cat['name'].'</option>';
                }
                ?>
                </select>
                <select id='country' name='country'   class="form-control">
                    <?php
                    $countries = mysql_query("SELECT * FROM country");
                    while($country = mysql_fetch_array($countries))
                    {
                        if($country['printable_name']=='Kenya')
                        {
                            echo '<option value="'.$country['printable_name'].'" selected="selected">'.$country['printable_name'].'</option>';

                        }
                        else
                        {
                            echo '<option value="'.$country['printable_name'].'">'.$country['printable_name'].'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div  class="col-sm-8">
                <textarea id='description'  name='description' placeholder='Description' class="form-control" rows='5'></textarea>
                <input type='submit' name='submit' value='add dataset' class='btn btn-primary' onclick="ajaxrequest('uploader/addcsv', 'context', 'stuff', 'loading')">

            </div>

</div>
<script type="text/javascript">document.getElementById("stuff").style.display = 'none';</script>


</div>
<div id="loading" align='center'>
    <img src='assets/img/loader.gif'>
</div>
<script type="text/javascript">document.getElementById("loading").style.display = 'none';</script>
<div id="context"></div>