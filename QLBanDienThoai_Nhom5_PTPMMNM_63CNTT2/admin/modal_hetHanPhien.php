<?php
global$hetHanPhien;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* CSS cho modal */
        #sessionModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8); /* Thêm hiệu ứng thu nhỏ khi bắt đầu */
            background-color: white;
            padding: 30px;
            font-size: 16px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            text-align: center;
            width: 500px;
            max-width: 90%;
            opacity: 0; /* Ẩn modal ban đầu */
            transition: transform 0.3s ease, opacity 0.3s ease; /* Thêm hiệu ứng cho transform và opacity */
        }

        #sessionModal.active {
            display: block;
            transform: translate(-50%, -50%) scale(1); /* Phóng to modal khi hiển thị */
            opacity: 1; /* Modal dần hiện ra */
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        #overlay.active {
            display: block;
        }

        /* Định dạng cho các nút */
        #sessionModal button {
            background-color: #4CAF50; /* Màu nền cho nút (màu xanh) */
            color: white; /* Màu chữ */
            padding: 5px 20px;  /* Tăng kích thước nút */
            font-size: 16px;      /* Tăng cỡ chữ */
            margin: 10px;         /* Tạo khoảng cách giữa các nút */
            border-radius: 8px;   /* Bo góc cho nút */
            border: none;
            cursor: pointer;      /* Đổi con trỏ chuột khi di chuột vào nút */
            transition: background-color 0.3s ease; /* Hiệu ứng khi di chuột qua */
        }

        #sessionModal button:hover {
            background-color: #009933; /* Màu nền khi hover vào nút */
            color: white;              /* Màu chữ khi hover */
        }
    </style>
</head>
<body>
<!-- Modal hiển thị khi hết phiên -->

<!-- Overlay là lớp mờ khi modal hiển thị -->
<div id="overlay"></div>
<div id="sessionModal">
    <h3>Phiên làm việc đã hết hạn</h3>
    <p>Bạn có muốn tiếp tục hoạt động không?</p>
    <form method="POST">
        <button type="submit" name="continues">Tiếp tục</button>
        <button type="submit" name="cancel">Hủy bỏ</button>
    </form>
</div>

<script>
    // Kiểm tra biến $session_expired từ PHP
    //chuyển đổi biến PHP $hetHanPhien sang định dạng JSON trước khi truyền vào JavaScript
    const sessionExpired = <?php echo json_encode($hetHanPhien); ?>;
    if (sessionExpired) {
        // Hiển thị modal khi phiên hết hạn
        document.getElementById('sessionModal').classList.add('active');
        document.getElementById('overlay').classList.add('active');
    }
</script>
</body>
</html>