-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 11:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlbandienthoai`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_hoadon`
--

CREATE TABLE `chitiet_hoadon` (
  `id` int(11) NOT NULL,
  `ma_hoa_don` varchar(10) NOT NULL,
  `ma_sp` varchar(10) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `don_gia` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hoa_don`
--

CREATE TABLE `hoa_don` (
  `ma_hoa_don` varchar(10) NOT NULL,
  `ma_khach_hang` varchar(10) NOT NULL,
  `ngay_lap` date NOT NULL,
  `ma_nhan_vien` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `ma_khach_hang` varchar(10) NOT NULL,
  `ten_khach_hang` varchar(500) NOT NULL,
  `gioiTinh` tinyint(1) NOT NULL,
  `dia_chi` varchar(500) NOT NULL,
  `so_dien_thoai` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`ma_khach_hang`, `ten_khach_hang`, `gioiTinh`, `dia_chi`, `so_dien_thoai`, `email`) VALUES
('39733562', 'Trần Quang Minh', 1, 'Thủ Đức', '07886695843', 'minhtq@gmail.com'),
('61398447', 'Phùng Thanh Lịch', 1, '1232 Xã Hòa, Cao Bằng', '08652341121', 'kh456@gmail.com'),
('74374725', 'Lương Thị Lanh', 0, '14 Hùng Vương, Hà Tĩnh', '07778543432', 'kh123@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `nhan_vien`
--

CREATE TABLE `nhan_vien` (
  `id` varchar(10) NOT NULL,
  `hoNV` varchar(20) NOT NULL,
  `tenlot` varchar(20) NOT NULL,
  `tenNV` varchar(20) NOT NULL,
  `gioiTinh` tinyint(1) NOT NULL,
  `ngaySinh` date NOT NULL,
  `diaChi` varchar(500) NOT NULL,
  `soDienThoai` varchar(500) NOT NULL,
  `Images` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `phanQuyen` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `nhan_vien`
--

INSERT INTO `nhan_vien` (`id`, `hoNV`, `tenlot`, `tenNV`, `gioiTinh`, `ngaySinh`, `diaChi`, `soDienThoai`, `Images`, `email`, `phanQuyen`) VALUES
('10188959', 'Phạm', 'Phương', 'Tuấn', 1, '2004-01-17', '25/3 Lạc Long Quân, Q.10, TP Hồ Chí Minh', '09665844321', 'boy1.jpg', 'tuan.ppt@gmail.com', 'NV'),
('13176242', 'Lê', 'Sỹ', 'Phú', 1, '1988-07-08', '700 Phố Sang, Xã Củ Hưu, Huyện Tào Chiêu Phong, Hà Nội', '0435961123', 'boy7.jpg', 'phusy@gmail.com', 'NV'),
('15055171', 'Hoàng', 'Phúc', 'Hưng', 1, '1996-08-09', '226/5, Quận Ô Môn, Cần Thơ', '01246695843', 'phungthanhdo.png', 'hungpttt@gmail.com', 'NV'),
('19036020', 'Nguyễn', 'Bạch', 'Phúc Hậu', 1, '1999-02-09', '567 An Dương Vương, Bà Rịa Vũng Tàu', '0944382545', 'talha.jpg', 'haupbn@gmail.com', 'NV'),
('22213635', 'Phạm', 'Kim', 'Thủy', 1, '2004-02-10', '1767 Nguyễn Đình Chiểu, Hà Nội', '0438596643', 'girl7.jpg', 'thuykpp@gmail.com', 'NV'),
('23099659', 'Nguyễn', 'Trung', 'Trực', 1, '2004-02-05', '144 Quang Trung, Nha Trang, Khánh Hòa', '08983341232', 'profile2.jpg', 'tructn123@gmail.com', 'NV'),
('29212433', 'Trần', 'Hàng', 'Tống Đạt', 1, '2003-02-01', '516 Phố Dư Thu Uyên, Thôn Miên Ý, Huyện Lạc Chiêu, Cần Thơ', '07872213988', 'men1.png', 'datht@gmail.com', 'ADMIN'),
('33576059', 'Nguyễn', 'Thiên', 'Ân', 0, '2000-03-09', '65, Thôn Ly Ca, Phườnng 25, Huyện Lai Võ, Bạc Liêu', '01214661007', 'girl12.jpg', 'antnn@outlook.com', 'NV'),
('34897411', 'Trần', 'Yến', 'Nhi', 0, '2009-12-08', '35 Hai Bà Trưng, Hà Nội', '0895543211', 'girl8.jpg', 'nhiynt@gmail.com', 'NV'),
('37577287', 'Lê', 'Xuân', 'An', 1, '2005-08-29', '91 Nguyễn Cư Trinh Ward Dist. 1, TP Hồ Chí Minh', '05849332123', 'girl14.jpg', 'anxl456@hotmail.com', 'NV'),
('38013738', 'Nguyễn', 'Phạm', 'Thịnh', 1, '1992-09-08', '15/4A Võ Thị Sáu, TP Hồ Chí Minh', '0844359665', 'boy13.jpg', 'thinhpnn@gmail.com', 'NV'),
('46414244', 'Trần', 'Trung', 'Hiếu', 1, '2004-12-25', '12/21 Võ Văn Ngân Thủ Đức, TP Hồ Chí Minh', '08475546571', 'boy10.jpg', 'hieutt@gmail.com', 'NV'),
('48832626', 'Nguyễn', 'Thiện', 'Nhân', 1, '1983-02-04', '1152 Lương Sơn, Khánh Hoà', '0698543221', 'boy2.jpg', 'nhnatpn@gmail.com', 'NV'),
('49556165', 'Lê', 'Minh', 'Tính', 1, '2000-07-08', '22/11 Lý Thường Kiệt,TP Mỹ Tho', '07555432159', 'boy5.jpg', 'tinhml@gmail.com', 'NV'),
('50999841', 'Phùng', 'Thanh', 'Độ', 1, '1983-08-05', '54 Nguyễn Hữu Thọ, Đà Nẵng', '0439232122', 'boy9.jpg', 'dothnask@gmail.com', 'ADMIN'),
('58717746', 'Ngô', 'Thanh', 'Vân', 0, '2008-03-15', '75B Yên Lãng, Hà Nội', '0439866543', 'girl10.jpg', 'vabtbb@hotmail.com', 'NV'),
('59819160', 'Nguyễn', 'Trọng', 'Tín', 1, '2004-07-11', '198/2A Trần Quốc Toản, Vũng Tàu', '0866594332', 'boy3.jpg', 'tinntn1002@gmail.com', 'NV'),
('63132095', 'Nguyễn', 'Khắc', 'Duy Hưng', 1, '2003-01-29', '1202/21 Hai Tháng Tư, TP Nha Trang', '0898386715', 'mlane.jpg', 'hungthinh291@gmail.com', 'ADMIN'),
('66257321', 'Đinh', 'Thị', 'Thu Hiệp', 0, '2003-12-16', '234 3/2, TP Biên Hòa', '0987443271', 'girl2.jpg', 'hiepdinh@gmail.com', 'ADMIN'),
('70203504', 'Nguyễn', 'Minh', 'Vũ', 0, '1991-08-06', '417 Trần Quý Cáp, Khánh Hoà', '0443958643', 'girl6.jpg', 'vumnn@gmail.com', 'NV'),
('71924526', 'Linh', 'Ngọc', 'Đàm', 0, '2004-03-11', '65B Điện Biên Phủ, Khánh Hoà', '0543786612', 'girl11.jpg', 'lanhlle@gmail.com', 'NV'),
('73113705', 'Trần', 'Mỹ', 'Duyên', 1, '1995-04-06', '18 Phố Tràng Phước Du, Xã 94, Huyện Mỹ, Hậu Giang', '09554382239', 'girl15.jpg', 'duyenmt@gmail.com', 'NV'),
('75952673', 'Phạm', 'Bảo', 'Ngân', 0, '2003-04-12', '1444 Trương Quyền, Hải Phòng', '0922134567', 'girl4.jpg', 'nganbp@gmail.com', 'NV'),
('78411208', 'Trần', 'Thị', 'Cẩm Tú', 0, '1995-08-10', '555B Võ Văn Kiệt, Khánh Hoà', '0125546433', 'girl1.jpg', 'tucam@gmail.com', 'ADMIN'),
('79089017', 'Phạm', 'Chí', 'Khoa', 1, '2009-08-04', '355 Trần Hưng Đạo, Khánh Hoà', '0549332123', 'boy13.jpg', 'khoachmas223@gmail.com', 'NV'),
('84160318', 'Ngô', 'Thanh', 'Sương', 0, '2001-11-03', '7A Hùng Vương, Quận 5, TP Hồ Chí Minh', '08695433212', 'girl13.jpg', 'suongtn@gmail.com', 'NV'),
('85770968', 'Võ', 'Thanh', 'Ngân', 0, '1999-01-01', '122 Nguyễn Trãi, Thanh Hoá', '0549822567', 'girl9.jpg', 'ngantv@gmail.com', 'NV'),
('89458824', 'Hồ', 'Thị', 'Thanh Ngân', 0, '2003-09-12', '548 Quận 86, Phú Yên', '0775844321', 'girl3.jpg', 'ngantth@gmail.com', 'NV'),
('91671592', 'Tăng', 'Duy', 'Tân', 1, '1991-02-10', '34 Phố Be, Xã 71, Quận 04, Hải Phòng', '0234415963', 'boy11.jpg', 'tanduy@gmail.com', 'NV'),
('93511717', 'Nguyễn', 'Bảo', 'Khánh', 1, '2001-09-10', '233 Lý Tự Trọng, Cà Mau', '0123455433', 'men3.png', 'khanhnblg@gmail.com', 'NV'),
('94014149', 'Võ', 'Quỳnh', 'Hương', 0, '1999-04-25', '788 Phố Châu Nhã Bắc, Xã Ánh, Quận Quân Trác, Đà Nẵng', '0124449876', 'girl5.jpg', 'huongqv@gmail.com', 'NV'),
('95911928', 'Phạm', 'Minh', 'Hoàng', 1, '1996-04-06', '245 Phố Hùng Khánh Toan, Xã Bích Liu, Quận 42, Vĩnh Phúc', '07876559443', 'jm_denis.jpg', 'hoanpm@gmail.com', 'NV'),
('98341191', 'Lê', 'Thanh', 'Tú', 0, '2004-09-09', 'Số 18, Thôn 26, Xã Toại Nghiêm, Quận 29, Hậu Giang', '0548892134', 'girl16.jpg', 'tutl@gmail.com', 'NV');

-- --------------------------------------------------------

--
-- Table structure for table `nha_cung_cap`
--

CREATE TABLE `nha_cung_cap` (
  `id` varchar(20) NOT NULL,
  `tenNCC` varchar(500) NOT NULL,
  `soDienThoai` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `diaChi` varchar(500) NOT NULL,
  `webSite` varchar(500) NOT NULL,
  `Images` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`id`, `tenNCC`, `soDienThoai`, `email`, `diaChi`, `webSite`, `Images`) VALUES
('16463517', 'Tecno', '0908462733', 'tecno@hotline.com', '123 Trần Quang Khải, Quận 1, TP. Hồ Chí Minh', ' www.tecnoelectronics.com', 'logo_tecno.png'),
('22703167', 'Apple', '18001127', 'apple@hotline.com', '23 Lê Lợi, Phường Bến Thành, Quận 1, TP. Hồ Chí Minh', 'www.appleworld.com', 'apple_logo.png'),
('24273739', 'Lenovo', '18006178', 'lenovo@hotline.com', '45 Trần Quang Khải, Phường Tân Định, Quận 1, TP. Hồ Chí Minh', ' www.lenovotech.com', 'logo_lenovo.png'),
('25423880', 'Sony', '1900561561', 'sony@hotline.com', '111 Nguyễn Văn Trỗi, Phường 12, Quận Phú Nhuận, TP. Hồ Chí Minh', 'www.sonytechworld.com', 'logo_sony.png'),
('28425155', 'Huawei', '18001085', 'huawei@hotline.com', '63B Trần Hưng Đạo, Phường Cầu Kho, Quận 1, TP. Hồ Chí Minh', 'www.huawei-tech.com', 'logo_huawei.png'),
('28517456', 'Realme', '0902788088', 'realme@hotline.com', '324/26 Hoàng Văn Thụ, Phường 4, Quận Tân Bình, TP. Hồ Chí Minh', 'www.realme-tech.com', 'Realme.png'),
('46595321', 'Intel', '0825499999', 'itel@hotline.com', '670A Nguyễn Văn Cừ, Gia Thụy, Long Biên, Hà Nội', ' www.inteltech.com', 'itel.png'),
('46861315', 'Masstel', '1900545470', 'masstel@hotline.com', '46 Tố Hữu, Nhân Chính, Thanh Xuân, Hà Nội', 'www.masstel-tech.com', 'Logo-Masstel-4.png'),
('64051064', 'Honor', '1900232464', 'honor@hotline.com', '123, Lê Duẩn, Hoàn Kiếm, Hà Nội', ' www.honor-tech.com', 'logo_honor.png'),
('64814833', 'Nokia', '02838393345', 'nokia@hotline.com', ' 291 Nguyễn Đình Chiểu, Quận 3, TP. Hồ Chí Minh', ' www.nokia-tech.com', 'logo_nokia.png'),
('72130818', 'Motorola', '1900558844', 'motorola@hotline.com', '65 Lê Lợi, Bến Nghé, Quận 1, TP. Hồ Chí Minh', 'www.motorola-tech.com', 'motorola.png'),
('73275149', 'OPPO', '1800588841', 'oppo@hotline.com', '72 Lê Thánh Tôn, Quận 1, TP. Hồ Chí Minh', ' www.oppo-tech.com', 'OPPO.png'),
('80358576', 'SamSung', '1800588889', 'sumsung@hotline.com', '25, Nguyễn Chí Thanh, Đống Đa, Hà Nội', ' www.samsung-tech.com', 'Samsung_Logo.png'),
('82468498', 'Xiaomi', '1800400410', 'xiaomi@hotline.com', '195 An Dương Vương, Phường 8, Quận 5​, TP. Hồ Chí Minh', ' www.xiaomi-tech.com', 'xiaomi.png'),
('83034139', 'One Plus', '18002064', 'oneplus@hotline.com', '15, Lý Thái Tổ, Quận Hoàn Kiếm, Hà Nội', ' www.oneplus-tech.com', 'logo_oneplus.png'),
('88127354', 'Vivo', '18006106', 'vivo@hotline.com', '40 Phạm Ngọc Thạch,  Võ Thị Sáu, Quận 3, TP. Hồ Chí Minh', ' www.vivo-tech.com', 'Vivo.png');

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
--

CREATE TABLE `san_pham` (
  `ma_sp` varchar(10) NOT NULL,
  `ma_ncc` varchar(10) NOT NULL,
  `ten_sp` varchar(500) NOT NULL,
  `mauSac` varchar(500) NOT NULL,
  `kichThuoc` varchar(500) NOT NULL,
  `trongLuong` decimal(10,0) NOT NULL,
  `Pin` varchar(500) NOT NULL,
  `congSac` varchar(500) NOT NULL,
  `RAM` int(30) NOT NULL,
  `boNho` int(30) NOT NULL,
  `hinhAnh` varchar(500) NOT NULL,
  `moTa` varchar(500) NOT NULL,
  `soLuong` int(11) NOT NULL,
  `giaBan` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`ma_sp`, `ma_ncc`, `ten_sp`, `mauSac`, `kichThuoc`, `trongLuong`, `Pin`, `congSac`, `RAM`, `boNho`, `hinhAnh`, `moTa`, `soLuong`, `giaBan`) VALUES
('11144483', '82468498', 'Xiaomi Mi 11', 'Xanh lơ', '164 x 74 x 8.06', 196, '4600 ', 'USB Type-C', 8, 12, 'xiaomimi11b.jpg', 'Xiaomi Mi 11 là một chiếc smartphone cao cấp với màn hình AMOLED 6.81 inch, chip Snapdragon 888, và hệ thống camera mạnh mẽ.', 160, 15000000),
('12778693', '28425155', 'Huawei Nova 9', 'Tím', '160 x 73.7 x 7.6 ', 175, '4300', 'USB Type-C', 8, 128, 'hwNova9.jpg', 'Huawei Nova 9 sở hữu thiết kế mỏng nhẹ, màn hình OLED 6.57 inch sắc nét, camera chính 50MP và hiệu năng mạnh mẽ với chip Snapdragon 778G.', 130, 16200000),
('12880398', '88127354', 'Vivo Y35', 'Đen', ' 164.1 x 76.1 x 8.0', 188, '5000', 'USB Type-C', 8, 128, 'Vivo35.jpg', 'Vivo Y35 được trang bị màn hình IPS LCD 6.58 inch, hiệu năng ổn định với chip Snapdragon 680, dung lượng pin lớn và hỗ trợ sạc nhanh 44W.', 135, 22540000),
('13274314', '28425155', 'Huawei Pura 70', 'Tím', '161,4 x 74,8 x 8,3', 192, ' 4900', 'USB Type-C', 12, 256, 'hwpura70.jpg', 'Huawei Pura 70 mang đến một thiết kế sang trọng, với màn hình OLED 6.6 inch, camera chính 50MP và khả năng sạc nhanh lên tới 66W.', 260, 30000000),
('14539754', '82468498', 'Xiaomi Mi 10 Pro', 'Đen', '162,6 x 74,8 x 8,96', 208, '4500', 'USB Type-C', 8, 256, 'xiaomimi10pro.jpg', 'Xiaomi Mi 10 Pro là một chiếc smartphone cao cấp với màn hình AMOLED 6.67 inch, độ phân giải Full HD+, cùng với bộ camera 108MP, hỗ trợ quay video 8K.', 100, 13400000),
('15519700', '22703167', 'Iphone 13', 'Đỏ, trắng, đen, xanh, hồng', '146.7 x 71.5 x 7.65', 174, '3240', 'Lightning', 4, 256, 'dmi0ob6d.png', ' iPhone 13 có màn hình OLED 6.1 inch, chip A15 Bionic, camera kép 12MP với quay video 4K Dolby Vision, mang lại hiệu suất và thời lượng pin vượt trội.', 120, 14000000),
('21881327', '80358576', 'Sumsung Galaxy S24 Ultra', 'Tím than', '164.7 x 79.9 x 8.9', 233, '5000', 'USB Type-C', 12, 256, 'u1hljoxc.png', 'Samsung Galaxy S24 Ultra trang bị màn hình Dynamic AMOLED 6.8 inch, chip Snapdragon 8 Gen 3, camera chính 200MP, hỗ trợ sạc nhanh 45W.', 200, 25000000),
('23254525', '16463517', 'Tecno Spark 9', 'Xanh', '164.3 x 76.5 x 8.4', 195, '5000', 'Micro-USB', 4, 128, 'tecnospark9.jpg', 'Tecno Spark 9 sở hữu màn hình IPS LCD 6.6 inch, camera chính 13MP, pin 5000mAh, và hiệu suất ổn định với chip MediaTek Helio G37.', 127, 16100000),
('23284206', '28425155', 'Huawei Honor Magic 4', 'Xanh ngọc', '163.6 x 74.5 x 8.8', 199, '4800', 'USB Type-C', 8, 256, 'HuaweiHonorMagic4.jpg', 'Huawei Honor Magic 4 có màn hình OLED 6.81 inch, chip Snapdragon 8 Gen 1, camera chính 50MP, hỗ trợ sạc nhanh 66W.', 175, 21700000),
('24151282', '28517456', 'Realme 11 ', 'Vàng', '164.4 x 76.2 x 8.1', 185, '5000', 'USB Type-C', 8, 128, 'Realme11.jpg', 'Realme 11 có màn hình Super AMOLED 6.4 inch, chip MediaTek Dimensity 7050, camera chính 64MP, hỗ trợ sạc nhanh 67W', 135, 22000000),
('25008195', '64051064', 'Honor 9X Pro', 'Tím', '164.4 x 76.2 x 8.1', 185, '5000', 'USB Type-C', 8, 128, 'hn9xpro.jpg', ' Realme 11 sở hữu màn hình Super AMOLED 6.4 inch, chip MediaTek Dimensity 7050, camera chính 64MP', 132, 25700000),
('26825549', '83034139', 'OnePlus 12', 'Xanh lá cây', '163.1 x 74.6 x 8.7', 205, '5000', 'USB Type-C', 12, 256, 'oneplus12.jpg', 'OnePlus 12 sở hữu màn hình Fluid AMOLED 6.7 inch, chip Snapdragon 8 Gen 3, camera chính 50MP với khả năng chụp ảnh chất lượng cao và hỗ trợ sạc nhanh 100W.', 160, 15850000),
('31504448', '82468498', 'Xiaomi poco M6 Pro', 'Tím', '168.6 x 76.2 x 8.5', 207, '5000', 'USB Type-C', 4, 64, '3g7yykd1.png', 'Xiaomi Poco M6 Pro có màn hình IPS LCD 6.7 inch, chip Qualcomm Snapdragon 4 Gen 2, camera chính 50MP, hỗ trợ sạc nhanh 18W', 135, 10000000),
('32833385', '22703167', 'Iphone 14 Pro Max', 'Tím', '160.7 x 77.6 x 7.85', 240, '4323', 'Lightning', 6, 256, 'iphone-14-pro-max-tim-thumb-600x600.jpg', 'iPhone 14 Pro Max sở hữu màn hình Super Retina XDR 6.7 inch, chip A16 Bionic, camera chính 48MP với khả năng chụp ảnh cực kỳ sắc nét và quay video 4K.', 150, 50000000),
('35409951', '82468498', 'Xiaomi Mi 12S Pro ', 'Trắng', '164.3 x 74.6 x 8.2', 204, '4600 ', 'USB Type-C', 8, 128, 'XiaomiMi12SPro5G.jpg', 'Xiaomi Mi 12S Pro trang bị màn hình AMOLED 6.73 inch, chip Snapdragon 8+ Gen 1, camera chính 50MP với khả năng chụp ảnh chất lượng cao và hỗ trợ sạc nhanh 120W.', 140, 17400000),
('35606441', '80358576', 'Sumsung Galaxy Z Fold 5', 'Trắng', '154.9 x 129.9 x 6.1 ', 253, '4400', 'USB Type-C', 12, 256, '39343100.jpeg', ' Samsung Galaxy Z Fold 5 sở hữu màn hình Dynamic AMOLED 2X 7.6 inch (khi mở) và 6.2 inch (khi gập), chip Snapdragon 8 Gen 2, camera chính 50MP, hỗ trợ sạc nhanh 25W. ', 190, 27000000),
('35616132', '80358576', 'Sumsung Galaxy S24 Ultra', 'Đen', '164.7 x 79.9 x 8.9', 233, '5000', 'USB Type-C', 12, 256, '4v9oxtmj.png', ' Samsung Galaxy S24 Ultra trang bị màn hình Dynamic AMOLED 6.8 inch, chip Snapdragon 8 Gen 3, camera chính 200MP, hỗ trợ sạc nhanh 45W.', 150, 25000000),
('35683762', '16463517', 'Tecno Camon 19 Neo', 'Xanh', '164.9 x 75.9 x 8.3', 192, '5000', 'USB Type-C', 4, 128, 'TecnoCamon19Neo.jpg', 'Tecno Camon 19 Neo sở hữu màn hình IPS LCD 6.8 inch, chip MediaTek Helio G85, camera chính 48MP, hỗ trợ sạc nhanh 18W. ', 150, 16200000),
('37360960', '28517456', 'Redmi Note 10S', 'Xanh, cam, đen', '160.5 x 74.5 x 8.3', 179, '5000', 'USB Type-C', 6, 64, 'RedmiNote10S.jpg', 'Redmi Note 10S sở hữu màn hình AMOLED 6.43 inch, chip MediaTek Helio G95, camera chính 64MP, hỗ trợ sạc nhanh 33W.', 115, 12000000),
('37378851', '88127354', 'Vivo Y17', 'Tím loang', '159.43 x 76.77 x 8.92', 190, '5000', 'Micro-USB', 4, 128, 'vivoy17.jpg', 'Vivo Y17 sở hữu màn hình IPS LCD 6.35 inch, chip MediaTek Helio P35, camera chính 13MP, hỗ trợ sạc nhanh 18W.', 200, 12100000),
('39284142', '73275149', 'OPPO Find N3', 'Vàng', '162.0 x 75.0 x 9.0', 237, '4800', 'USB Type-C', 12, 256, 'OPPO Find N3 5G.jpg', 'OPPO Find N3 sở hữu màn hình AMOLED 7.8 inch (khi mở) và 6.31 inch (khi gập), chip Snapdragon 8 Gen 2, camera chính 50MP, hỗ trợ sạc nhanh 67W.', 180, 23000000),
('43697155', '73275149', 'OPPO Reno11 F', 'Xanh rêu', '162.5 x 74.2 x 7.8', 190, '4500', 'USB Type-C', 8, 128, '2vm1b2ci.png', 'OPPO Reno 11 F sở hữu màn hình AMOLED 6.4 inch, chip MediaTek Dimensity 8050, camera chính 64MP, hỗ trợ sạc nhanh 67W.', 125, 20000000),
('44003402', '82468498', 'Xiaomi 14', 'Xanh rêu', '152.8 x 69.9 x 8.3', 189, '4600', 'USB Type-C', 8, 128, 'Xiaomi 14.jpg', 'Xiaomi 14 sở hữu màn hình OLED 6.36 inch, chip Snapdragon 8 Gen 3, camera chính 50MP, hỗ trợ sạc nhanh 90W.', 150, 22000000),
('44277576', '83034139', 'OnePlus Nord CE 3', 'Vàng', '160.2 x 73.3 x 7.6', 179, '5000', 'USB Type-C', 8, 128, 'oneplusnordCE3.jpg', 'OnePlus Nord CE 3 sở hữu màn hình Fluid AMOLED 6.7 inch, chip Snapdragon 782G, camera chính 50MP, hỗ trợ sạc nhanh 80W. ', 134, 11500000),
('47260078', '73275149', 'OPPO Reno 4', 'Trắng', '159.3 x 74.0 x 7.8', 165, '4025', 'USB Type-C', 8, 128, 'opporeno4.jpg', 'OPPO Reno 4 sở hữu màn hình AMOLED 6.4 inch, chip Snapdragon 720G, camera chính 48MP, hỗ trợ sạc nhanh 30W. ', 160, 23500000),
('49614325', '16463517', 'Tecno Pova 4', 'Đen', '164.8 x 76.0 x 8.9', 200, '6000', 'USB Type-C', 8, 128, 'Tecnopova4 4.jpg', 'Tecno Pova 4 sở hữu màn hình IPS LCD 6.82 inch, chip MediaTek Helio G99, camera chính 50MP, hỗ trợ sạc nhanh 18W.', 173, 12200000),
('54793711', '22703167', 'Iphone 15 Pro Max', 'Đen', '159.9 x 76.7 x 8.25', 221, '4422', 'USB Type-C', 8, 256, 'iphone15promax.jpg', ' iPhone 15 Pro Max sở hữu màn hình Super Retina XDR OLED 6.7 inch, chip A17 Pro, camera chính 48MP, hỗ trợ sạc nhanh 20W.', 135, 45500000),
('56240905', '22703167', 'Iphone 15 Pro', 'Trắng', '147.6 x 71.6 x 8.25', 187, '3274', 'USB Type-C', 8, 128, 'ip15pm.jpg', 'Phone 15 Pro sở hữu màn hình Super Retina XDR OLED 6.1 inch, chip A17 Pro, camera chính 48MP, hỗ trợ sạc nhanh 20W. ', 250, 40000000),
('57292775', '73275149', 'OPPO Reno11 F', 'Xanh', '162.5 x 74.2 x 7.8', 190, '4500', 'USB Type-C', 8, 128, 'OPPO Reno11 F 5G.png', 'OPPO Reno 11 F sở hữu màn hình AMOLED 6.4 inch, chip MediaTek Dimensity 8050, camera chính 64MP, hỗ trợ sạc nhanh 67W.', 125, 23000000),
('61732352', '28425155', 'Huawei Honor 60 SE', 'Xanh rêu', '161.4 x 73.3 x 8.4', 175, '4300', 'USB Type-C', 8, 128, 'Huawe Honor60SE5G.jpg', ' Huawei Honor 60 SE sở hữu màn hình OLED 6.67 inch, chip MediaTek Dimensity 900, camera chính 64MP, hỗ trợ sạc nhanh 66W.', 145, 16500000),
('62093264', '28517456', 'Realme C55', 'Vàng', '165.6 x 75.9 x 7.9', 189, '5000', 'USB Type-C', 8, 128, 'RealmeC55.jpg', 'Realme C55 sở hữu màn hình IPS LCD 6.72 inch, chip MediaTek Helio G88, camera chính 64MP, hỗ trợ sạc nhanh 33W. ', 125, 15600000),
('62341066', '88127354', 'Vivo Y02s', 'Xanh, đen', '164.2 x 75.6 x 8.5', 182, '5000', 'USB Type-C', 4, 32, 'vivoY2s.jpg', 'Vivo Y02s sở hữu màn hình IPS LCD 6.51 inch, chip MediaTek Helio P35, camera chính 8MP, hỗ trợ sạc nhanh 10W.', 155, 10500000),
('65696604', '16463517', 'Tecno Camon 18T', 'Tím', '164.5 x 76.2 x 8.5', 185, '5000', 'USB Type-C', 4, 128, 'tecnocamon18T.jpg', 'Tecno Camon 18T sở hữu màn hình IPS LCD 6.8 inch, chip MediaTek Helio G85, camera chính 48MP, hỗ trợ sạc nhanh 18W. ', 200, 15000000),
('66809512', '80358576', 'Samsung Galaxy A55', 'Trắng', '159.9 x 76.7 x 8.4', 189, '5000', 'USB Type-C', 6, 128, 'A55-1-600x600.png', 'Samsung Galaxy A55 sở hữu màn hình Super AMOLED 6.4 inch, chip Exynos 1280, camera chính 64MP, hỗ trợ sạc nhanh 25W.', 100, 29000000),
('68108443', '28517456', 'Realme Narzo 50 Pro ', 'Đen, xanh', '159.9 x 73.3 x 8.5', 193, '5000', 'USB Type-C', 6, 128, 'realmeNarzo50Pro5G.jpg', 'Realme Narzo 50 Pro sở hữu màn hình Super AMOLED 6.4 inch, chip MediaTek Dimensity 920, camera chính 48MP, hỗ trợ sạc nhanh 33W. ', 165, 14500000),
('70678670', '64051064', 'Honor 80 Pro', 'Xanh rêu', '162.8 x 75.5 x 8.1', 189, '4800', 'USB Type-C', 8, 256, 'hn80pro.jpg', 'Honor 80 Pro sở hữu màn hình OLED 6.78 inch, chip Qualcomm Snapdragon 8+ Gen 1, camera chính 160MP, hỗ trợ sạc nhanh 66W. ', 180, 21600000),
('72547694', '64051064', 'Honor 200 Pro', 'Xanh ngọc', '163.3 x 74.3 x 8.5', 190, '4800', 'USB Type-C', 8, 256, 'hn200pro5g.jpg', ' Honor 200 Pro sở hữu màn hình OLED 6.7 inch, chip Qualcomm Snapdragon 8 Gen 2, camera chính 200MP, hỗ trợ sạc nhanh 66W.', 190, 16400000),
('78487500', '28425155', 'Huawei Mate 40 Pro', 'Trắng', '161,4 x 74,8 x 8,3', 212, '4800', 'USB Type-C', 8, 128, 'hwMate40pro.jpg', 'Huawei Mate 40 Pro sở hữu màn hình OLED 6.76 inch, chip Kirin 9000, camera chính 50MP, hỗ trợ sạc nhanh 66W. ', 120, 12300000),
('78636351', '88127354', 'Vivo V25e', 'Vàng', '159.2 x 73.6 x 7.8', 183, '4500', 'USB Type-C', 8, 128, 'Vivo V25e.png', 'Vivo V25e sở hữu màn hình AMOLED 6.44 inch, chip MediaTek Helio G99, camera chính 64MP, hỗ trợ sạc nhanh 44W. ', 140, 1520000),
('80869771', '83034139', 'OnePlus 11R', 'Đỏ', '163.3 x 75.9 x 8.7', 204, '5000', 'USB Type-C', 8, 128, 'OnePlus11R5G.jpg', ' OnePlus 11R sở hữu màn hình Fluid AMOLED 6.74 inch, chip Qualcomm Snapdragon 8+ Gen 1, camera chính 50MP, hỗ trợ sạc nhanh 100W. ', 115, 14200000),
('83000582', '28517456', 'Redmi Note 11', 'Đen', '159.9 x 73.9 x 8.1', 179, '5000', 'USB Type-C', 4, 64, 'RedmiNote11.jpg', 'Redmi Note 11 sở hữu màn hình AMOLED 6.43 inch, chip Qualcomm Snapdragon 680, camera chính 50MP, hỗ trợ sạc nhanh 33W. ', 120, 13500000),
('83312445', '80358576', 'Sumsung Galaxy Z Fold 6', 'Đen, trắng, xám', '160.9 x 128.1 x 6.3', 263, '4400', 'USB Type-C', 12, 256, 'giuza4pg.png', 'Samsung Galaxy Z Fold 6 sở hữu màn hình Dynamic AMOLED 2X 7.6 inch khi mở ra và màn hình AMOLED 6.2 inch khi gập lại, chip Qualcomm Snapdragon 8 Gen 2, camera chính 50MP, hỗ trợ sạc nhanh 25W. ', 155, 35700000),
('83900243', '83034139', 'OnePlus 8', 'Xanh', '160.2 x 72.9 x 8', 180, '4300', 'USB Type-C', 8, 128, 'oneplus8.jpg', ' OnePlus 8 sở hữu màn hình Fluid AMOLED 6.55 inch, chip Qualcomm Snapdragon 865, camera chính 48MP, hỗ trợ sạc nhanh 30W.', 100, 9000000),
('85543914', '16463517', 'Tecno Spark 8C', 'Đen', '164.3 x 75.6 x 8.9', 204, '5000', 'USB Type-C', 3, 64, 'tecnoSpark8c.jpg', 'Tecno Spark 8C sở hữu màn hình IPS LCD 6.6 inch, chip Unisoc T606, camera chính 13MP, hỗ trợ sạc nhanh 10W. ', 110, 9900000),
('88126915', '64051064', 'Honor 50 ', 'Hồng ánh kim', '159.9 x 73.3 x 8.0', 175, '4300', 'USB Type-C', 6, 128, 'hn505g.jpg', 'Honor 50 sở hữu màn hình OLED 6.57 inch, chip Qualcomm Snapdragon 778G, camera chính 108MP, hỗ trợ sạc nhanh 66W.', 164, 26200000),
('91823858', '88127354', 'Vivo Y93', 'Đỏ', '155.1 x 75.1 x 8.3', 166, '6030', 'Micro-USB', 4, 64, 'vivoy93.jpg', 'Vivo Y93 sở hữu màn hình IPS LCD 6.2 inch, chip Qualcomm Snapdragon 439, camera chính 13MP, hỗ trợ sạc 10W. ', 240, 9500000),
('92450979', '22703167', 'Iphone 14 Pro ', 'Đen, trắng, vàng, tím', '147.5 x 71.5 x 7.85', 206, '3200', 'Lightning', 6, 512, 'iphone-14-pro-colors.png', 'iPhone 14 Pro sở hữu màn hình Super Retina XDR OLED 6.1 inch, chip Apple A16 Bionic, camera chính 48MP, hỗ trợ sạc nhanh 20W. ', 135, 35000000),
('95109457', '73275149', 'OPPO A76', 'Xanh', '164.4 x 75.7 x 8.4', 189, '5000', 'USB Type-C', 8, 128, 'OPPOa78.jpg', ' OPPO A76 sở hữu màn hình IPS LCD 6.56 inch, chip Qualcomm Snapdragon 680, camera chính 13MP, hỗ trợ sạc nhanh 33W. ', 230, 16750000),
('99217249', '83034139', 'OnePlus 10 Pro', 'Xanh rêu', '163.0 x 73.9 x 8.5', 200, '5000', 'USB Type-C', 8, 128, 'OnePlus10Pro5G.jpg', 'OnePlus 10 Pro sở hữu màn hình Fluid AMOLED 6.7 inch, chip Qualcomm Snapdragon 8 Gen 1, camera chính 48MP, hỗ trợ sạc nhanh 80W. ', 110, 13600000),
('99943155', '64051064', 'Honor Magic 6 Pro', 'Trắng', '162.9 x 76.7 x 8.8', 219, '5100', 'USB Type-C', 8, 128, 'hnmagic6pro.jpg', 'Honor Magic 6 Pro sở hữu màn hình OLED 6.81 inch, chip Qualcomm Snapdragon 8 Gen 2, camera chính 50MP, hỗ trợ sạc nhanh 66W.', 170, 26700000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `user_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `user_id`) VALUES
(10, 'admin', '123456', '63132095'),
(11, 'nvien10188', 'Abc@123', '10188959'),
(12, 'nvien78411', 'Abc@123', '78411208'),
(13, 'admin66257', 'Abc@123', '66257321'),
(14, 'nvien89458', 'Abc@123', '89458824'),
(15, 'nvien75952', 'Abc@123', '75952673'),
(16, 'nvien94014', 'Abc@123', '94014149'),
(17, 'nvien98341', 'Abc@123', '98341191'),
(18, 'nvien70203', 'Abc@123', '70203504'),
(19, 'nvien22213', 'Abc@123', '22213635'),
(20, 'nvien34897', 'Abc@123', '34897411'),
(21, 'nvien48832', 'Abc@123', '48832626'),
(22, 'nvien85770', 'Abc@123', '85770968'),
(23, 'nvien58717', 'Abc@123', '58717746'),
(24, 'nvien71924', 'Abc@123', '71924526'),
(25, 'nvien59819', 'Abc@123', '59819160'),
(26, 'nvien33576', 'Abc@123', '33576059'),
(27, 'nvien84160', 'Abc@123', '84160318'),
(28, 'nvien37577', 'Abc@123456', '37577287'),
(29, 'nvien73113', 'Abc@123', '73113705'),
(30, 'nvien49556', 'Abc@123', '49556165'),
(31, 'nvien13176', 'Abc@123', '13176242'),
(32, 'admin50999', 'Abc@123', '50999841'),
(33, 'nvien91671', 'Abc@123', '91671592'),
(34, 'nvien38013', 'Abc@123', '38013738'),
(35, 'nvien46414', 'Abc@123', '46414244'),
(37, 'nvien95911', 'Abc@123', '95911928'),
(38, 'nvien79089', 'Abc@123', '79089017'),
(39, 'nvien93511', 'Abc@123', '93511717'),
(40, 'nvien15055', 'Abc@123', '15055171'),
(41, 'admin29212', 'Abc@123', '29212433'),
(46, 'kh123', 'Abc@123', '39733562'),
(47, 'nvien23099', 'Abc@123', '23099659'),
(48, 'nvien19036', 'Abc@123', '19036020');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitiet_hoadon`
--
ALTER TABLE `chitiet_hoadon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ma_hoa_don` (`ma_hoa_don`),
  ADD KEY `ma_sp` (`ma_sp`);

--
-- Indexes for table `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD PRIMARY KEY (`ma_hoa_don`),
  ADD KEY `ma_khach_hang` (`ma_khach_hang`),
  ADD KEY `ma_nhan_vien` (`ma_nhan_vien`);

--
-- Indexes for table `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`ma_khach_hang`);

--
-- Indexes for table `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`ma_sp`),
  ADD KEY `ma_ncc` (`ma_ncc`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chitiet_hoadon`
--
ALTER TABLE `chitiet_hoadon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitiet_hoadon`
--
ALTER TABLE `chitiet_hoadon`
  ADD CONSTRAINT `chitiet_hoadon_ibfk_1` FOREIGN KEY (`ma_sp`) REFERENCES `san_pham` (`ma_sp`),
  ADD CONSTRAINT `chitiet_hoadon_ibfk_2` FOREIGN KEY (`ma_hoa_don`) REFERENCES `hoa_don` (`ma_hoa_don`);

--
-- Constraints for table `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD CONSTRAINT `hoa_don_ibfk_1` FOREIGN KEY (`ma_khach_hang`) REFERENCES `khach_hang` (`ma_khach_hang`),
  ADD CONSTRAINT `hoa_don_ibfk_2` FOREIGN KEY (`ma_nhan_vien`) REFERENCES `nhan_vien` (`id`);

--
-- Constraints for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`ma_ncc`) REFERENCES `nha_cung_cap` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
