<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";

$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

$error = "";
$msg = "";

if (isset($_POST['dangKy'])) {
    if (!empty($_POST['username'])) {
        $username = mysqli_real_escape_string($connect, $_POST['username']);
        if (!empty($_POST['password'])) {
            $pass = mysqli_real_escape_string($connect, $_POST['password']);
            if (!empty($_POST['tenhienthi'])) {
                $tenhienthi = mysqli_real_escape_string($connect, $_POST['tenhienthi']);
                if (!empty($_POST['maNV'])) {
                    $maNV = mysqli_real_escape_string($connect, $_POST['maNV']);

                    //Kiểm tra mã nhân viên có trong CSDL hay không?
                    $check_maNV = "SELECT * FROM nhan_vien WHERE id = '$maNV'";
                    $result_maNV = mysqli_query($connect, $check_maNV);

                    if (mysqli_num_rows($result_maNV) == 0) {
                        $error = "Mã nhân viên không tồn tại. Vui lòng kiểm tra lại.";
                    } else {
                        //Kiểm tra tên tài khoản đã tồn tại hay chưa (có bị trùng hay không)
                        $check_username = "SELECT * FROM tai_khoan WHERE tenTaiKhoan = '$username'";
                        $result_username = mysqli_query($connect, $check_username);

                        if (mysqli_num_rows($result_username) > 0) {
                            $error = "Tên đăng nhập đã tồn tại. Vui lòng chọn nhập tên đăng nhập khác!";
                        } else {
                            //Kiểm tra nhân viên đó có tài khoản hay chưa (1 nhân viên - 1 tài khoản)
                            $check_nv_tk = "SELECT * FROM nhan_vien WHERE id = '$maNV' AND idTaiKhoan IS NOT NULL";
                            $result_nv_tk = mysqli_query($connect, $check_nv_tk);

                            if (mysqli_num_rows($result_nv_tk) > 0) {
                                $error = "Nhân viên này đã có tài khoản.";
                            } else  //Đủ điều kiện: Mã nhân viên đúng, idTaiKhoan null
                            {
                                //Thêm mới tài khoản
                                $sql = "INSERT INTO tai_khoan (tenTaiKhoan, matKhau, tenHienThi) VALUES ('$username', '$pass', '$tenhienthi')";

                                if (mysqli_query($connect, $sql)) {
                                    //Cập nhật tài khoản vào nhân viên
                                    $idtk = mysqli_insert_id($connect);
                                    $query = "UPDATE nhan_vien SET idTaiKhoan = '$idtk' WHERE id = '$maNV'";
                                    mysqli_query($connect, $query);
                                    $msg = "Đăng ký tài khoản thành công";
                                } else {
                                    $error = "Đã có lỗi trong quá trình đăng ký";
                                }
                            }
                        }
                    }
                } else {
                    $error = "Mã nhân viên là trường bắt buộc";
                }
            } else {
                $error = "Vui lòng nhập tên hiển thị";
            }
        } else {
            $error = "Vui lòng nhập mật khẩu";
        }
    } else {
        $error = "Vui lòng nhập tên đăng nhập";
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
            <p class="login-box-msg">Đăng ký tài khoản nhân viên</p>
            <form action="" method="post">
                <fieldset>
                    <div class="form-group form-group-default">
                        <label>Tên tài khoản</label>
                        <input class="form-control" placeholder="Tên đăng nhập" name="username" type="text" autofocus />
                    </div>
                    <div class="form-group form-group-default">
                        <label>Mật khẩu</label>
                        <input class="form-control" placeholder="Mật khẩu" name="password" type="password" value="" />
                    </div>
                    <div class="form-group form-group-default">
                        <label>Tên hiển thị</label>
                        <input class="form-control" placeholder="Tên hiển thị" name="tenhienthi" type="text" autofocus />
                    </div>
                    <div class="form-group form-group-default">
                        <label>Mã nhân viên</label><span class="text-danger">*</span>
                        <input class="form-control" placeholder="Tên hiển thị" name="maNV" type="text" autofocus />
                    </div>
                    <div class="form-group form-group-default text-center font-weight-bold">
                        <p class="text-danger"><?php echo $error;?></p>
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
                <a href="<?php echo $base_url; ?>/admin/login.php" type="submit">Đăng nhập ngay</a>
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

