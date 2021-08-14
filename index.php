<?php
session_start();

if (isset($_SESSION["m_id"])) {
    header("location:dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SWMS | Smart Water Monitoring System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    
    <link rel="stylesheet" href="{{asset('/css/bootstrap.css')}}">
    <script src="{{asset('/js/bootstrap.js')}}"></script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="/__/firebase/8.9.1/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

    <!-- Initialize Firebase -->
    <script src="/__/firebase/init.js"></script>

    <link rel="stylesheet" type="text/css" href="css/stylesheet-index.css">

    <script src="js/js-swms/login.js"></script>
    <script src="js/js-swms/index.js"></script>
    <script>
        var validVal = "1";
    </script>
    <?php if (isset($_COOKIE["loginFailedTxt"])) {
        echo "<script>validVal = '0';</script>";
    } ?>

</head>

<body onload="myFunction()" style="margin:0;">

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

    <div class="container container-fluid loader" id="loader">
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

    <div class="animate-bottom container container-fluid" style="display:none;" id="myDiv">
        <center>
            <img class="brand-logo shadow-sm d-none d-sm-block" src="images/content/swms-logo.png">
            <img class="brand-logo shadow-sm d-sm-none" src="images/content/swms-logo.png" style="width: 120px;">
        </center>
        <h3 class="txt-lg d-none d-sm-block">SWMS | Smart Water Monitoring System</h3>
        <h3 class="txt-sm d-sm-none">SWMS | Smart Water Monitoring System</h3>
        <br /><br /><br />
        <!--<a class="btn btn-warning btn-block shadow-sm" href="login.php">เข้าสู่ระบบ</a><br/><br/>-->
        <a class="btn btn-warning btn-block shadow-sm" href="" data-toggle="modal" data-target="#loginModal">เข้าสู่ระบบ</a><br /><br />
        <a class="btn btn-info btn-block shadow-sm" href="" data-toggle="modal" data-target="#registrationModal">สมัครสมาชิก</a>
    </div>

    <!-- Login modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-bg rounded">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">เข้าสู่ระบบ</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="loginform" method="post" name="loginform" autocomplete="on">
                            <div class="form-group">
                                <label>ชื่อผู้ใช้งาน</label>
                                <input type="email" class="form-control" placeholder="ชื่อผู้ใช้งาน" name="username" id="username" oninvalid="this.setCustomValidity('โปรดกรอกอีเมล์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" required>
                            </div>
                            <div class="form-group">
                                <label>รหัสผ่าน</label>
                                <input type="password" class="form-control" placeholder="รหัสผ่าน" name="password" id="password" required>
                            </div>
                            <div class="form-group" id="invalidTxt" style="display:none">
                                <?php if (isset($_COOKIE["loginFailedTxt"])) {
                                    echo '<label style="color:red;">* ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</lebal>';
                                } ?>
                            </div>
                            <!--
                <div class="form-group remember"><input type="checkbox" id="remember" name="remember" onclick="checkRemember()">จดจำบัญชีผู้ใช้งาน</div>
          -->
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary btn-login shadow-sm" onclick="checkLogin(username.value,password.value)">เข้าสู่ระบบ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration modal -->
    <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-bg rounded">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">สมัครสมาชิก</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="refistrationform" name="refistrationform" autocomplete="off">
                            <div class=" form-group">
                                <label class="sr-only text-nowrap">ชื่อ - นามสกุล *</label>
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control" id="m_name" placeholder="ชื่อ" autocomplete="off" required>
                                    <input type="text" class="form-control" id="m_sirname" placeholder="นามสกุล" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group d-flex align-items-baseline">
                                    <label>ชื่อผู้ใช้งาน *</label>
                                    <div class="invalidTxt ms-2" id="emailTxt"></div>
                                </div>
                                <div class="form-group d-flex justify-content-center">
                                    <input type="email" class="form-control" placeholder="ชื่อผู้ใช้งาน" autocomplete="off" name="m_username" id="m_username" oninvalid="this.setCustomValidity('โปรดกรอกอีเมล์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeyup="EmailCheck(this.value)" required>
                                    <div class="m-2" id="emailcheck"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group d-flex align-items-baseline">
                                    <label>รหัสผ่าน *</label>
                                    <div class="pwTXT ms-2">อักขระ 8 ตัวขึ้นไป ประกอบไปด้วยตัวอักษร a-z A-Z และ 0-9 อย่างน้อยหนึ่งตัว</div>
                                </div>
                                <div class="form-group d-flex justify-content-center">
                                    <input type="password" class="form-control" placeholder="รหัสผ่าน" autocomplete="off" name="m_password" id="m_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="this.setCustomValidity('รหัสผ่านต้องมีอักขระตั้งแต่ 8 ตัวขึ้นไป ประกอบไปด้วยตัวเลข ตัวพิมพ์ใหญ่และตัวพิมพ์เล็กอย่างน้อยหนึ่งตัว')" oninput="this.setCustomValidity('')" onkeyup="CheckPassword(this.value)" required>
                                    <div class="m-2" id="passwordcheck"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>ยืนยันรหัสผ่าน *</label>
                                <div class="form-group d-flex justify-content-center">
                                    <input type="password" class="form-control" placeholder="ยืนยันรหัสผ่าน" autocomplete="off" name="m_fpassword" id="m_fpassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสผ่านให้ตรงกัน')" oninput="this.setCustomValidity('')" onkeyup="ConfirmPassword(this.value)" required>
                                    <div class="m-2" id="passwordconfirm"></div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary btn-regis shadow-sm" onclick="regis()">สมัครสมาชิก</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Regis failed modal -->
    <div class="modal fade" id="regisFailedModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <h5 style="color:red;">การลงทะเบียนไม่สำเร็จ กรุณาลงทะเบียนใหม่อีกครั้ง</h5>
                        <button type="button" class="btn btn-warning m-3" data-dismiss="modal">ปิด</button>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <script>
        var myVar;

        function myFunction() {
            LoginInvalid();
            myVar = setTimeout(showPage, 1000);
        }

        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("myDiv").style.display = "block";

            document.getElementById("m_name").value = "";
            document.getElementById("m_sirname").value = "";
            document.getElementById("m_username").value = "";
            document.getElementById("m_password").value = "";
            document.getElementById("m_fpassword").value = "";
        }

        function LoginInvalid() {
            if (validVal == "0") {
                document.getElementById("invalidTxt").style.display = "block";
                $('#loginModal').modal('show');
            }
        }
    </script>

</body>

</html>
