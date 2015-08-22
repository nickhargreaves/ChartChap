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
function ajaxrequest(php_file, tagID, stuff, loading) {
    var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
    document.getElementById("loading").style.display = 'block';
    document.getElementById("stuff").style.display = 'none';
    document.getElementById("list").style.display='none';
    // create pairs index=value with data that must be sent to server
    var  the_data = 'name='+document.getElementById('name').value+'&description='+document.getElementById('description').value+'&category='+document.getElementById('category').value+'&country='+document.getElementById('country').value+'&csv='+document.getElementById('csv').value;
    //var  the_data = 'bla='+document.getElementById('dtb').value+'&test='+document.getElementById('dta').value;
    request.open("POST", php_file, true);			// set the request

    // adds  a header to tell the PHP script to recognize the data as is sent via POST
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(the_data);		// calls the send() method with datas as parameter

    // Check request status
    // If the response is received completely, will be transferred to the HTML tag with tagID
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            document.getElementById(tagID).innerHTML = request.responseText;
            document.getElementById(stuff).style.display='none';
            document.getElementById(loading).style.display='none';

        }
    }
}