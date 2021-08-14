var OxigenNotiSwitchOnload = 0;
var switchval;

function NotiSettingPage() {
    OxigenNotiSwitchOnload = 0;
    startTime();
    mrec_checkreq();
    GetNotification();
}

$(document).on('click', '.number-spinner button', function () {
    var btn = $(this),
        oldValue = btn.closest('.number-spinner').find('input').val().trim(),
        newVal = 0;

    if (btn.attr('data-dir') == 'up') {
        newVal = parseInt(oldValue) + 1;
    } else {
        if (oldValue > 1) {
            newVal = parseInt(oldValue) - 1;
        } else {
            newVal = 1;
        }
    }
    btn.closest('.number-spinner').find('input').val(newVal);
    var InputID = btn.closest('.number-spinner').find('input').attr('id');
    OxigenNotiValueChange(InputID);
});

function GetNotification(){
    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/get-project-data.php";
    xhttp.onload = function () {
        var data = JSON.parse(this.response);
        if (data.status != 0) {
            document.getElementById("OxigenNotiValue").value = data.p_wq_val;
            if (data.p_noti_switch == 0){
                $('#OxigenNotiSwitch').bootstrapToggle('on');
            }else{
                $('#OxigenNotiSwitch').bootstrapToggle('off');
            }
        } else {
            document.getElementById("OxigenNotiValue").value = 0;
        }
    }
    xhttp.open("GET", url);
    xhttp.send();
}

$(function () {
    $('#OxigenNotiSwitch').change(function () {
        if(OxigenNotiSwitchOnload != 0){
            switchval = document.getElementById('OxigenNotiSwitch').checked;
            $('#OxigenNotiSwitchModal').modal('show');            
        }   
        OxigenNotiSwitchOnload++;
    })
})

function SaveSwitchChange(){
    document.getElementById("pageloader").classList.remove("d-none");
    document.getElementById("pageloader").style.animation = "animationfidein 1s";
    document.body.style.overflow = "hidden";
    document.getElementById("pageloader").style.opacity = "1";

    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/save-oxigen-notification-switch.php?switchval=" + switchval;
    xhttp.onload = function () {
        setTimeout(() => {
            if (this.response == "0") {
                document.getElementById("pageloader").style.animation = "animationfideout 0.3s";
                document.getElementById("pageloader").style.opacity = "0";
                setTimeout(() => {
                    document.body.style.overflow = "scroll";
                    document.getElementById("pageloader").classList.add("d-none");
                    location.replace("notification-setting.php");
                }, 1000);
            } else {
                alert(this.response);
            }
        }, 3000);
    }
    xhttp.open("GET", url);
    xhttp.send();
}


$(function () {
    $('#OxigenNotiSwitchModal').on('hidden.bs.modal', function () {
        OxigenNotiSwitchOnload = 0;
        if(switchval == true){
            $('#OxigenNotiSwitch').bootstrapToggle('off');
        }else{
            $('#OxigenNotiSwitch').bootstrapToggle('on');
        }
    });
})

function OxigenNotiValueChange(InputID){
    var ox = document.getElementById(InputID).value;
    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/save-oxigen-notification-value.php?oxval=" + ox;
    xhttp.open("GET", url);
    xhttp.send();
}