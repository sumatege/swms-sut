var xmlHttp;
function createXMLHttpRequest()
{
    if (window.ActiveXObject) // Internet Explorer
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    else // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
} //end function createXMLHttpRequest()

function stateChange()
{
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //document.myForm.greeting.value=xmlHttp.responseText;
        window.location.replace("./index.php");
    }
} // end function statechange()

function logout()
{
    setTimeout(5000);
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = stateChange;
    var url = "./php-ajax/logout.php";
    //alert(url);
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
} 

