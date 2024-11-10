<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

$msg = "";
$maKH = rand(10000000, 99999999);
$phanQuyen = "Khách hàng";
//mysqli_real_escape_string: dùng để thoát (escape) các ký tự đặc biệt trong một chuỗi, đảm bảo rằng dữ liệu nhập từ người dùng sẽ không gây ra lỗi SQL hoặc bị khai thác qua SQL Injection khi bạn chèn chuỗi đó vào câu truy vấn SQL.

if (isset($_POST['dangKy'])) {
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $pass_confirm = $_POST['password_confirm'];
    $tenhienthi = $_POST['tenhienthi'];
    $hoTen  = $_POST['hoTen'];
    $gioitinh = $_POST['gioiTinh'];
    $diachi  = $_POST['diaChi'];
    $sodienthoai = $_POST['soDienThoai'];
    $email = $_POST['email'];
    if(empty($username))
        $msg = "<span class='text-danger font-weight-bold'>Tên đăng nhập không được để trống</span>";
    elseif(empty($pass))
        $msg = "<span class='text-danger font-weight-bold'>Mật khẩu không được để trống</span>";
    elseif(empty($pass_confirm))
        $msg = "<span class='text-danger font-weight-bold'>Mật khẩu xác nhận không được để trống</span>";
    elseif(empty($tenhienthi))
        $msg = "<span class='text-danger font-weight-bold'>Mật khẩu không được để trống</span>";
    elseif(empty($hoTen))
        $msg = "<span class='text-danger font-weight-bold'>Họ tên khách hàng không được để trống</span>";
    elseif(empty($diachi))
        $msg = "<span class='text-danger font-weight-bold'>Địa chỉ khách hàng không được để trống</span>";
    elseif(!isset($gioitinh)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng chọn giới tính</span>";
    }
    elseif(empty($sodienthoai)){
        $msg = "<span class='text-danger font-weight-bold'>Số điện thoại không được để trống</span>";
    }
    elseif(empty($email)){
        $msg = "<span class='text-danger font-weight-bold'>Email không được để trống</span>";
    }
    else{
        //Truy vấn tên đăng nhập trong cơ sở dữ liệu
        $check_username = "SELECT * FROM tai_khoan WHERE tenTaiKhoan = '$username'";
        //Gửi truy vấn đến cơ sở dữ liệu
        $result_username = mysqli_query($connect, $check_username);
        //Kiểm tra nếu có một dòng kết quả (tức là tên tài khoản vừa nhập khớp với tên tài khoản trong cơ sở dữ liệu).
        if (mysqli_num_rows($result_username) != 0) {
            $msg = "<span class='text-danger font-weight-bold'>Tên đăng nhập đã tồn tại. Vui lòng chọn nhập tên đăng nhập khác!</span>";
        } else {
            //Thêm thông tin khách hàng vào bảng khách hàng
            $sql_Insert_KH = "INSERT INTO khach_hang (ma_khach_hang, ten_khach_hang, gioiTinh, dia_chi, so_dien_thoai, email) VALUES ('$maKH', '$hoTen', '$gioitinh', '$diachi', '$sodienthoai', '$email')";
            mysqli_query($connect, $sql_Insert_KH);
            //Thêm mới tài khoản
            $sql = "INSERT INTO tai_khoan (tenTaiKhoan, matKhau, tenHienThi, maNV_KH, phanQuyen) VALUES ('$username', '$pass', '$tenhienthi', '$maKH', '$phanQuyen')";
            if (mysqli_query($connect, $sql)) {

                $msg = "<span class='text-success font-weight-bold'>Đăng ký tài khoản thành công</span>";
            } else
                $msg = "<span class='text-danger font-weight-bold'>Đã có lỗi trong quá trình đăng ký</span>";


        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang đăng ký</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/Content/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/Content/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/Content/assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/admin" style="font-weight: bold; color: black;">MEGA<span style="color: deepskyblue;">TECH</span></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Đăng ký tài khoản khách hàng</p>
            <form action="" method="post">
                <fieldset>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Tên tài khoản <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Tên đăng nhập" name="username" type="text" autofocus value="<?php if(isset($_POST['username'])) echo $username; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Tên hiển thị <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Tên hiển thị" name="tenhienthi" type="text" autofocus value="<?php if(isset($_POST['tenhienthi'])) echo $tenhienthi; ?>"/>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Mật khẩu <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Mật khẩu" name="password" type="password" value="<?php if(isset($_POST['password'])) echo $pass; ?>" />
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Xác nhận mật khẩu<span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Xác nhận mật khẩu" name="password_confirm" type="password" value="<?php if(isset($_POST['password_confirm'])) echo $pass_confirm; ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group form-group-default">
                            <label>Họ tên <span class="text-danger">*</span></label>
                            <input class="form-control" placeholder="Họ tên khách hàng" name="hoTen" type="text" autofocus value="<?php if(isset($_POST['hoTen'])) echo $hoTen; ?>"/>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Giới tính <span class="text-danger">*</span></label>
                                    <select name="gioiTinh" class="custom-select form-control select">
                                        <option value="1" <?php if(isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == "1") echo 'selected'; ?>>Nam</option>
                                        <option value="0" <?php if(isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == "0") echo 'selected'; ?>>Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Số điện thoại <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Số điện thoại" name="soDienThoai" type="text" autofocus value="<?php if(isset($_POST['soDienThoai'])) echo $sodienthoai; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Địa chỉ <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Địa chỉ" name="diaChi" type="text" autofocus value="<?php if(isset($_POST['diaChi'])) echo $diachi; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Email" name="email" type="text" autofocus value="<?php if(isset($_POST['email'])) echo $email; ?>"/>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="form-group form-group-default text-center font-weight-bold">
                        <p class="text-success"><?php echo $msg;?></p>
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" name="dangKy" class="btn btn-success btn-block">Đăng ký</button>
                    </div>
                    <!-- /.col -->
                </fieldset>
            </form>
            <!-- /.col -->
            <div class="col-12 mt-3 text-center">
                <span>Bạn đã có tài khoản?</span>
                <a href="<?php echo $base_url; ?>/trangbanhang/login.php" type="submit">Đăng nhập ngay</a>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
<!-- jQuery -->
<script src="<?php echo $base_url; ?>/Content/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $base_url; ?>/Content/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $base_url; ?>/Content/assets/dist/js/adminlte.min.js"></script>
</body>
</html>

