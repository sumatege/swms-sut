var reqStatus = 0;

function startFunction() {
    startTime();
    setTimeout(function () {
        contentData();
        mrec_checkreq();
        startFunction();
    }, 3000);    
}

function dropdownList() {
    let projectlist = document.querySelector('#projectlist');
    var request = new XMLHttpRequest();
    request.open("GET", "./php-ajax/get-project-list.php");
    request.onload = function () {
        var data = JSON.parse(this.response);

        // No project
        var keyCount = Object.keys(data).length;
        if (keyCount == 0) {
            document.getElementById("dropdownHead").innerHTML = "ไม่พบข้อมูล";
            document.getElementById("projectNameHead").innerHTML = "ไม่พบข้อมูล";
            document.getElementById("deleteBtnClass").className += " disabled";
            document.getElementById("deleteBtn").style.color = "gray";
            document.getElementById("settingProjectNameClass").className += " disabled";
            document.getElementById("settingProjectNameBtn").style.color = "gray";

            $('#nodataModal').modal('show');
        } else {
            //Set dropdown text
            //console.log(data[0]["p_name"]);

            document.getElementById("deleteBtnClass").classList.remove("disabled");
            document.getElementById("deleteBtn").style.color = "red";
            document.getElementById("settingProjectNameClass").classList.remove("disabled");
            document.getElementById("settingProjectNameBtn").style.color = "white";

            var checkSession = document.getElementById("session_p_key").getAttribute('value');
            //alert(checkSession);
            if (checkSession == "") {
                document.getElementById("dropdownHead").innerHTML = data[0]["p_name"];
                document.getElementById("projectNameHead").innerHTML = data[0]["p_name"];

                document.getElementById("delete_pj_equipment_key").innerHTML = data[0]["p_key"];
                document.getElementById("delete_pj_name").innerHTML = data[0]["p_name"];
                document.getElementById("delete_pj_id").innerHTML = data[0]["p_id"];
                document.getElementById("deleteBtn").style.color = "red";

                document.getElementById("p_key").value = data[0]["p_key"];
                document.getElementById("p_name").value = data[0]["p_name"];
                document.getElementById("p_id").value = data[0]["p_id"];

                var requestSession = new XMLHttpRequest();
                var url = "./php-ajax/set-selected-project.php?p_id=" + data[0]["p_id"] + "&p_name=" + data[0]["p_name"] + "&p_key=" + data[0]["p_key"];
                //alert(url);
                requestSession.open("GET", url);
                requestSession.send();
            } else {
                var session_p_key = document.getElementById("session_p_key").getAttribute('value');
                var session_p_id = document.getElementById("session_p_id").getAttribute('value');
                var session_p_name = document.getElementById("session_p_name").getAttribute('value');

                document.getElementById("dropdownHead").innerHTML = session_p_name
                document.getElementById("projectNameHead").innerHTML = session_p_name

                document.getElementById("delete_pj_equipment_key").innerHTML = session_p_key
                document.getElementById("delete_pj_name").innerHTML = session_p_name
                document.getElementById("delete_pj_id").innerHTML = session_p_id
                document.getElementById("deleteBtn").style.color = "red";

                document.getElementById("p_key").value = session_p_key;
                document.getElementById("p_name").value = session_p_name;
                document.getElementById("p_id").value = session_p_id;
            }

            if (request.status >= 200 && request.status < 400) {
                data.forEach(results => {
                    projectlist.insertAdjacentHTML('beforeend','<a class="dropdown-item" onclick="setSelectedProject(' + results["p_id"] +')">' + results["p_name"] + '</a>');
                });
            } else {
                console.log("error");
            }
        }
    };
    request.send();
}

function logout() {
    //animation loader
    document.getElementById("pageloader").classList.remove("d-none");
    document.getElementById("pageloader").style.animation = "animationfidein 1s";
    document.getElementById("pageloader").style.opacity = "1";
    document.body.style.overflow = "hidden";

    var request = new XMLHttpRequest();
    request.open("GET", "./php-ajax/logout.php");
    request.onload = function () {
        setTimeout(() => {
            if (this.response == "0") {
                document.getElementById("pageloader").style.animation = "animationfideout 1s";
                document.getElementById("pageloader").style.opacity = "0";
                setTimeout(() => {
                    document.body.style.overflow = "scroll";
                    document.getElementById("pageloader").classList.add("d-none");
                }, 1000);
                location.replace("./index.php");
            } else {
                alert("Logout failed!");
            }
        }, 1000);
    }
    request.send();
}

function startTime() {
    const today = new Date();
    let h = today.getHours();
    let m = today.getMinutes();
    let s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);

    var todayDate = new Date();
    var date = todayDate.toLocaleDateString();

    document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
    document.getElementById("dateTxt").innerHTML = date;
    setTimeout(startTime, 1000);
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i
    }; // add zero in front of numbers < 10
    return i;
}

function member(){
    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/get-member.php";
    xhttp.onload = function(){
        var data = JSON.parse(this.response);
        if(data.status == "0"){
            document.getElementById("user-data").innerHTML = data.m_name + " " + data.m_sirname + " [Member ID: " + data.m_id + "]";
            document.getElementById("m_name").value = data.m_name;
            document.getElementById("m_sirname").value = data.m_sirname;
            document.getElementById("m_email").value = data.m_email;
            document.getElementById("m_hiddenemail").value = data.m_email;            
        }
    }
    xhttp.open("GET",url);
    xhttp.send();
}

function contentData() {
    var request = new XMLHttpRequest();
    request.open("GET", "./php-ajax/get-project-data.php");
    request.onload = function() {
        var data = JSON.parse(this.response); 
        //console.log(data);

        //Project not exist
        if (data.status == "0") {            
            document.getElementById("dropdownHead").innerHTML = "ไม่พบข้อมูล";
            document.getElementById("projectNameHead").innerHTML = "ไม่พบข้อมูล";

            document.getElementById("firstVal").innerHTML = "ไม่พบข้อมูล!";
            document.getElementById("secondVal").innerHTML = "ไม่พบข้อมูล!";
            document.getElementById("thirdVal").innerHTML = "ไม่พบข้อมูล!";
            document.getElementById("fourthVal").innerHTML = "ไม่พบข้อมูล!";
            document.getElementById("fifthVal").innerHTML = "ไม่พบข้อมูล!";
            document.getElementById("sixthVal").innerHTML = "ไม่พบข้อมูล!";
            document.getElementById("seventhVal").innerHTML = "ไม่พบข้อมูล!";
            document.getElementById("waterQTxt").innerHTML = "<br/><br/>ไม่พบข้อมูล!";
            document.getElementById("aerotorTxt").innerHTML = "<br/><br/>ไม่พบข้อมูล!";
            document.getElementById("aerotor").style.display = "none";
            document.getElementById("water-quality").style.display = "none";

            document.getElementById("firstVal").style.color = "gray";
            document.getElementById("secondVal").style.color = "gray";
            document.getElementById("thirdVal").style.color = "gray";
            document.getElementById("fourthVal").style.color = "gray";
            document.getElementById("fifthVal").style.color = "gray";
            document.getElementById("sixthVal").style.color = "gray";
            document.getElementById("seventhVal").style.color = "gray";
            document.getElementById("waterQTxt").style.color = "gray";
            document.getElementById("aerotorTxt").style.color = "gray";
            document.getElementById("aerotor").style.color = "gray";
            document.getElementById("water-quality").style.color = "gray";

        //if project exist
        }else{            
            if (request.status >= 200 && request.status < 400) {
                //request normal
                if(data.p_req_val == 0){

                    document.getElementById("firstVal").innerHTML = data.p_ox_val;
                    document.getElementById("firstVal").style.color = "darkblue";
                    document.getElementById("firstVal").style.fontSize = "40px";
        
                    document.getElementById("secondVal").innerHTML = data.p_wtemp_val;
                    document.getElementById("secondVal").style.color = "darkblue";
                    document.getElementById("secondVal").style.fontSize = "40px";
        
                    document.getElementById("thirdVal").innerHTML = data.p_ph_val;
                    document.getElementById("thirdVal").style.color = "darkblue";
                    document.getElementById("thirdVal").style.fontSize = "40px";
        
                    document.getElementById("fourthVal").innerHTML = data.p_sal_val;
                    document.getElementById("fourthVal").style.color = "darkblue";
                    document.getElementById("fourthVal").style.fontSize = "40px";
        
                    document.getElementById("fifthVal").innerHTML = data.p_cond_val;
                    document.getElementById("fifthVal").style.color = "darkblue";
                    document.getElementById("fifthVal").style.fontSize = "40px";
        
                    document.getElementById("sixthVal").innerHTML = data.p_atemp_val;
                    document.getElementById("sixthVal").style.color = "darkblue";
                    document.getElementById("sixthVal").style.fontSize = "40px";
        
                    document.getElementById("seventhVal").innerHTML = data.p_hum_val;
                    document.getElementById("seventhVal").style.color = "darkblue";
                    document.getElementById("seventhVal").style.fontSize = "40px";
        
                    WaterQualityFunc(data.p_ox_val, data.p_wq_val, data.p_noti_switch);
                    //aerotorFunc(data.p_ae_val);
                }else{

                    //request abnormal
                    document.getElementById("firstVal").innerHTML = '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
                    document.getElementById("secondVal").innerHTML = '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
                    document.getElementById("thirdVal").innerHTML = '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
                    document.getElementById("fourthVal").innerHTML = '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
                    document.getElementById("fifthVal").innerHTML = '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
                    document.getElementById("sixthVal").innerHTML = '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
                    document.getElementById("seventhVal").innerHTML = '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
                    document.getElementById("aerotor").innerHTML = '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
                    document.getElementById("aerotor").style.display = "block";
                    document.getElementById("aerotor").style.animation = "rotating 0s";
                    document.getElementById("water-quality").innerHTML = '<div class="spinner-border m-3" role="status"><span class="sr-only"></span></div>';
                    document.getElementById("water-quality").style.display = "block";
                    document.getElementById("water-quality").style.animation = "blinker 0s linear infinite";

                    document.getElementById("waterQTxt").style.display = "none";
                    document.getElementById("aerotorTxt").style.display = "none";
        
                    document.getElementById("firstVal").style.color = "black";
                    document.getElementById("firstVal").style.fontSize = "16px";
                    document.getElementById("secondVal").style.color = "black";
                    document.getElementById("secondVal").style.fontSize = "16px";
                    document.getElementById("thirdVal").style.color = "black";
                    document.getElementById("thirdVal").style.fontSize = "16px";
                    document.getElementById("fourthVal").style.color = "black";
                    document.getElementById("fourthVal").style.fontSize = "16px";
                    document.getElementById("fifthVal").style.color = "black";
                    document.getElementById("fifthVal").style.fontSize = "16px";
                    document.getElementById("sixthVal").style.color = "black";
                    document.getElementById("sixthVal").style.fontSize = "16px";
                    document.getElementById("seventhVal").style.color = "black";
                    document.getElementById("seventhVal").style.fontSize = "16px";
                    document.getElementById("waterQTxt").style.color = "black";
                    document.getElementById("aerotorTxt").style.color = "black";
                    document.getElementById("aerotor").style.color = "black";
                    document.getElementById("water-quality").style.color = "black";
                }                
            } else {
                console.log("error");
            }
        }        
    };
    request.send();
}

function setSelectedProject(p_id) {
    setTimeout(() => {
        str = '<div class="spinner-border" role="status" style="font-size:1rem"><span class="sr-only"></span></div>';
        document.getElementById("firstVal").innerHTML = str;
        document.getElementById("secondVal").innerHTML = str;
        document.getElementById("thirdVal").innerHTML = str;
        document.getElementById("fourthVal").innerHTML = str;
        document.getElementById("fifthVal").innerHTML = str;
        document.getElementById("sixthVal").innerHTML = str;
        document.getElementById("seventhVal").innerHTML = str;
        wqStr = '<div class="spinner-border" role="status" style="font-size:1rem; margin-top: 20px"><span class="sr-only"></span></div>';
        document.getElementById("water-quality").innerHTML = wqStr;
        document.getElementById("water-quality").style.animation = "blinker 0s linear infinite";
        document.getElementById("waterQTxt").style.display = "none";
        document.getElementById("aerotor").innerHTML = wqStr;
        document.getElementById("aerotorTxt").style.display = "none";

        document.getElementById("firstVal").style.color = "black";
        document.getElementById("secondVal").style.color = "black";
        document.getElementById("thirdVal").style.color = "black";
        document.getElementById("fourthVal").style.color = "black";
        document.getElementById("fifthVal").style.color = "black";
        document.getElementById("sixthVal").style.color = "black";
        document.getElementById("seventhVal").style.color = "black";

        document.getElementById("myAudio").pause();
        sessionStorage.setItem("pingSound", "0");
    }, 3000);

    var requestSession = new XMLHttpRequest();
    requestSession.open("GET", "./php-ajax/set-selected-project.php?p_id=" + p_id + "&p_name=nodata");
    requestSession.onload = function() {
        var data = JSON.parse(this.response);
        if (requestSession.status >= 200 && requestSession.status < 400) {
            document.getElementById("dropdownHead").innerHTML = data.p_name;
            document.getElementById("projectNameHead").innerHTML = data.p_name;
            
            document.getElementById("delete_pj_equipment_key").innerHTML = data.p_key;
            document.getElementById("delete_pj_name").innerHTML = data.p_name;
            document.getElementById("delete_pj_id").innerHTML = data.p_id;

            document.getElementById("p_key").value = data.p_key;
            document.getElementById("p_name").value = data.p_name;

            sessionStorage.setItem("projectForDelete", p_id);
        } else {
            console.log("error");
        }
    };
    requestSession.send();
}

function aerotorFunc(val) {
    if (val == 0) {
        document.getElementById("aerotor").innerHTML = '<img src="images/content/aerotor-status-on.gif" height="110px" />';
        document.getElementById("aerotorTxt").innerHTML = "[กำลังทำงาน]";
        document.getElementById("aerotorTxt").style.display = "block";
        document.getElementById("aerotor").classList.remove("m-3");
    } else {
        document.getElementById("aerotor").innerHTML = '<img src="images/content/aerotor-status-off.png" height="110px" />';
        document.getElementById("aerotorTxt").innerHTML = "[หยุดทำงาน]";
        document.getElementById("aerotorTxt").style.display = "block";
        document.getElementById("aerotor").classList.remove("m-3");
    }
}

sessionStorage.setItem("pingSound", "0");
function WaterQualityFunc(ox, wq, notiswitch) {
    if(notiswitch == 0){
        if (ox > wq) {
            document.getElementById("water-quality").innerHTML = '<i class="bi bi-circle-fill normal-measure-status"></i>';
            document.getElementById("water-quality").style.animation = "blinker 1.5s linear infinite";
            document.getElementById("waterQTxt").innerHTML = "[ปกติ]";
            document.getElementById("waterQTxt").style.color = "black";
            document.getElementById("waterQTxt").style.display = "block";
            document.getElementById("firstVal").style.color = "darkblue";

            document.getElementById("myAudio").pause();
            sessionStorage.setItem("pingSound", "0");

            aerotorFunc(1);
        } else {
            document.getElementById("water-quality").innerHTML = '<i class="bi bi-circle-fill abnormal-measure-status"></i>';
            document.getElementById("water-quality").style.animation = "blinker 1.5s linear infinite";
            document.getElementById("waterQTxt").innerHTML = "[ระดับออกซิเจนต่ำกว่า " + wq + " mg/L]";
            document.getElementById("waterQTxt").style.color = "red";
            document.getElementById("waterQTxt").style.display = "block";
            document.getElementById("firstVal").style.color = "red";
            document.getElementById("oxmodaltxt").innerHTML = wq;

            var ps = sessionStorage.getItem("pingSound");
            if (ps == 0) {
                setTimeout(function () {
                    document.getElementById("myAudio").play();
                    sessionStorage.setItem("pingSound", "1");            
                    $('#LowOxigenModal').modal('show');
                }, 10);

                document.getElementById("myAudio").pause();
            }

            aerotorFunc(0);
        }
    }else{
        document.getElementById("myAudio").pause();
        sessionStorage.setItem("pingSound", "0");

        if (ox > wq) {
            document.getElementById("water-quality").innerHTML = '<i class="bi bi-circle-fill normal-measure-status"></i>';
            document.getElementById("water-quality").style.animation = "blinker 1.5s linear infinite";
            document.getElementById("waterQTxt").innerHTML = "[ปกติ]";
            document.getElementById("waterQTxt").style.color = "black";
            document.getElementById("waterQTxt").style.display = "block";
            document.getElementById("firstVal").style.color = "darkblue";

            aerotorFunc(1);
        } else {
            document.getElementById("water-quality").innerHTML = '<i class="bi bi-circle-fill abnormal-measure-status"></i>';
            document.getElementById("water-quality").style.animation = "blinker 1.5s linear infinite";
            document.getElementById("waterQTxt").innerHTML = "[ระดับออกซิเจนต่ำกว่า " + wq + " mg/L]";
            document.getElementById("waterQTxt").style.color = "red";
            document.getElementById("waterQTxt").style.display = "block";
            document.getElementById("firstVal").style.color = "red";

            aerotorFunc(0);
        }
    }
}

function mrec_checkreq() {
    var request = new XMLHttpRequest();
    request.open("GET", "./php-ajax/get-project-data.php");
    request.onload = function () {
        if (request.status >= 200 && request.status < 400) {
            var data = JSON.parse(this.response);
            if(data.status == 1){
                checkReq(data.p_req_val);
            }
        }
    }
    request.send();
    setTimeout(mrec_checkreq, 3000);
}

function checkReq(val) {
    if (val == 0) {
        document.getElementById("status-blink-txt").innerHTML = '<i class="bi bi-circle-fill status-blink" id="statusblink"></i> สถานะการส่งค่า [ออนไลน์]';
        document.getElementById("statusblink").style.color = "greenyellow";
        document.getElementById("statusblink").style.animation = "blinker 1.5s linear infinite";
        reqStatus = 0;
    } else {
        document.getElementById("status-blink-txt").innerHTML = '<i class="bi bi-circle-fill status-blink" id="statusblink"></i> สถานะการส่งค่า [ออฟไลน์]';
        document.getElementById("statusblink").style.color = "gray";
        document.getElementById("statusblink").style.animation = "blinker 0s linear infinite";
        
        if(reqStatus == 0){
            $('#requestFailedModal').modal('show');
            reqStatus = 1;
        }        
    }
}

function addNewProject(add_pkey, add_pname){
    if(add_pkey != "" && add_pname != ""){
        const getJSON = async url => {
            const response = await fetch(url);
            if (!response.ok) // check if response worked (no 404 errors etc...)
                throw new Error(response.statusText);
    
            const data = await response.json(); // get JSON from the response
            return data; // returns a promise, which resolves to this data value
        }
    
        getJSON("./php-ajax/check-project-before-add.php?projectkey=" + add_pkey).then(data => {            
            if(data.p_key != "null"){
                if(data.p_owner == null){
                    document.getElementById("pageloader").classList.remove("d-none");
                    document.getElementById("pageloader").style.animation = "animationfidein 1s";
                    document.body.style.overflow = "hidden";
                    document.getElementById("pageloader").style.opacity = "1";

                    const xhttp = new XMLHttpRequest();
                    var url = "././php-ajax/update-new-project.php";
                    url = url + "?p_key=" + add_pkey + "&p_name=" + add_pname;
                    xhttp.onload = function () {
                        if (this.response == "0") {
                            location.replace("dashboard.php");                            
                        } else {
                            alert(this.response);
                        }
                    }
                    xhttp.open("GET", url);
                    xhttp.send();
                }else{                    
                    $('#projectexistsModal').modal('show');
                }
            }else{
                $('#projectnotexistsModal').modal('show');
            }            
        }).catch(error => {
            console.error(error);
        });
    }
}

function confirmAddProject(){
    var p_key = document.getElementById("add_pj_equipment_id").innerHTML;
    var p_owner = document.getElementById("add_pj_owner").innerHTML;
    var p_name = document.getElementById("add_pj_name").innerHTML;
    
    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/update-new-project.php";
    url = url + "?p_key=" + p_key + "&p_name=" + p_name + "&p_owner=" + p_owner;
    xhttp.onload = function(){
        if (this.response == "0") {
            location.replace("dashboard.php");
            member();
        } else {
            alert(this.response);
        }
    }
    xhttp.open("GET",url);
    xhttp.send();
}

function confirmDeleteProject(){
    document.getElementById("pageloader").classList.remove("d-none");
    document.getElementById("pageloader").style.animation = "animationfidein 1s";
    document.body.style.overflow = "hidden";
    document.getElementById("pageloader").style.opacity = "1";

    var p_key = document.getElementById("delete_pj_equipment_key").innerHTML;
    
    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/hide-project.php";
    url = url + "?p_key=" + p_key;
    xhttp.onload = function(){
        setTimeout(() => {
            if (this.response == "0") {
                document.getElementById("pageloader").style.animation = "animationfideout 0.3s";
                document.getElementById("pageloader").style.opacity = "0";
                setTimeout(() => {
                    document.body.style.overflow = "scroll";
                    document.getElementById("pageloader").classList.add("d-none");
                    location.replace("dashboard.php");
                }, 1000);
                member();
            } else {
                alert(this.response);
            }
        }, 2000);
    }
    xhttp.open("GET",url);
    xhttp.send();
}

function editName(){
    document.getElementById("btnsavename").style.display = "block";
    document.getElementById("btncancelname").style.display = "block";
    document.getElementById("btneditname").style.display = "none";

    document.getElementById("m_name").disabled = false;
    document.getElementById("m_sirname").disabled = false;
    document.getElementById("m_name").style.color = "black";
    document.getElementById("m_sirname").style.color = "black";
}

function saveEditName(){
    document.getElementById("btnsavename").style.display = "none";
    document.getElementById("btncancelname").style.display = "none";
    document.getElementById("btneditname").style.display = "block";

    document.getElementById("m_name").disabled = true;
    document.getElementById("m_sirname").disabled = true;
    document.getElementById("m_name").style.color = "rgb(116, 116, 116)";
    document.getElementById("m_sirname").style.color = "rgb(116, 116, 116)";

    document.getElementById("nameTxt").style.display = "none";

    var name = document.getElementById("m_name").value;
    var sirname = document.getElementById("m_sirname").value;
    updateName(name, sirname);
}

function cancelEditName(){
    member();

    document.getElementById("btnsavename").style.display = "none";
    document.getElementById("btncancelname").style.display = "none";
    document.getElementById("btneditname").style.display = "block";

    document.getElementById("m_name").disabled = true;
    document.getElementById("m_sirname").disabled = true;
    document.getElementById("m_name").style.color = "rgb(116, 116, 116)";
    document.getElementById("m_sirname").style.color = "rgb(116, 116, 116)";

    document.getElementById("nameTxt").style.display = "none";
}

function updateName(name, sirname){
    //animation loader
    document.getElementById("pageloader").classList.remove("d-none");
    document.getElementById("pageloader").style.animation = "animationfidein 1s";
    document.getElementById("pageloader").style.opacity = "1";
    document.body.style.overflow = "hidden";

    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/update-member-name.php";
    url = url + "?m_name=" + name + "&m_sirname=" + sirname;
    xhttp.onload = function(){
        setTimeout(() => {
            if (this.response == "0") {
                document.getElementById("pageloader").style.animation = "animationfideout 0.3s";
                document.getElementById("pageloader").style.opacity = "0";
                setTimeout(() => {
                    document.body.style.overflow = "scroll";
                    document.getElementById("pageloader").classList.add("d-none");
                }, 1000);
                member();
            } else {
                alert(this.response);
            }
        }, 3000);
    }
    xhttp.open("GET",url);
    xhttp.send();
}

function checkNameNull(){
    var name = document.getElementById("m_name").value;
    var sirname = document.getElementById("m_sirname").value;
    if(name != "" && sirname != ""){
        document.getElementById("disabledNameEditBtn").innerHTML = '<a href="#" id="btnsavename" onclick="saveEditName()">บันทึก</a>';
        document.getElementById("nameTxt").style.display = "none";
    }else{
        document.getElementById("disabledNameEditBtn").innerHTML = '<span id="btnsavename" style="color:gray">บันทึก</span>';
        document.getElementById("nameTxt").innerHTML = "กรุณากรอกข้อมูลให้ครบถ้วน!";
        document.getElementById("nameTxt").style.color = "#da2121";
        document.getElementById("nameTxt").style.display = "block";
    }
}

function editEmail(){
    document.getElementById("btnsaveemail").style.display = "block";
    document.getElementById("btncancelemail").style.display = "block";
    document.getElementById("btneditemail").style.display = "none";

    document.getElementById("m_email").disabled = false;
    document.getElementById("m_email").style.color = "black";

}

function saveEditEmail(){
    document.getElementById("btnsaveemail").style.display = "none";
    document.getElementById("btncancelemail").style.display = "none";
    document.getElementById("btneditemail").style.display = "block";

    document.getElementById("m_email").disabled = true;
    document.getElementById("m_email").style.color = "rgb(116, 116, 116)";

    document.getElementById("emailTxt").style.display = "none";

    var email = document.getElementById("m_email").value;
    updateEmail(email);
}

function cancelEditEmail(){
    member();
    
    document.getElementById("btnsaveemail").style.display = "none";
    document.getElementById("btncancelemail").style.display = "none";
    document.getElementById("btneditemail").style.display = "block";

    document.getElementById("m_email").disabled = true;
    document.getElementById("m_email").style.color = "rgb(116, 116, 116)";

    document.getElementById("emailTxt").style.display = "none";
}

function updateEmail(email){
    //animation loader
    document.getElementById("pageloader").classList.remove("d-none");
    document.getElementById("pageloader").style.animation = "animationfidein 1s";
    document.getElementById("pageloader").style.opacity = "1";
    document.body.style.overflow = "hidden";

    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/update-member-email.php";
    url = url + "?m_email=" + email;
    xhttp.onload = function(){
        setTimeout(() => {
            if (this.response == "0") {
                document.getElementById("pageloader").style.animation = "animationfideout 0.3s";
                document.getElementById("pageloader").style.opacity = "0";
                setTimeout(() => {
                    document.body.style.overflow = "scroll";
                    document.getElementById("pageloader").classList.add("d-none");
                }, 1000);
                member();
            } else {
                alert(this.response);
            }
        }, 3000);
    }
    xhttp.open("GET",url);
    xhttp.send();
}

function EmailCheck(val){
    document.getElementById("emailTxt").style.display ="block";
    var oldEmail = document.getElementById("m_hiddenemail").value;
    if(val != ""){
        if(oldEmail != val){
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val))
            {
                ExistEmail(val);
            }else{
                document.getElementById("disabledEmailEditBtn").innerHTML = '<span id="btnsaveemail" style="color:gray">บันทึก</span>';
                document.getElementById("emailTxt").innerHTML = "กรุณาใส่อีเมล์ใหม่ให้ถูกต้อง ตัวอย่าง example@example.com";
                document.getElementById("emailTxt").style.color = "#da2121";
                document.getElementById("btnsaveemail").disabled = true;
                return false;
            }
        }else{
            document.getElementById("disabledEmailEditBtn").innerHTML = '<a href="#" id="btnsaveemail" onclick="saveEditEmail()">บันทึก</a>';
            document.getElementById("emailTxt").style.display ="none";
        }
    }else{
        document.getElementById("disabledEmailEditBtn").innerHTML = '<span id="btnsaveemail" style="color:gray">บันทึก</span>';
        document.getElementById("emailTxt").innerHTML = "กรุณาใส่อีเมล์ใหม่ให้ถูกต้อง ตัวอย่าง example@example.com";
        document.getElementById("emailTxt").style.color = "#da2121";
        document.getElementById("btnsaveemail").disabled = true;
    }
}

function ExistEmail(val){
    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/email-check.php";
    url = url + "?m_email=" + val;
    xhttp.onload = function(){
        if(this.response == "0"){
            document.getElementById("disabledEmailEditBtn").innerHTML = '<a href="#" id="btnsaveemail" onclick="saveEditEmail()">บันทึก</a>';
            document.getElementById("emailTxt").innerHTML = "ใช้อีเมล์นี้ได้";
            document.getElementById("emailTxt").style.color = "#3FFF35";
            return true;
        }else{
            document.getElementById("disabledEmailEditBtn").innerHTML = '<span id="btnsaveemail" style="color:gray">บันทึก</span>';
            document.getElementById("emailTxt").innerHTML = "อีเมล์นี้ถูกใช้แล้ว กรุณาใส่อีเมล์ใหม่!";
            document.getElementById("emailTxt").style.color = "#da2121";
            document.getElementById("btnsaveemail").disabled = true;
            return false;
        }
    }
    xhttp.open("GET",url);
    xhttp.send();
}

function editPassword(){
    document.getElementById("btnsavepassword").style.display = "block";
    document.getElementById("btncancelpassword").style.display = "block";
    document.getElementById("btneditpassword").style.display = "none";
    document.getElementById("change-pw").style.display = "block";
    document.getElementById("m_password").value = "";
    document.getElementById("m_fpassword").value = "";
    document.getElementById("disabledPasswordEditBtn").innerHTML = '<span id="btnsavepassword" style="color:gray">บันทึก</span>';
    document.getElementById("disabledPasswordEditBtn").style.display = "block";
    document.getElementById("passwordTxt").innerHTML = '<span style="color:#DA2121;font-size:10px">* รหัสผ่านอักขระ 8 ตัวขึ้นไป ประกอบไปด้วยตัวอักษร a-z A-Z และ 0-9 อย่างน้อยหนึ่งตัว</span>';
}

function saveEditPassword(){
    document.getElementById("btnsavepassword").style.display = "none";
    document.getElementById("btncancelpassword").style.display = "none";
    document.getElementById("btneditpassword").style.display = "block";
    document.getElementById("change-pw").style.display = "none";
    
    var pw = document.getElementById("m_password").value;
    updatePassword(pw);
}

function cancelEditPassword(){
    member();

    document.getElementById("btnsavepassword").style.display = "none";
    document.getElementById("btncancelpassword").style.display = "none";
    document.getElementById("btneditpassword").style.display = "block";
    document.getElementById("change-pw").style.display = "none";
    document.getElementById("m_password").value = "";
    document.getElementById("m_fpassword").value = "";
    document.getElementById("disabledPasswordEditBtn").innerHTML = '<span id="btnsavepassword" style="color:gray;display:none">บันทึก</span>';
    document.getElementById("passwordTxt").innerHTML = '<span style="color:#DA2121;font-size:10px">* รหัสผ่านอักขระ 8 ตัวขึ้นไป ประกอบไปด้วยตัวอักษร a-z A-Z และ 0-9 อย่างน้อยหนึ่งตัว</span>';
}

function CheckPassword(inputtxt) {
    var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
    if (inputtxt.match(passw)) {
        document.getElementById("passwordTxt").innerHTML = '<span style="color:#3FFF35;font-size:10px">รหัสผ่านปลอดภัย</span>';
        var fpw = document.getElementById("m_fpassword").value;
        if(fpw != ""){
            ConfirmPassword(fpw);
        }else{
            document.getElementById("disabledPasswordEditBtn").innerHTML = '<span id="btnsavepassword" style="color:gray">บันทึก</span>';
            return false;
        }     
    } else {
        document.getElementById("passwordTxt").innerHTML = '<span style="color:#DA2121;font-size:10px">* รหัสผ่านอักขระ 8 ตัวขึ้นไป ประกอบไปด้วยตัวอักษร a-z A-Z และ 0-9 อย่างน้อยหนึ่งตัว</span>';
        document.getElementById("disabledPasswordEditBtn").innerHTML = '<span id="btnsavepassword" style="color:gray">บันทึก</span>';
        return false;
    }
}

function ConfirmPassword(val) {
    var fpw = val;
    var pw = document.getElementById("m_password").value;
    var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
    if (fpw.match(passw)) {
        if (fpw == pw) {
            document.getElementById("passwordTxt").innerHTML = '<span style="color:#3FFF35;font-size:10px">รหัสผ่านปลอดภัย</span>';
            document.getElementById("disabledPasswordEditBtn").innerHTML = '<a href="#" id="btnsavepassword" onclick="saveEditPassword()">บันทึก</a>';
            return true;
        } else {
            document.getElementById("passwordTxt").innerHTML = '<span style="color:#DA2121;font-size:10px">กรุณากรอกรหัสผ่านให้ตรงกัน!</span>';
            document.getElementById("disabledPasswordEditBtn").innerHTML = '<span id="btnsavepassword" style="color:gray">บันทึก</span>';
            return false;
        }
    } else {
        document.getElementById("passwordTxt").innerHTML = '<span style="color:#DA2121;font-size:10px">กรุณากรอกรหัสผ่านให้ตรงกัน!</span>';
        document.getElementById("disabledPasswordEditBtn").innerHTML = '<span id="btnsavepassword" style="color:gray">บันทึก</span>';
        return false;
    }
}

function updatePassword(password){
    //animation loader
    document.getElementById("pageloader").classList.remove("d-none");
    document.getElementById("pageloader").style.animation = "animationfidein 1s";
    document.getElementById("pageloader").style.opacity = "1";
    document.body.style.overflow = "hidden";

    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/update-member-password.php";
    url = url + "?m_password=" + password;
    xhttp.onload = function(){
        setTimeout(() => {
            if (this.response == "0") {
                document.getElementById("pageloader").style.animation = "animationfideout 0.3s";
                document.getElementById("pageloader").style.opacity = "0";
                setTimeout(() => {
                    document.body.style.overflow = "scroll";
                    document.getElementById("pageloader").classList.add("d-none");
                }, 1000);
                member();
            } else {
                alert(this.response);
            }
        }, 3000);
    }
    xhttp.open("GET",url);
    xhttp.send();
}

function confirmChangeProject(){
    var pname = document.getElementById("p_name").value;
    var pkey = document.getElementById("p_key").value;
    var pid = document.getElementById("p_id").value;
    var pnameCheck = PNameCheck(pname);
    if(pnameCheck == true){
        //animation loader
        document.getElementById("pageloader").classList.remove("d-none");
        document.getElementById("pageloader").style.animation = "animationfidein 1s";
        document.getElementById("pageloader").style.opacity = "1";
        document.body.style.overflow = "hidden";

        const xhttp = new XMLHttpRequest();
        var url = "././php-ajax/update-project-name.php";
        url = url + "?p_name=" + pname + "&p_key=" + pkey;
        xhttp.onload = function () {
            setTimeout(() => {
                if (this.response == "0") {
                    document.getElementById("pageloader").style.animation = "animationfideout 0.3s";
                    document.getElementById("pageloader").style.opacity = "0";
                    setTimeout(() => {
                        document.body.style.overflow = "scroll";
                        document.getElementById("pageloader").classList.add("d-none");
                        setSelectedProject(pid);
                        location.replace("dashboard.php");
                    }, 1000);
                } else {
                    alert(this.response);
                }
            }, 3000);
        }
        xhttp.open("GET", url);
        xhttp.send();
    }
}

function PNameCheck(pname){
    //var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[[u0E01-u0E5B]])+$/;
    var pattern = /^[ก-๙a-zA-Z0-9]+$/;
    if (pname.match(pattern)) {
        if (pname != "") {
            document.getElementById("pnameTxt").style.display = "none";
            return true;
        } else {
            document.getElementById("pnameTxt").style.display = "block";
            document.getElementById("pnameTxt").innerHTML = "* กรุณาใส่ชื่อโครงการ";
            return false;
        }
    }else{
        document.getElementById("pnameTxt").style.display = "block";
        document.getElementById("pnameTxt").innerHTML ="* กรุณาเขียนชื่อโครงการด้วยตัวอักษรและตัวเลขเท่านั้น";
        return false;
    }
    
}