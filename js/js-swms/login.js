var xmlHttp;
function createXMLHttpRequest() {
  if (window.ActiveXObject)
    // Internet Explorer
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  // Firefox, Opera 8.0+, Safari
  else xmlHttp = new XMLHttpRequest();
} //end function createXMLHttpRequest()

function stateChange() {
  if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
    alert(xmlHttp.responseText);
    if (xmlHttp.responseText == "0") {
      $("#loginModal").modal("show");
      document.getElementById("invalidTxt").style.display = "block";
    } else {
      alert("Login Success");
      location.replace("dashboard.php");
    }
  }
} // end function statechange()

function checkLogin(username, password) {
  if(username != "" && password != ""){
    document.getElementById("pageloader").classList.remove("d-none");
    document.getElementById("pageloader").style.animation = "animationfidein 1s";
    document.body.style.overflow = "hidden";
    document.getElementById("pageloader").style.opacity = "1";

    createXMLHttpRequest();
    xmlHttp.onreadystatechange = stateChange;
    var url = "./php-ajax/login-checking.php";
    url = url + "?username=" + username + "&password=" + password;
    alert(url);
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
  }
}
