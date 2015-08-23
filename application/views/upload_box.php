<div id="box">

		<div id ='filedrag'>

            <div id="drop">

                <div class="intro-text">
                    <span class="name">Drag and Drop File To Start</span>
                    <a href="assets/data/demo.csv" class="white_link">Download demo dataset</a>
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
                    <option value="0">Select category</option>
                <?php

                foreach($cats as $cat)
                {
                    echo '<option value="'.$cat['name'].'">'.$cat['name'].'</option>';
                }
                ?>
                </select>
                <select id='country' name='country'   class="form-control">
                    <option value="0">Select country</option>
                    <?php
                    foreach($countries as $country)
                    {
                        echo '<option value="'.$country['country_code'].'">'.$country['printable_name'].'</option>';
                    }
                    ?>
                </select>
            </div>
            <div  class="col-sm-8">
                <textarea id='description'  name='description' placeholder='Description' class="form-control" rows='5'></textarea>
                <input type='submit' name='submit' value='add dataset' class='btn btn-primary' onclick="ajaxrequest('Uploader/addcsv', 'context', 'stuff', 'loading')">

            </div>

</div>
<script type="text/javascript">document.getElementById("stuff").style.display = 'none';</script>


</div>
<div id="loading" align='center'>
    <img src='assets/img/loader.gif'>
</div>
<script type="text/javascript">document.getElementById("loading").style.display = 'none';</script>
<div id="context"></div>