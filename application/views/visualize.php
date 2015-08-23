
<script type="text/javascript">

    // create the XMLHttpRequest object, according browser
    function get_XmlHttp() {
        // create the variable that will contain the instance of the XMLHttpRequest object (initially with null value)
        var xmlHttp = null;

        if(window.XMLHttpRequest) {		// for Forefox, IE7+, Opera, Safari, ...
            xmlHttp = new XMLHttpRequest();
        }
        else if(window.ActiveXObject) {	// for Internet Explorer 5 or 6
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        return xmlHttp;
    }

    // sends data to a php file, via POST, and displays the received answer
    function ajaxrequest(php_file, tagID, formstuff, loading, type) {
        var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
        document.getElementById("loading").style.display = 'block';
        document.getElementById("formstuff").style.display = 'none';
        // create pairs index=value with data that must be sent to server
        var  the_data = 'type='+type+'&dataset=<?php echo $_GET['dataset']?>';

        request.open("POST", php_file, true);			// set the request

        // adds  a header to tell the PHP script to recognize the data as is sent via POST
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(the_data);		// calls the send() method with datas as parameter

        // Check request status
        // If the response is received completely, will be transferred to the HTML tag with tagID
        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                document.getElementById(tagID).innerHTML = request.responseText;
                document.getElementById(formstuff).style.display='none';
                document.getElementById(loading).style.display='none';
            }
        }
    }
</script>
<div class="well">
    <div class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="#">Choose visualization type</a>
        </div>
    </div>

    <div class="info-widget">
        <div class="row-fluid">
            <div id="loading" align='center'>
                <img src='<?php echo base_url();?>assets/img/loader.gif'>
            </div>
            <script type="text/javascript">document.getElementById("loading").style.display = 'none';</script>
            <div id="context"></div>

            <div id='formstuff' style="position:relative; margin:auto;height:577px;width:517px;background:url('<?php echo base_url();?>assets/img/types.png')">
                <div id='piechart' style='background:rgba(255,0,0,0.4);cursor: pointer; cursor: hand;width:168px;position:absolute;height:139px;left:0px;' onclick="ajaxrequest('<?php echo base_url();?>/visualize/step2', 'context', 'formstuff', 'loading', 'PieChart')"></div>
                <div id='linechart' style='background:rgba(255,0,0,0.4);cursor: pointer; cursor: hand;width:163px;position:absolute;height:139px;top:292px;left:178px;' onclick="ajaxrequest('<?php echo base_url();?>/visualize/step2', 'context', 'formstuff', 'loading', 'LineChart')"></div>
            </div>
        </div>
        <div class="line-divider"></div>

    </div>
</div>