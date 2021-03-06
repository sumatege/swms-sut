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


    <link rel="stylesheet" type="text/css" href="css/stylesheet-dashboard.css">

    <script src="js/js-swms/dashboard.js" type="text/javascript"></script>
</head>

<body onload="startFunction(), dropdownList(), member();">
    <audio id="myAudio" controls style="display:none" preload="auto">
        <source src="sounds/ping.wav" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

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
                                                                echo "?????????????????????????????????";
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
                            <li class="nav-item active">
                                <a class="nav-link" href="dashboard.php">???????????????????????????</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="m-record.php">????????????????????????????????????????????????</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="notification-setting.php">?????????????????????/????????????????????????????????????</a>
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
                                                                                                echo "?????????????????????????????????";
                                                                                            } ?></span> </div>
        <div class="col-auto"><i class="bi bi-calendar2-week-fill"></i> <span id="dateTxt"></span></div>
        <div class="col-auto"><i class="bi bi-alarm-fill"></i> <span id="clock"></span></div>
        <div class="col-auto" id="status-blink-txt"><i class="bi bi-circle-fill status-blink" id="statusblink"></i>
            ?????????????????????????????????????????? [?????????????????????]</div>
    </div>

    <div class="row body-content shadow-sm border border-4 border-white d-flex justify-content-center" id="bodyContent">
        <div class="row container-fluid main-status rounded shadow-sm">
            <div class="col-md-6 main-status-1 border border-2 border-white">
                <div class="p-1">??????????????????????????????????????????</div>
                <div id="water-quality" class="m-3">
                    <div class="spinner-border m-3" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <div id="waterQTxt"></div>
            </div>
            <!-- 
        <div class="col-md-4 main-status-2 border border-bottom-0 border-top-0 border-3">
            <div>????????????????????????</div>
            <div><i class="bi bi-circle-fill abnormal-measure-status" id="abnormal-measure-status"></i></div>
        </div>
        -->
            <div class="col-md-6 main-status-3 border border-2 border-white">
                <div class="p-1">???????????????????????????????????????????????????</div>
                <div class="rotating m-3" id="aerotor">
                    <div class="spinner-border m-3" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <div class="p-1" id="aerotorTxt"></div>
            </div>
        </div>
        <div class="row container-fluid second-status justify-content-center">
            <div class="row measure-item rounded border-bottom border-4 border-danger">
                <div class="row measure-item-head">
                    <div class="col d-inline text-nowrap text-start">??????????????????????????????????????????</div>
                    <div class="col d-inline text-end">[mg/L]</div>
                </div>
                <div class="row measure-item-content">
                    <div class="col-sm-12 p-3" id="firstVal">
                        <div class="spinner-border" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row measure-item rounded border-bottom border-4 border-danger">
                <div class="row measure-item-head">
                    <div class="col d-inline text-nowrap text-start">?????????????????????????????????</div>
                    <div class="col d-inline text-end">[&#730;C]</div>
                </div>
                <div class="row measure-item-content">
                    <div class="col-sm-12 p-3" id="secondVal">
                        <div class="spinner-border" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row measure-item rounded border-bottom border-4 border-danger">
                <div class="row measure-item-head">
                    <div class="col d-inline text-nowrap text-start">????????? pH</div>
                </div>
                <div class="row measure-item-content">
                    <div class="col-sm-12 p-3" id="thirdVal">
                        <div class="spinner-border" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row measure-item rounded border-bottom border-4 border-danger">
                <div class="row measure-item-head">
                    <div class="col d-inline text-nowrap text-start">??????????????????????????????????????????</div>
                    <div class="col d-inline text-end">[ppt]</div>
                </div>
                <div class="row measure-item-content">
                    <div class="col-sm-12 p-3" id="fourthVal">
                        <div class="spinner-border" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row measure-item rounded border-bottom border-4 border-danger">
                <div class="row measure-item-head">
                    <div class="col d-inline text-nowrap text-start">??????????????????????????????</div>
                    <div class="col d-inline text-end">[??s/cm]</div>
                </div>
                <div class="row measure-item-content">
                    <div class="col-sm-12 p-3" id="fifthVal">
                        <div class="spinner-border" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row measure-item rounded border-bottom border-4 border-info">
                <div class="row measure-item-head">
                    <div class="col d-inline text-nowrap text-start">???????????????????????????????????????</div>
                    <div class="col d-inline text-end">[&#730;C]</div>
                </div>
                <div class="row measure-item-content">
                    <div class="col-sm-12 p-3" id="sixthVal">
                        <div class="spinner-border" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row measure-item rounded border-bottom border-4 border-info">
                <div class="row measure-item-head">
                    <div class="col d-inline text-nowrap text-start">????????????????????????????????????????????????</div>
                    <div class="col d-inline text-end">[%]</div>
                </div>
                <div class="row measure-item-content">
                    <div class="col-sm-12 p-3" id="seventhVal">
                        <div class="spinner-border" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">??????????????????????????????????????????????????????????????????????????????????????????</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <button type="button" class="btn btn-danger btn-lg m-3" onclick="logout()">??????????????????????????????</button>
                    <button type="button" class="btn btn-secondary btn-lg m-3" data-dismiss="modal">??????????????????</button>
                </div>
            </div>
        </div>
    </div>

    <!-- No data modal -->
    <div class="modal fade" id="nodataModal" tabindex="100" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">????????????????????????????????????</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <center>
                        <h5 style="color:red;">?????????????????????????????????!<br />???????????????????????????????????????????????????????????????????????????????????????</h5>
                        <button type="button" class="btn btn-warning m-3" data-bs-dismiss="modal">?????????</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">????????????????????????????????????</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <center>
                        <h5 style="color:red;">??????????????????????????????????????????????????????????????????????????? <span id="oxmodaltxt"></span> mg/L</h5>
                        <button type="button" class="btn btn-warning m-3" data-bs-dismiss="modal">?????????</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">????????????????????????????????????</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <center>
                        <h5 style="color:red;">????????????????????????????????????????????????????????????????????????!<br />?????????????????????????????????????????????????????????</h5>
                        <button type="button" class="btn btn-warning m-3" data-bs-dismiss="modal">?????????</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">????????????????????????????????????</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>????????????????????????????????? (Equipment Key)</label>
                            <input name="add_pkey" id="add_pkey" type="text" placeholder="?????????????????????????????????" class="form-control" oninvalid="this.setCustomValidity('????????????????????????????????????????????????????????? 10 ????????????')" required />
                        </div>
                        <div class="form-group">
                            <label>????????????????????????????????? (Project Name)</label>
                            <input name="add_pname" id="add_pname" type="text" placeholder="?????????????????????????????????" class="form-control" pattern="[???-???a-zA-Z0-9-]" oninvalid="this.setCustomValidity('?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????')" required />
                        </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-warning" onclick="addNewProject(add_pkey.value,add_pname.value)">??????????????????</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">??????????????????</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">????????????????????????????????????</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <center>
                        <div>
                            <span style="color:red;">?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????!<br />??????????????????????????????????????????????????????<br />?????????????????????????????????????????????????????????????????????????????????????????????</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-warning m-3" data-dismiss="modal">?????????</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">????????????????????????????????????</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center p-5">
                    <center>
                        <div>
                            <span style="color:red;">????????????????????????????????????????????????????????????????????????!<br />?????????????????????????????????????????????????????????????????????????????????????????????</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-warning m-3" data-dismiss="modal">?????????</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">???????????????????????????????????????????????????????????????????????????</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body p-5">
                    <div class="m-3">
                        <center>
                            ?????????????????????????????????: <span id="add_pj_equipment_id" style="color:darkblue;text-decoration: underline;"></span><br />
                            ?????????????????????????????????: <span id="add_pj_name"></span>
                            <span id="add_pj_owner" class="d-none"><?php echo $_SESSION["id"]; ?></span>
                        </center>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-warning" onclick="confirmAddProject()">??????????????????</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">??????????????????</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Change project name modal -->
    <div class="modal fade" id="changeProjectNameModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">????????????????????????????????????</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="sr-only m-2 text-nowrap">?????????????????????????????????</label>
                                <input type="text" class="form-control m-2" id="p_key" disabled>
                                <input type="text" class="form-control m-2" id="p_id" style="display:none" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="sr-only m-2 text-nowrap">?????????????????????????????????</label>
                                <input type="text" class="form-control m-2" id="p_name" oninvalid="this.setCustomValidity('* ??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????')" placeholder="?????????????????????????????????" onkeyup="PNameCheck(this.value)" required>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="invalidTxt m-2 mt-0" id="pnameTxt">* ?????????????????????????????????????????????????????????</div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-warning" onclick="confirmChangeProject()">??????????????????</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">??????????????????</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">??????????????????????????????????????????????????????????????????</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body p-5">
                    <div class="m-3">
                        <center>
                            ?????????????????????????????????: <span id="delete_pj_equipment_key" style="color:darkblue;text-decoration: underline;"></span><br />
                            ?????????????????????????????????: <span id="delete_pj_name"></span>
                            <span id="delete_pj_id" class="d-none"></span>
                        </center>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-warning" onclick="confirmDeleteProject()">????????????</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">??????????????????</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Account setting modal -->
    <div class="modal fade" id="accountSettingModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered settingModal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">??????????????????????????????</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="sr-only m-2 text-nowrap">???????????? - ?????????????????????</label>
                                <div class="d-flex align-items-end">
                                    <a href="#" class="sr-only text-nowrap" id="btneditname" onclick="editName()">???????????????</a>
                                    <div class="sr-only m-2 text-nowrap" id="disabledNameEditBtn"><a href="#" style="display:none;" id="btnsavename" onclick="saveEditName()">??????????????????</a></div>
                                    <a href="#" class="sr-only m-2 text-nowrap" style="display:none;" id="btncancelname" onclick="cancelEditName()">??????????????????</a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-0">
                                <input type="text" class="form-control m-2" id="m_name" placeholder="????????????" onkeyup="checkNameNull()" required disabled>
                                <input type="text" class="form-control m-2" id="m_sirname" placeholder="?????????????????????" onkeyup="checkNameNull()" required disabled>
                            </div>
                            <div>
                                <div class="invalidTxt ms-2" id="nameTxt"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="sr-only m-2">??????????????????</label>
                                <div class="d-flex align-items-end">
                                    <a href="#" class="sr-only text-nowrap" id="btneditemail" onclick="editEmail()">???????????????</a>
                                    <div class="sr-only m-2 text-nowrap" id="disabledEmailEditBtn"><a href="#" style="display:none;" id="btnsaveemail" onclick="saveEditEmail()">??????????????????</a></div>
                                    <a href="#" class="sr-only m-2 text-nowrap" style="display:none;" id="btncancelemail" onclick="cancelEditEmail()">??????????????????</a>
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
                            <label class="sr-only m-2">????????????????????????</label>
                            <div class="d-flex align-items-end">
                                <a href="#" class="sr-only text-nowrap" id="btneditpassword" onclick="editPassword()">?????????????????????????????????????????????</a>
                                <div class="sr-only m-2 text-nowrap" id="disabledPasswordEditBtn"><a href="#" style="display:none;" id="btnsavepassword" onclick="saveEditPassword()">??????????????????</a></div>
                                <a href="#" class="sr-only m-2 text-nowrap" style="display:none;" id="btncancelpassword" onclick="cancelEditPassword()">??????????????????</a>
                            </div>
                        </div>
                        <div class="form-group" id="change-pw">
                            <div class="d-flex justify-content-between align-items-center px-5 py-1">
                                <label class="sr-only text-nowrap m-2">????????????????????????????????????</label>
                                <input type="password" class="form-control" placeholder="????????????????????????????????????" name="m_password" id="m_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeyup="CheckPassword(this.value)" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center px-5 py-1">
                                <label class="sr-only text-nowrap m-2">??????????????????????????????????????????????????????</label>
                                <input type="password" class="form-control" placeholder="??????????????????????????????????????????????????????" name="m_fpassword" id="m_fpassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeyup="ConfirmPassword(this.value)" required>
                            </div>
                            <div class="d-flex justify-content-end align-items-center px-5 py-1">
                                <div class="pwTXT ms-2" id="passwordTxt">* ?????????????????????????????????????????? 8 ??????????????????????????? ???????????????????????????????????????????????????????????? a-z A-Z ????????? 0-9 ???????????????????????????????????????????????????</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">?????????</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>