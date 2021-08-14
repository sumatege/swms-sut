<?php
session_start();

if (!isset($_SESSION["m_id"])) {
    header("location:index.php");
}

//echo $_SESSION["selectedProjectKey"] . " " . $_SESSION["selectedProjectName"];
if (isset($_SESSION["selectedProjectKey"])) {
    echo '<input type="texet" style="display:none;" id="session_p_key" value="' . $_SESSION["selectedProjectKey"] . '">';
    echo '<input type="texet" style="display:none;" id="session_p_id" value="' . $_SESSION["selectedProjectId"] . '">';
    echo '<input type="texet" style="display:none;" id="session_p_name" value="' . $_SESSION["selectedProjectName"] . '">';
} else {
    echo '<input type="texet" style="display:none;" id="session_p_key" value="">';
    echo '<input type="texet" style="display:none;" id="session_p_id" value="">';
    echo '<input type="texet" style="display:none;" id="session_p_name" value="">';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SWMS | Smart Water Monitoring System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.1/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>


    <link rel="stylesheet" type="text/css" href="css/stylesheet-dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/stylesheet-m-record.css">

    <script src="js/js-swms/dashboard.js" type="text/javascript"></script>
    <script src="js/js-swms/m-record.js" type="text/javascript"></script>
</head>

<body onload="dropdownList(), member(), mrecord()">
    <div class="d-flex justify-content-center pageloader d-none" id="pageloader">
        <div class="loadingio-spinner-ellipsis-zx4kx9r7byb">
            <div class="ldio-2c6q87foqex">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-sm navbar-light shadow-sm d-none d-md-block">
        <div class="container container-fluid">
            <div class="col-md nav-logo">
                <div class="row">
                    <a class="navbar-brand" href="dashboard.php">
                        <img class="img-responsive d-none d-md-block" src="images/content/swms-logo.png" style="height:100px; margin-top: 10px;">
                        <img class="img-responsive d-md-none" src="images/content/swms-logo.png" style="height:80px">
                    </a>
                </div>
            </div>
            <div class="col-md nav-content">
                <div class="row border-bottom border-secondary">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span id="dropdownHead"><?php if (isset($_SESSION["selectedProjectId"])) {
                                                                echo $_SESSION["selectedProjectName"];
                                                            } else {
                                                                echo "ไม่พบข้อมูล";
                                                            } ?></span>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="projectlist"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-icon" href="" data-toggle="modal" data-target="#addProjectModal"><i class="bi bi-plus-square nav-icon"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-icon" href="" data-toggle="modal" data-target="#deleteProjectModal" id="deleteBtnClass"><i class="bi bi-dash-square nav-icon" id="deleteBtn"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-icon" href="" data-toggle="modal" data-target="#changeProjectNameModal" id="settingProjectNameClass"><i class="bi bi-gear nav-icon" id="settingProjectNameBtn"></i></a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link disabled user-data-icon" href=""><i class="bi bi-person-fill"></i></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled user-data-name" id="user-data"></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link account-edit nav-icon" href="" data-toggle="modal" data-target="#accountSettingModal"><i class="bi bi-pencil-fill"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-icon" href="" data-toggle="modal" data-target="#logoutModal"><i class="bi bi-box-arrow-right nav-icon"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.php">การวัดค่า</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="m-record.php">ประวัติการวัดค่า</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="notification-setting.php">ตั้งค่า/การแจ้งเตือน</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="row head-content shadow-sm border border-4 border-bottom-0 border-white justify-content-between px-5">
        <div class="col-auto"><i class="bi bi-droplet-fill"></i> <span id="projectNameHead"><?php if (isset($_SESSION["selectedProjectId"])) {
                                                                                                echo $_SESSION["selectedProjectName"];
                                                                                            } else {
                                                                                                echo "ไม่พบข้อมูล";
                                                                                            } ?></span> </div>
        <div class="col-auto"><i class="bi bi-calendar2-week-fill"></i> <span id="dateTxt"></span></div>
        <div class="col-auto"><i class="bi bi-alarm-fill"></i> <span id="clock"></span></div>
        <div class="col-auto" id="status-blink-txt"><i class="bi bi-circle-fill status-blink" id="statusblink"></i>
            สถานะการส่งค่า [ออฟไลน์]</div>
    </div>

    <!-- Body Content -->
    <div class="row body-content record shadow-sm border border-4 border-white d-flex justify-content-center" id="bodyContent">
        <div class="container container-fluid px-2 table-filter">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-auto d-flex align-items-center">
                    <small class="me-2 text-nowrap">จำนวนแถว</small>
                    <div class="dropdown">
                        <button class="dropdown-row btn btn-sm dropdown-toggle" type="button" id="rppHead" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            100
                        </button>
                        <div class="dropdown-menu dropdown-menu-rpp rounded" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item dropdown-item-rpp" onclick="selectRPP(100)">100</a>
                            <a class="dropdown-item dropdown-item-rpp" onclick="selectRPP(75)">75</a>
                            <a class="dropdown-item dropdown-item-rpp" onclick="selectRPP(50)">50</a>
                            <a class="dropdown-item dropdown-item-rpp" onclick="selectRPP(25)">25</a>
                            <a class="dropdown-item dropdown-item-rpp" onclick="selectRPP(3)">3</a>
                            <a class="dropdown-item dropdown-item-rpp" onclick="selectRPP(1)">1</a>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <small class="me-2">แสดงข้อมูลย้อนหลัง <span id="dateDiff">90</span> วัน ตั้งแต่วันที่</small>
                    <input class="form-control-sm datepicker" type="date" id="startDate" onchange="CallRecord(0)" required />
                    <small class=" me-2">ถึง</small>
                    <input class="form-control-sm datepicker" type="date" id="endDate" onchange="CallRecord(0)" required />
                    <button class="btn btn-info btn-sm btn-export" onclick="ExportData()"><i class="bi bi-download"></i> Export</button>
                </div>
            </div>
        </div>
        <div class="row container-fluid" id="container-hide-col">
            <div class="div-hide-col m-1">
                <button id="btnHideAll" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,0)">ทั้งหมด</button>
                <button id="btnHide1" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,1)">#</button>
                <button id="btnHide2" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,2)">รหัสโปรเจ็ค</button>
                <button id="btnHide3" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,3)">รหัสอุปกรณ์</button>
                <button id="btnHide4" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,4)">ชื่อโครงการ</button>
                <button id="btnHide5" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,5)">วันที่เก็บข้อมูล</button>
                <button id="btnHide6" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,6)">เวลาที่เก็บข้อมูล</button>
                <button id="btnHide7" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,7)">ปริมาณออกซิเจน</button>
                <button id="btnHide8" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,8)">อุณหภูมิน้ำ</button>
                <button id="btnHide9" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,9)">ค่า pH</button>
                <button id="btnHide10" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,10)">ความเค็มของน้ำ</button>
                <button id="btnHide11" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,11)">การนำไฟฟ้า</button>
                <button id="btnHide12" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,12)">อุณหภูมิอากาศ</button>
                <button id="btnHide13" class="btn btn-sm rounded-pill btn-hide-column shadow-sm" onclick="HideColumn(this,13)">ความชื้นสัมพัทธ์</button>
            </div>
        </div>
        <div class="row table-responsive">
            <table class="table table-condensed table-hover table-sm table-borderless shadow-sm" id="measurementrecord">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>รหัสโปรเจ็ค</th>
                        <th>รหัสอุปกรณ์</th>
                        <th>ชื่อโครงการ</th>
                        <th>วันที่เก็บข้อมูล</th>
                        <th>เวลาที่เก็บข้อมูล</th>
                        <th>ปริมาณออกซิเจน</th>
                        <th>อุณหภูมิน้ำ</th>
                        <th>ค่า pH</th>
                        <th>ความเค็มของน้ำ</th>
                        <th>การนำไฟฟ้า</th>
                        <th>อุณหภูมิอากาศ</th>
                        <th>ความชื้นสัมพัทธ์</th>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
            <div class="container container-fluid px-2">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="text-center" id="pageBtn"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">คุณต้องการออกจากระบบใช่หรือไม่</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <button type="button" class="btn btn-danger btn-lg m-3" onclick="logout()">ออกจากระบบ</button>
                    <button type="button" class="btn btn-secondary btn-lg m-3" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <!-- No data modal -->
    <div class="modal fade" id="nodataModal" tabindex="100" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">การแจ้งเตือน</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <center>
                        <h5 style="color:red;">ไม่พบข้อมูล!<br />กรุณาเพิ่มอุปกรณ์เพื่อแสดงค่า</h5>
                        <button type="button" class="btn btn-warning m-3" data-bs-dismiss="modal">ปิด</button>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Oxigen modal -->
    <div class="modal fade" id="LowOxigenModal" tabindex="100" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">การแจ้งเตือน</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <center>
                        <h5 style="color:red;">ระดับออกซิเจนในน้ำต่ำกว่า <span id="oxmodaltxt"></span> mg/L</h5>
                        <button type="button" class="btn btn-warning m-3" data-bs-dismiss="modal">ปิด</button>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <!-- Request got problem modal -->
    <div class="modal fade" id="requestFailedModal" tabindex="100" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">การแจ้งเตือน</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <center>
                        <h5 style="color:red;">สถานะการเชื่อมต่อออฟไลน์!<br />กรุณาตรวจสอบอุปกรณ์</h5>
                        <button type="button" class="btn btn-warning m-3" data-bs-dismiss="modal">ปิด</button>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <!-- Project adding modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มอุปกรณ์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>รหัสอุปกรณ์ (Equipment Key)</label>
                            <input name="add_pkey" id="add_pkey" type="text" placeholder="รหัสอุปกรณ์" class="form-control" oninvalid="this.setCustomValidity('โปรดกรอกรหัสอุปกรณ์ 10 หลัก')" required />
                        </div>
                        <div class="form-group">
                            <label>ชื่อโครงการ (Project Name)</label>
                            <input name="add_pname" id="add_pname" type="text" placeholder="ชื่อโครงการ" class="form-control" pattern="[ก-๙a-zA-Z0-9-]" oninvalid="this.setCustomValidity('กรุณาเขียนชื่อด้วยตัวอักษรและตัวเลขเท่านั้น')" required />
                        </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-warning" onclick="addNewProject(add_pkey.value,add_pname.value)">บันทึก</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Project already added modal -->
    <div class="modal fade" id="projectexistsModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">การแจ้งเตือน</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <center>
                        <div>
                            <span style="color:red;">รหัสอุปกรณ์นี้ถูกเพิ่มแล้วโดยผู้ใช้ท่านอื่น!<br />ไม่สามารถใช้ซ้ำได้<br />กรุณาตรวจสอบรหัสอุปกรณ์อีกครั้ง</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-warning m-3" data-dismiss="modal">ปิด</button>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <!-- Project key not exist modal -->
    <div class="modal fade" id="projectnotexistsModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">การแจ้งเตือน</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <center>
                        <div>
                            <span style="color:red;">รหัสอุปกรณ์นี้ไม่ถูกต้อง!<br />กรุณาตรวจสอบรหัสอุปกรณ์อีกครั้ง</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-warning m-3" data-dismiss="modal">ปิด</button>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <!-- Project adding comfirmation modal -->
    <div class="modal fade" id="confirmProjectModal" tabindex="2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ยืนยันการเพิ่มรหัสอุปกรณ์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body p-5">
                    <div class="m-3">
                        <center>
                            รหัสอุปกรณ์: <span id="add_pj_equipment_id" style="color:darkblue;text-decoration: underline;"></span><br />
                            ชื่อโปรเจ็ค: <span id="add_pj_name"></span>
                            <span id="add_pj_owner" class="d-none"><?php echo $_SESSION["id"]; ?></span>
                        </center>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-warning" onclick="confirmAddProject()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Change project name modal -->
    <div class="modal fade" id="changeProjectNameModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ข้อมูลทั่วไป</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="sr-only m-2 text-nowrap">รหัสอุปกรณ์</label>
                                <input type="text" class="form-control m-2" id="p_key" disabled>
                                <input type="text" class="form-control m-2" id="p_id" style="display:none" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="sr-only m-2 text-nowrap">ชื่อโครงการ</label>
                                <input type="text" class="form-control m-2" id="p_name" oninvalid="this.setCustomValidity('* กรุณาเขียนชื่อโครงการด้วยตัวอักษรและตัวเลขเท่านั้น')" placeholder="ชื่อโครงการ" onkeyup="PNameCheck(this.value)" required>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="invalidTxt m-2 mt-0" id="pnameTxt">* กรุณาใส่ชื่อโครงการ</div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-warning" onclick="confirmChangeProject()">บันทึก</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Project delete comfirmation modal -->
    <div class="modal fade" id="deleteProjectModal" tabindex="2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบรหัสอุปกรณ์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body p-5">
                    <div class="m-3">
                        <center>
                            รหัสอุปกรณ์: <span id="delete_pj_equipment_key" style="color:darkblue;text-decoration: underline;"></span><br />
                            ชื่อโปรเจ็ค: <span id="delete_pj_name"></span>
                            <span id="delete_pj_id" class="d-none"></span>
                        </center>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-warning" onclick="confirmDeleteProject()">ตกลง</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Account setting modal -->
    <div class="modal fade" id="accountSettingModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered settingModal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">การตั้งค่า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="sr-only m-2 text-nowrap">ชื่อ - นามสกุล</label>
                                <div class="d-flex align-items-end">
                                    <a href="#" class="sr-only text-nowrap" id="btneditname" onclick="editName()">แก้ไข</a>
                                    <div class="sr-only m-2 text-nowrap" id="disabledNameEditBtn"><a href="#" style="display:none;" id="btnsavename" onclick="saveEditName()">บันทึก</a></div>
                                    <a href="#" class="sr-only m-2 text-nowrap" style="display:none;" id="btncancelname" onclick="cancelEditName()">ยกเลิก</a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-0">
                                <input type="text" class="form-control m-2" id="m_name" placeholder="ชื่อ" onkeyup="checkNameNull()" required disabled>
                                <input type="text" class="form-control m-2" id="m_sirname" placeholder="นามสกุล" onkeyup="checkNameNull()" required disabled>
                            </div>
                            <div>
                                <div class="invalidTxt ms-2" id="nameTxt"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="sr-only m-2">อีเมล์</label>
                                <div class="d-flex align-items-end">
                                    <a href="#" class="sr-only text-nowrap" id="btneditemail" onclick="editEmail()">แก้ไข</a>
                                    <div class="sr-only m-2 text-nowrap" id="disabledEmailEditBtn"><a href="#" style="display:none;" id="btnsaveemail" onclick="saveEditEmail()">บันทึก</a></div>
                                    <a href="#" class="sr-only m-2 text-nowrap" style="display:none;" id="btncancelemail" onclick="cancelEditEmail()">ยกเลิก</a>
                                </div>
                            </div>
                            <div class="d-flex mt-0">
                                <input type="email" class="form-control m-2" id="m_email" placeholder="example@example.com" onkeyup="EmailCheck(this.value)" required disabled>
                                <input type="email" class="d-none" id="m_hiddenemail">
                            </div>
                            <div>
                                <div class="invalidTxt ms-2" id="emailTxt"></div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label class="sr-only m-2">รหัสผ่าน</label>
                            <div class="d-flex align-items-end">
                                <a href="#" class="sr-only text-nowrap" id="btneditpassword" onclick="editPassword()">เปลี่ยนรหัสผ่าน</a>
                                <div class="sr-only m-2 text-nowrap" id="disabledPasswordEditBtn"><a href="#" style="display:none;" id="btnsavepassword" onclick="saveEditPassword()">บันทึก</a></div>
                                <a href="#" class="sr-only m-2 text-nowrap" style="display:none;" id="btncancelpassword" onclick="cancelEditPassword()">ยกเลิก</a>
                            </div>
                        </div>
                        <div class="form-group" id="change-pw">
                            <div class="d-flex justify-content-between align-items-center px-5 py-1">
                                <label class="sr-only text-nowrap m-2">รหัสผ่านใหม่</label>
                                <input type="password" class="form-control" placeholder="รหัสผ่านใหม่" name="m_password" id="m_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeyup="CheckPassword(this.value)" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center px-5 py-1">
                                <label class="sr-only text-nowrap m-2">ยืนยันรหัสผ่านใหม่</label>
                                <input type="password" class="form-control" placeholder="ยืนยันรหัสผ่านใหม่" name="m_fpassword" id="m_fpassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeyup="ConfirmPassword(this.value)" required>
                            </div>
                            <div class="d-flex justify-content-end align-items-center px-5 py-1">
                                <div class="pwTXT ms-2" id="passwordTxt">* รหัสผ่านอักขระ 8 ตัวขึ้นไป ประกอบไปด้วยตัวอักษร a-z A-Z และ 0-9 อย่างน้อยหนึ่งตัว</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>