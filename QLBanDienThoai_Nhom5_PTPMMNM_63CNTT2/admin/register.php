<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

$error = "";
$msg = "";

//mysqli_real_escape_string: dùng để thoát (escape) các ký tự đặc biệt trong một chuỗi, đảm bảo rằng dữ liệu nhập từ người dùng sẽ không gây ra lỗi SQL hoặc bị khai thác qua SQL Injection khi bạn chèn chuỗi đó vào câu truy vấn SQL.

if (isset($_POST['dangKy'])) {
    //Kiểm tra tên đăng nhập, mật khẩu và tên hiển thị có để trống không?
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['tenhienthi'])) {
        $username = mysqli_real_escape_string($connect, $_POST['username']);
        $pass = mysqli_real_escape_string($connect, $_POST['password']);
        $tenhienthi = mysqli_real_escape_string($connect, $_POST['tenhienthi']);
        //Kiểm tra mã nhân viên có trống không?
        if (!empty($_POST['maNV'])) {
            $maNV = mysqli_real_escape_string($connect, $_POST['maNV']);

            //Truy vấn mã nhân viên trong cơ sở dữ liệu
            $check_maNV = "SELECT * FROM nhan_vien WHERE id = '$maNV'";
            //Gửi truy vấn đến cơ sở dữ liệu
            $result_maNV = mysqli_query($connect, $check_maNV);
            //Kiểm tra nếu có một dòng kết quả (tức là mã nhân viên vừa nhập khớp với một mã nhân viên trong cơ sở dữ liệu).
            if (mysqli_num_rows($result_maNV) == 0)
                $error = "Mã nhân viên không tồn tại. Vui lòng kiểm tra lại.";
            else {

                //Truy vấn tên đăng nhập trong cơ sở dữ liệu
                $check_username = "SELECT * FROM tai_khoan WHERE tenTaiKhoan = '$username'";
                //Gửi truy vấn đến cơ sở dữ liệu
                $result_username = mysqli_query($connect, $check_username);
                //Kiểm tra nếu có một dòng kết quả (tức là tên tài khoản vừa nhập khớp với tên tài khoản trong cơ sở dữ liệu).
                if (mysqli_num_rows($result_username) != 0) {
                    $error = "Tên đăng nhập đã tồn tại. Vui lòng chọn nhập tên đăng nhập khác!";
                } else {
                    //Truy vấn nhân viên đã có tài khoản hay chưa.
                    $check_nv_tk = "SELECT * FROM nhan_vien WHERE id = '$maNV' AND idTaiKhoan IS NOT NULL";
                    //Gửi truy vấn đến cơ sở dữ liệu
                    $result_nv_tk = mysqli_query($connect, $check_nv_tk);
                    //Kiểm tra nếu có một dòng kết quả.
                    if (mysqli_num_rows($result_nv_tk) != 0) {
                        $error = "Nhân viên này đã có tài khoản.";
                    } else  //Đủ điều kiện: Mã nhân viên đúng, idTaiKhoan = null
                    {
                        //Thêm mới tài khoản
                        $sql = "INSERT INTO tai_khoan (tenTaiKhoan, matKhau, tenHienThi) VALUES ('$username', '$pass', '$tenhienthi')";

                        if (mysqli_query($connect, $sql)) {
                            //mysqli_insert_id: lấy ID của tài khoản vừa được thêm vào từ bảng tai_khoan, sau đó liên kết tài khoản này với một nhân viên cụ thể trong bảng nhan_vien bằng cách cập nhật cột idTaiKhoan
                            $idtk = mysqli_insert_id($connect);
                            //Cập nhật tài khoản vào nhân viên
                            $query = "UPDATE nhan_vien SET idTaiKhoan = '$idtk' WHERE id = '$maNV'";
                            mysqli_query($connect, $query);
                            $msg = "Đăng ký tài khoản thành công";
                        } else
                            $error = "Đã có lỗi trong quá trình đăng ký";
                    }
                }
            }
        }
        else
            $error = "Mã nhân viên là trường bắt buộc";
    }
    else
        $error = "Tên đăng nhập, mật khẩu, tên hiển thị không được để trống";
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

