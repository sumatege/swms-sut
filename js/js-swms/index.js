var echeck = 1;
var pwcheck = 1;
var pwfcheck = 1;

function regis(){
    var name = document.getElementById("m_name").value;
    var sirname = document.getElementById("m_sirname").value;
    var email = document.getElementById("m_username").value;
    var password = document.getElementById("m_password").value;
    
    if(echeck == 0 && pwcheck == 0 && pwfcheck == 0 && name != "" && sirname != ""){
        //animation loader
        document.getElementById("pageloader").classList.remove("d-none");
        document.getElementById("pageloader").style.animation = "animationfidein 1s";
        document.body.style.overflow = "hidden";
        document.getElementById("pageloader").style.opacity = "1";
        
        const xhttp = new XMLHttpRequest();
        var url = "././php-ajax/registration.php";
        url = url + "?m_email=" + email + "&m_password=" + password + "&m_name=" + name + "&m_sirname=" + sirname;
        xhttp.onload = function(){
            setTimeout(() => {
                if(this.response == "0"){
                    location.replace('dashboard.php');
                }else{
                    $('#regisFailedModal').modal('show');
                }    
            }, 2000);
        }
        xhttp.open("GET",url);
        xhttp.send();
    }else{
        if(echeck == 1){
            document.getElementById("m_username").setCustomValidity("กรุณากรอกอีเมล์ให้ถูกต้อง!");
        }
    }
}

function CheckPassword(inputtxt) {
    var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
    if (inputtxt.match(passw)) {
        document.getElementById("passwordcheck").innerHTML = '<i class="bi bi-check-circle-fill" style="color:#3FFF35;font-size:20px"></i>';
        
        var fpw = document.getElementById("m_fpassword").value;
        if(fpw != ""){
            ConfirmPassword(fpw);
            /*if (fpw == inputtxt) {
                pwcheck = 0;
                document.getElementById("passwordcheck").innerHTML = '<i class="bi bi-check-circle-fill" style="color:#3FFF35;font-size:20px"></i>';
                pwfcheck = 0;
                document.getElementById("passwordconfirm").innerHTML = '<i class="bi bi-check-circle-fill" style="color:#3FFF35;font-size:20px"></i>';
                return true;
            } else {
                pwcheck = 1;
                document.getElementById("passwordcheck").innerHTML = '<i class="bi bi-x-circle-fill" style="color:#DA2121;font-size:20px"></i>';
                return false;
            }*/
        }else{
            return false;
        }     
    } else {
        pwcheck = 1;
        document.getElementById("passwordcheck").innerHTML = '<i class="bi bi-x-circle-fill" style="color:#DA2121;font-size:20px"></i>';
        return false;
    }
}

function ConfirmPassword(val) {
    var fpw = val;
    var pw = document.getElementById("m_password").value;
    if (fpw == pw) {
        pwfcheck = 0;
        document.getElementById("passwordconfirm").innerHTML = '<i class="bi bi-check-circle-fill" style="color:#3FFF35;font-size:20px"></i>';
        pwcheck = 0;
        document.getElementById("passwordcheck").innerHTML = '<i class="bi bi-check-circle-fill" style="color:#3FFF35;font-size:20px"></i>';
        return true;
    } else {
        pwfcheck = 1;
        document.getElementById("passwordconfirm").innerHTML = '<i class="bi bi-x-circle-fill" style="color:#DA2121;font-size:20px"></i>';
        return false;
    }
}

function EmailCheck(val){
    
    if(val != ""){
        document.getElementById("emailTxt").style.display ="block";

        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val))
        {
            ExistEmail(val);
            return true;
        }else{
            echeck = 1;
            document.getElementById("emailcheck").innerHTML = '<i class="bi bi-x-circle-fill" style="color:#DA2121;font-size:20px"></i>';
            return false;
        }
    }else{
        document.getElementById("emailTxt").style.display ="none";
    }
}

function ExistEmail(val){
    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/email-check.php";
    url = url + "?m_email=" + val;
    xhttp.onload = function(){
        if(this.response == "0"){
            echeck = 0;
            document.getElementById("emailcheck").innerHTML = '<i class="bi bi-check-circle-fill" style="color:#3FFF35;font-size:20px"></i>';
            document.getElementById("emailTxt").innerHTML = "ใช้อีเมล์นี้ได้";
            document.getElementById("emailTxt").style.color = "#3FFF35";         
            return true;
        }else{
            echeck = 1;
            document.getElementById("emailcheck").innerHTML = '<i class="bi bi-x-circle-fill" style="color:#DA2121;font-size:20px"></i>';
            document.getElementById("emailTxt").innerHTML = "อีเมล์นี้ถูกใช้แล้ว กรุณาใส่อีเมล์ใหม่!";
            document.getElementById("emailTxt").style.color = "#da2121";
            return false;
        }
    }
    xhttp.open("GET",url);
    xhttp.send();
}
