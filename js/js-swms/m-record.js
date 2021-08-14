var setstartrow = 0;
var bid = 1;
var recorddata;

function mrecord() {
    setDatePicker();
    
    if (sessionStorage.getItem("rpp") == null){
        sessionStorage.setItem("rpp", 100);
    }
    document.getElementById("rppHead").innerHTML = sessionStorage.getItem("rpp");

    CallRecord(setstartrow);
    startTime();
    mrec_checkreq();
}

function setDatePicker(){
    //Set current date
    let today = new Date().toISOString().substr(0, 10);
    document.getElementById("startDate").value = today.toLocaleString("th-TH", { timeZone: "UTC" });
    document.getElementById("startDate").max = new Date().toISOString().slice(0, -14);
    document.getElementById("startDate").min = moment().subtract(90, "days").format('YYYY-MM-DD');

    let endDate = moment().subtract(90, "days").format('YYYY-MM-DD');
    document.getElementById("endDate").value = endDate.toLocaleString("th-TH", { timeZone: "UTC" });
    document.getElementById("endDate").max = new Date().toISOString().slice(0, -14);
    document.getElementById("endDate").min = moment().subtract(90, "days").format('YYYY-MM-DD');

    calDateDiff();
}

function calDateDiff(){
    let startDate = document.getElementById("startDate").value;
    let endDate = document.getElementById("endDate").value;
    var date1 = new Date(endDate);
    var date2 = new Date(startDate);
    //var timeDiff = Math.abs(date1.getTime() - date2.getTime());
    var diffDays = Math.ceil(parseInt((date2 - date1) / (24 * 3600 * 1000)));
    document.getElementById("dateDiff").innerHTML = diffDays;
}

function test(){
    alert("a");
}

function CallRecord(startrow){
    calDateDiff();

    var rowperpage = sessionStorage.getItem("rpp");
    if (startrow == 0){
        setstartrow = 0;
        bid = 1;
    }

    let startDate = document.getElementById("startDate").value;
    let endDate = document.getElementById("endDate").value;
    var date1 = new Date(endDate).toISOString().substr(0, 10);
    var date2 = new Date(startDate).toISOString().substr(0, 10);

    document.getElementById("startDate").min = date1;
    document.getElementById("endDate").max = date2;

    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/get-measurement.php";
    url = url + "?sdate=" + date1 + "&edate=" + date2;
    xhttp.onload = function () {
        recorddata = JSON.parse(this.response);
        if(recorddata != 0){
            drawTable(recorddata, startrow, rowperpage);
        } else {
            $("#tbody").empty();
            var row = $("<tr />");
            $("#measurementrecord").append(row);
            row.append($("<td colspan='13' style='font-size: smaller'>ไม่พบข้อมูล</td>"));
        }
        var pagenumber = 1;
        var pagecount = Math.ceil(recorddata.length / rowperpage);
        var showBtn = "";
        for(var i = 0; i < pagecount; i++){
            if (pagenumber == bid) {
                showBtn += '<button class="btn btn-sm btn-page btn-clicked m-1 disabled" value="' + pagenumber + '" id="pagebtn' + pagenumber + '" onclick="drawTableNew(this,' + setstartrow + ')">' + pagenumber + '</button>';
            } else {
                showBtn += '<button class="btn btn-sm btn-page m-1" value="' + pagenumber + '" id="pagebtn' + pagenumber + '" onclick="drawTableNew(this,' + setstartrow + ')">' + pagenumber + '</button>';
            }
            pagenumber++;
            setstartrow = parseInt(setstartrow) + parseInt(rowperpage);
        }
        document.getElementById('pageBtn').innerHTML = showBtn;
    }
    xhttp.open("GET", url);
    xhttp.send();
}

function drawTable(data, start, rowperpage) {
    $("#tbody").empty();
    var colno = start + 1;
    for (var i = start; i < parseInt(start) + parseInt(rowperpage); i++) {
        if (recorddata[i] != null) {
            drawRow(data[i], colno);
            colno++;
        }
    }
}

function drawTableNew(btn, start) {
    var rowperpage = sessionStorage.getItem("rpp");
    $("#tbody").empty();
    var colno = start + 1;
    removeBtnClass(btn);
    for (var i = start; i < parseInt(start) + parseInt(rowperpage); i++) {
        if (recorddata[i] != null){
            drawRow(recorddata[i], colno);
            colno++;
        }        
    }
}

function drawRow(rowData, i) {
    var row = $("<tr />");
    $("#measurementrecord").append(row);
    row.append($("<td>" + i + "</td>"));
    row.append($("<td>" + rowData.m_project_id + "</td>"));
    row.append($("<td>" + rowData.m_key + "</td>"));
    row.append($("<td>" + rowData.m_name + "</td>"));
    row.append($("<td>" + rowData.m_date + "</td>"));
    row.append($("<td>" + rowData.m_time + "</td>"));
    row.append($("<td>" + rowData.m_oxigen + "</td>"));
    row.append($("<td>" + rowData.m_water_temp + "</td>"));
    row.append($("<td>" + rowData.m_ph + "</td>"));
    row.append($("<td>" + rowData.m_salinity + "</td>"));
    row.append($("<td>" + rowData.m_conductivity + "</td>"));
    row.append($("<td>" + rowData.m_air_temp + "</td>"));
    row.append($("<td>" + rowData.m_humidity + "</td>"));
}

function removeBtnClass(btn){
    var selectedBtn = $(btn).attr("id");

    var searchEles = document.getElementById("pageBtn").children;
    for (var i = 0; i < searchEles.length; i++) {
        if (searchEles[i].id == selectedBtn) {
            bid = $(btn).attr("value");
            document.getElementById(selectedBtn).classList.add("disabled");
            document.getElementById(selectedBtn).classList.add("btn-clicked");
        }else{
            document.getElementById(searchEles[i].id).classList.remove("disabled");
            document.getElementById(searchEles[i].id).classList.remove("btn-clicked");
        }
    }
}

var HideBtnColorCode = "#6495ED";
var btn0click = 1;
var btn1click = 1;
var btn2click = 1;
var btn3click = 1;
var btn4click = 1;
var btn5click = 1;
var btn6click = 1;
var btn7click = 1;
var btn8click = 1;
var btn9click = 1;
var btn10click = 1;
var btn11click = 1;
var btn12click = 1;
var btn13click = 1;

function HideColumn(btnId,col){
    element = $(btnId).attr("id");
    var colLength = document.getElementById('measurementrecord').rows[0].cells.length;

    if(col == 0){
        if(btn0click == 1){        
            for (var i = 1; i <= colLength; i++) {
                $('td:nth-child(' + i + '),th:nth-child(' + i + ')').hide();
            }
            
            Array.from(document.getElementsByClassName('btn-hide-column')).forEach(elem => {
                elem.style.backgroundColor = "transparent";
            });

            btn0click = 2;
            btn1click = 2;
            btn2click = 2;
            btn3click = 2;
            btn4click = 2;
            btn5click = 2;
            btn6click = 2;
            btn7click = 2;
            btn8click = 2;
            btn9click = 2;
            btn10click = 2;
            btn11click = 2;
            btn12click = 2;
            btn13click = 2;
        }else{
            for (var i = 1; i <= colLength; i++) {
                $('td:nth-child(' + i + '),th:nth-child(' + i + ')').show();
            }

            Array.from(document.getElementsByClassName('btn-hide-column')).forEach(elem => {
                elem.style.backgroundColor = HideBtnColorCode;
            });

            btn0click = 1;
            btn1click = 1;
            btn2click = 1;
            btn3click = 1;
            btn4click = 1;
            btn5click = 1;
            btn6click = 1;
            btn7click = 1;
            btn8click = 1;
            btn9click = 1;
            btn10click = 1;
            btn11click = 1;
            btn12click = 1;
            btn13click = 1;
        }        
    }else{
        switch (col) {
            case 1:
                btn1click = AdjustColumn(element, col, btn1click);
                break;
            case 2:
                btn2click = AdjustColumn(element, col, btn2click);
                break;
            case 3:
                btn3click = AdjustColumn(element, col, btn3click);
                break;
            case 4:
                btn4click = AdjustColumn(element, col, btn4click);
                break;
            case 5:
                btn5click = AdjustColumn(element, col, btn5click);
                break;
            case 6:
                btn6click = AdjustColumn(element, col, btn6click);
                break;
            case 7:
                btn7click = AdjustColumn(element, col, btn7click);
                break;
            case 8:
                btn8click = AdjustColumn(element, col, btn8click);
                break;
            case 9:
                btn9click = AdjustColumn(element, col, btn9click);
                break;
            case 10:
                btn10click = AdjustColumn(element, col, btn10click);
                break;
            case 11:
                btn11click = AdjustColumn(element, col, btn11click);
                break;
            case 12:
                btn12click = AdjustColumn(element, col, btn12click);
                break;
            case 13:
                btn13click = AdjustColumn(element, col, btn13click);
                break;
        }
    }
}

function AdjustColumn(element,col,btn){
    if (btn == 1) {
        $('td:nth-child(' + col + '),th:nth-child(' + col + ')').hide();
        document.getElementById(element).style.backgroundColor = "transparent";
        btn = 2;
    } else {
        $('td:nth-child(' + col + '),th:nth-child(' + col + ')').show();
        document.getElementById(element).style.backgroundColor = HideBtnColorCode;
        btn = 1;
    }
    return btn;
}

function ExportData() {
    let startDate = document.getElementById("startDate").value;
    let endDate = document.getElementById("endDate").value;
    var date1 = new Date(endDate).toISOString().substr(0, 10);
    var date2 = new Date(startDate).toISOString().substr(0, 10);

    filename = 'ข้อมูลการวัดค่าคุณภาพน้ำ โครงการ';

    const xhttp = new XMLHttpRequest();
    var url = "././php-ajax/export-measurement.php";
    url = url + "?sdate=" + date1 + "&edate=" + date2;
    xhttp.onload = function () {        
        if(this.response != 0){
            var data = JSON.parse(this.response);
            filename = filename + " " + data[0]["ชื่อโครงการ"] + ".xlsx";
            var ws = XLSX.utils.json_to_sheet(data);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "People");
            XLSX.writeFile(wb, filename);
        }else{
            $('#nodataExportModal').modal('show');
        }
        
    }
    xhttp.open("GET", url);
    xhttp.send();    
}

//Select row per page
function selectRPP(rpp){
    document.getElementById("rppHead").innerHTML = rpp;
    rowperpage = rpp;
    sessionStorage.setItem("rpp", rpp);
    CallRecord(0);
    bid = 1;
}