-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 23, 2025 lúc 01:05 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE `cuahang`;
USE `cuahang`;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cuahang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `address` text NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `phone`, `gender`, `address`, `avatar`, `password`, `status`, `created_at`) VALUES
(1, 'Second Admin', 'secondadmin@example.com', '058 733 1244', 1, 'TDP Sơn Hải-Phường Ninh Hải', '../assets/avatar/customes/avatar_customes68258f5a03c4b2.04348364.jpg', '$2y$10$LjeOEope0BsHsrEClUxTG.e3BkEJWzZffVKW0ySuMk4IJx8iaoEia', 'active', '2025-05-14 23:52:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `customer_id`, `product_id`, `color`, `size`, `quantity`, `created_at`, `status`) VALUES
(7, 7, 21, 'Đen', 'M', 2, '2025-05-18 18:03:56', 'active'),
(8, 7, 22, 'Đen', 'M', 1, '2025-05-18 18:04:03', 'active');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` mediumtext DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_settings`
--

CREATE TABLE `contact_settings` (
  `id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL COMMENT 'Địa chỉ cửa hàng',
  `phone_1` varchar(20) NOT NULL COMMENT 'Số điện thoại chính',
  `phone_2` varchar(20) DEFAULT NULL COMMENT 'Số điện thoại phụ',
  `email_1` varchar(100) NOT NULL COMMENT 'Email chính',
  `email_2` varchar(100) DEFAULT NULL COMMENT 'Email phụ',
  `map_url` text DEFAULT NULL COMMENT 'URL Google Maps',
  `facebook_url` varchar(255) DEFAULT NULL COMMENT 'Link Facebook',
  `instagram_url` varchar(255) DEFAULT NULL COMMENT 'Link Instagram',
  `youtube_url` varchar(255) DEFAULT NULL COMMENT 'Link YouTube',
  `tiktok_url` varchar(255) DEFAULT NULL COMMENT 'Link TikTok',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật',
  `updated_by` int(11) DEFAULT NULL COMMENT 'ID người cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_settings`
--

INSERT INTO `contact_settings` (`id`, `address`, `phone_1`, `phone_2`, `email_1`, `email_2`, `map_url`, `facebook_url`, `instagram_url`, `youtube_url`, `tiktok_url`, `updated_at`, `updated_by`) VALUES
(1, '123 Main Street, Hanoi, Vietnam', '0123456789', '0987654321', 'contact@cuahang.com', 'support@cuahang.com', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d189.44848732131504!2d105.84554702388468!3d21.004306094667868!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac768313ac6d%3A0xcdd39029e17f96ad!2zTmcuIDgxIFAuIFRy4bqnbiDEkOG6oWkgTmdoxKlhLCBCw6FjaCBLaG9hLCBIYWkgQsOgIFRyxrBuZywgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e1!3m2!1svi!2s!4v1747294131206!5m2!1svi!2s', NULL, NULL, NULL, NULL, '2025-05-15 01:14:11', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `password`, `phone`, `address`, `avatar`, `gender`, `created_at`, `status`) VALUES
(1, 'Nguyễn Thị Nga ', 'ngothebao@gmail.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0235243634', 'TDP Sơn Hải-Phường Ninh Hải', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 00:21:42', 'active'),
(2, 'Nguyen Van A', 'nguyenvana@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0123456789', '123 Main Street, Hanoi', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:16:09', 'active'),
(3, 'Tran Thi B', 'tranthib@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0987654321', '456 Second Street, Ho Chi Minh City', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:16:09', 'active'),
(4, 'Le Van C', 'levanc@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0912345678', '789 Third Street, Da Nang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:16:09', 'active'),
(5, 'Pham Thi D', 'phamthid@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0908765432', '321 Fourth Street, Hai Phong', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(6, 'Bui Van E', 'buivane@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0976543210', '654 Fifth Street, Can Tho', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(7, 'Do Thi F', 'dothif@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0932123456', '987 Sixth Street, Nha Trang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(8, 'Nguyen Van G', 'nguyenvang@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0911223344', '111 Seventh Street, Vinh', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(9, 'Tran Thi H', 'tranthih@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0922334455', '222 Eighth Street, Quang Ninh', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(10, 'Le Van I', 'levani@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0933445566', '333 Ninth Street, Lao Cai', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(11, 'Pham Thi J', 'phamthij@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0944556677', '444 Tenth Street, Thanh Hoa', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(12, 'Hoang Van K', 'hoangvank@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0955667788', '555 Eleventh Street, Bac Ninh', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(13, 'Vu Thi L', 'vuthil@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0966778899', '666 Twelfth Street, Nam Dinh', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(14, 'Nguyen Van M', 'nguyenvanm@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0977889900', '777 Thirteenth Street, Ha Tinh', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(15, 'Tran Thi N', 'tranthin@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0988990011', '888 Fourteenth Street, Quang Binh', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(16, 'Le Van O', 'levano@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0999001122', '999 Fifteenth Street, Quang Tri', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(17, 'Pham Thi P', 'phamthip@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0900112233', '101 Sixteenth Street, Hue', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(18, 'Hoang Van Q', 'hoangvanq@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0911223345', '102 Seventeenth Street, Da Lat', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(19, 'Vu Thi R', 'vuthir@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0922334456', '103 Eighteenth Street, Vung Tau', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(20, 'Nguyen Van S', 'nguyenvans@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0933445567', '104 Nineteenth Street, Phan Thiet', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(21, 'Tran Thi T', 'tranthit@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0944556678', '105 Twentieth Street, Bien Hoa', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(22, 'Le Van U', 'levanu@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0955667789', '106 Twenty-first Street, Long An', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(23, 'Pham Thi V', 'phamthiv@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0966778890', '107 Twenty-second Street, Tay Ninh', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(24, 'Hoang Van W', 'hoangvanw@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0977889901', '108 Twenty-third Street, Soc Trang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(25, 'Vu Thi X', 'vuthix@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0988990012', '109 Twenty-fourth Street, Bac Lieu', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(26, 'Nguyen Van Y', 'nguyenvany@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0999001123', '110 Twenty-fifth Street, Ca Mau', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(27, 'Tran Thi Z', 'tranthiz@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0900112234', '111 Twenty-sixth Street, Kien Giang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(28, 'Le Van AA', 'levanaa@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0911223346', '112 Twenty-seventh Street, An Giang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(29, 'Pham Thi BB', 'phamthibb@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0922334457', '113 Twenty-eighth Street, Dong Thap', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(30, 'Hoang Van CC', 'hoangvancc@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0933445568', '114 Twenty-ninth Street, Ben Tre', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(31, 'Vu Thi DD', 'vuthidd@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0944556679', '115 Thirtieth Street, Tien Giang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(32, 'Nguyen Van EE', 'nguyenvanee@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0955667790', '116 Thirty-first Street, Tra Vinh', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(33, 'Tran Thi FF', 'tranthiff@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0966778891', '117 Thirty-second Street, Vinh Long', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(34, 'Le Van GG', 'levangg@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0977889902', '118 Thirty-third Street, Hau Giang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(35, 'Pham Thi HH', 'phamthihh@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0988990013', '119 Thirty-fourth Street, Can Tho', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(36, 'Hoang Van II', 'hoangvanii@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0999001124', '120 Thirty-fifth Street, Soc Trang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(37, 'Vu Thi JJ', 'vuthijj@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0900112235', '121 Thirty-sixth Street, Bac Lieu', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(38, 'Nguyen Van KK', 'nguyenvankk@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0911223347', '122 Thirty-seventh Street, Ca Mau', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(39, 'Tran Thi LL', 'tranthill@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0922334458', '123 Thirty-eighth Street, Kien Giang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(40, 'Le Van MM', 'levanmm@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0933445569', '124 Thirty-ninth Street, An Giang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(41, 'Pham Thi NN', 'phamthinn@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0944556680', '125 Fortieth Street, Dong Thap', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(42, 'Hoang Van OO', 'hoangvanoo@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0955667791', '126 Forty-first Street, Ben Tre', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(43, 'Vu Thi PP', 'vuthipp@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0966778892', '127 Forty-second Street, Tien Giang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(44, 'Nguyen Van QQ', 'nguyenvanqq@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0977889903', '128 Forty-third Street, Tra Vinh', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(45, 'Tran Thi RR', 'tranthirr@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0988990014', '129 Forty-fourth Street, Vinh Long', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(46, 'Le Van SS', 'levanss@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0999001125', '130 Forty-fifth Street, Hau Giang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(47, 'Pham Thi TT', 'phamthitt@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0900112236', '131 Forty-sixth Street, Can Tho', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(48, 'Hoang Van UU', 'hoangvanuu@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0911223348', '132 Forty-seventh Street, Soc Trang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(49, 'Vu Thi VV', 'vuthivv@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0922334459', '133 Forty-eighth Street, Bac Lieu', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(50, 'Nguyen Van WW', 'nguyenvanww@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0933445570', '134 Forty-ninth Street, Ca Mau', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 1, '2025-05-15 01:18:03', 'active'),
(51, 'Tran Thi XX', 'tranthixx@example.com', '$2y$10$d31ZXYnqsNjHA6tx1887M.iUZkWk27QKpkWtgOScT02qK0/WknEtu', '0944556681', '135 Fiftieth Street, Kien Giang', '../assets/avatar/customes/avatar_customes6826d5ca29d129.92788014.jpg', 0, '2025-05-15 01:18:03', 'active'),
(52, 'Nguyễn Thị Nga ', '', '', '0235243634', 'TDP Sơn Hải-Phường Ninh Hải', NULL, NULL, '2025-05-22 07:02:16', 'active');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `position` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `role` enum('staff') NOT NULL DEFAULT 'staff',
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `phone`, `date_of_birth`, `address`, `password`, `position`, `status`, `role`, `avatar`, `created_at`) VALUES
(1, 'Lê Thanh Hoàng Anh ', 'ks.daibang86@gmail.com', '0587331244', '2005-06-12', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Delivery Staff', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-14 23:55:06'),
(4, 'Pham Van D', 'phamvand@example.com', '0901234567', '1990-01-01', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Manager', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(5, 'Hoang Thi E', 'hoangthie@example.com', '0934567890', '1995-05-05', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Sales', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(6, 'Nguyen Van F', 'nguyenvanf@example.com', '0912345678', '1988-03-12', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Accountant', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(7, 'Tran Thi G', 'tranthig@example.com', '0923456789', '1992-07-21', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Sales', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(8, 'Le Van H', 'levanh@example.com', '0934567891', '1985-11-30', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Manager', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(9, 'Pham Thi I', 'phamthii@example.com', '0945678912', '1993-09-15', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Accountant', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(10, 'Hoang Van J', 'hoangvanj@example.com', '0956789123', '1989-12-25', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Sales', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(11, 'Vu Thi K', 'vuthik@example.com', '0967891234', '1991-06-18', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Manager', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(12, 'Nguyen Van L', 'nguyenvanl@example.com', '0978912345', '1987-04-09', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Sales', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(13, 'Tran Thi M', 'tranthim@example.com', '0989123456', '1994-08-22', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Accountant', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(14, 'Le Van N', 'levann@example.com', '0991234567', '1996-02-14', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Sales', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(15, 'Pham Thi O', 'phamthio@example.com', '0902345678', '1986-10-05', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Manager', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(16, 'Hoang Van P', 'hoangvanp@example.com', '0913456789', '1990-03-17', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Sales', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(17, 'Vu Thi Q', 'vuthiq@example.com', '0924567890', '1992-12-29', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Accountant', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(18, 'Nguyen Van R', 'nguyenvanr@example.com', '0935678901', '1988-07-11', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Sales', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(19, 'Tran Thi S', 'tranthis@example.com', '0946789012', '1993-05-23', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Manager', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(20, 'Le Van T', 'levant@example.com', '0957890123', '1989-09-03', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Sales', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(21, 'Pham Thi U', 'phamthiu@example.com', '0968901234', '1991-01-27', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Accountant', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(22, 'Hoang Van V', 'hoangvanv@example.com', '0979012345', '1987-06-16', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Sales', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55'),
(23, 'Vu Thi W', 'vuthiw@example.com', '0980123456', '1994-11-08', 'Thanh Hóa', '$2y$10$HM/cKXYcQDeDbOuOtiDVSOL.D4M.5rRziA9mWxB7qWlp1lfkX4xpe', 'Manager', 'active', 'staff', '../assets/avatar/employees/avatar_employess682639c9877d46.50557950.jpg', '2025-05-15 01:36:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `name`, `address`, `phone`, `payment_method`, `notes`, `total`, `created_at`, `status`) VALUES
(1, 1, 'Nguyễn Thị Nga ', 'TDP Sơn Hải-Phường Ninh Hải', '0235243634', 'cod', '', 13028488, '2025-05-23 14:31:46', 'delivered'),
(2, 1, 'Nguyễn Thị Nga ', 'TDP Sơn Hải-Phường Ninh Hải', '0235243634', 'cod', 'Giao buổi chiều giúp tôi', 4569460, '2025-05-23 14:32:32', 'delivered'),
(3, 1, 'Nguyễn Thị Nga ', 'TDP Sơn Hải-Phường Ninh Hải', '0235243634', 'cod', '', 703815, '2025-05-23 14:42:37', 'delivered'),
(4, 1, 'Nguyễn Thị Nga ', 'TDP Sơn Hải-Phường Ninh Hải', '0235243634', 'cod', '', 1648575, '2025-05-23 14:47:06', 'delivered'),
(5, 1, 'Nguyễn Thị Nga ', 'TDP Sơn Hải-Phường Ninh Hải', '0235243634', 'cod', 'Tôi muốn nhận giờ\r\n', 743536, '2025-05-23 15:24:44', 'delivered');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `price`, `quantity`, `color`, `size`, `image`, `product_id`) VALUES
(1, 1, 'Áo Sơ Mi Nữ Công Sở (Đen, M)', 939892, 14, 'Đen', 'M', '../assets/product/product6829dfc23f6dd6.95252072.jpg', 2),
(2, 2, 'Áo Sơ Mi Nữ Công Sở', 939892, 5, 'Đen', 'M', '../assets/product/product6829dfc23f6dd6.95252072.jpg', 2),
(3, 3, 'Áo Thun Nam Cổ Tròn (Đen, M)', 833815, 1, 'Đen', 'M', '../assets/product/product6829dfc23f6dd6.95252072.jpg', 24),
(4, 4, 'Áo Thun Nam Thể Thao', 997158, 1, 'Đen', 'M', '../assets/product/product6829dfc23f6dd6.95252072.jpg', 21),
(5, 4, 'Áo Thun Nữ Tay Lỡ', 781417, 1, 'Đen', 'M', '../assets/product/product6829dfc23f6dd6.95252072.jpg', 22),
(6, 5, 'Áo Thun Nam Basic (Đen, M)', 873536, 1, 'Đen', 'M', '../assets/product/product683030ab861f15.40568707.jpg', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(400) NOT NULL,
  `code` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `original_price` float NOT NULL,
  `category` varchar(255) NOT NULL,
  `subcategory` varchar(255) NOT NULL,
  `stock` float NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'active',
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `code`, `price`, `original_price`, `category`, `subcategory`, `stock`, `status`, `description`, `image`) VALUES
(1, 'Áo Thun Nam Basic', 'CLO001', 873536, 5568580, 'men', 'hoodie', 1000, 'active', 'Áo thun nam chất liệu cotton thoáng mát.', '../assets/product/product683030ab861f15.40568707.jpg'),
(2, 'Áo Sơ Mi Nữ Công Sở', 'CLO002', 939892, 1218280, 'women', 'thun', 80, 'active', 'Áo sơ mi nữ kiểu dáng thanh lịch, phù hợp công sở.', '../assets/product/product68303720eb2689.92506674.jpg'),
(3, 'Quần Jean Nam Skinny', 'CLO003', 1028850, 3577260, 'women', 'jeans', 60, 'active', 'Quần jean nam skinny co giãn, trẻ trung.', '../assets/product/product68303731231177.18950514.jpg'),
(4, 'Váy Đầm Dạ Hội', 'CLO004', 924579, 4917160, 'Clothing', 'Hoodie', 30, 'active', 'Váy đầm dạ hội sang trọng, phù hợp dự tiệc.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(5, 'Áo Khoác Bomber Nam', 'CLO005', 836341, 5286050, 'Clothing', 'Hoodie', 45, 'active', 'Áo khoác bomber nam cá tính, giữ ấm tốt.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(6, 'Quần Short Nữ Thể Thao', 'CLO006', 707970, 7824310, 'women', 'jeans', 100, 'active', 'Quần short nữ thể thao năng động.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(7, 'Áo Hoodie Unisex', 'CLO007', 1030830, 5723040, 'Clothing', 'Hoodie', 70, 'active', 'Áo hoodie unisex trẻ trung, cá tính.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(8, 'Chân Váy Xếp Ly', 'CLO008', 930217, 2285960, 'Clothing', 'Hoodie', 55, 'active', 'Chân váy xếp ly nữ tính, dễ phối đồ.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(9, 'Áo Polo Nam', 'CLO009', 858608, 5467320, 'Clothing', 'Hoodie', 90, 'active', 'Áo polo nam lịch sự, phù hợp đi làm.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(10, 'Quần Tây Nữ Công Sở', 'CLO010', 802390, 4860730, 'Clothing', 'Hoodie', 65, 'active', 'Quần tây nữ công sở thanh lịch.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(11, 'Áo Khoác Gió Nữ', 'CLO011', 736126, 3912190, 'Clothing', 'Hoodie', 50, 'active', 'Áo khoác gió nữ nhẹ, chống nước.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(12, 'Váy Maxi Hoa Nhí', 'CLO012', 923460, 8538120, 'Clothing', 'Hoodie', 40, 'active', 'Váy maxi hoa nhí dịu dàng, nữ tính.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(13, 'Áo Thun Trơn Unisex', 'CLO013', 1008920, 4894350, 'Clothing', 'Hoodie', 110, 'active', 'Áo thun trơn unisex nhiều màu sắc.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(14, 'Quần Jogger Nam', 'CLO014', 874238, 6740900, 'Clothing', 'Hoodie', 75, 'active', 'Quần jogger nam thể thao, co giãn tốt.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(15, 'Áo Len Nữ Dệt Kim', 'CLO015', 994417, 3792970, 'Clothing', 'Hoodie', 60, 'active', 'Áo len nữ dệt kim ấm áp, thời trang.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(16, 'Áo Khoác Dạ Nam', 'CLO016', 949373, 2809030, 'Clothing', 'Hoodie', 35, 'active', 'Áo khoác dạ nam sang trọng, giữ ấm tốt.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(17, 'Quần Legging Nữ', 'CLO017', 713615, 7194630, 'Clothing', 'Hoodie', 95, 'active', 'Quần legging nữ co giãn, thoải mái.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(18, 'Áo Sơ Mi Nam Caro', 'CLO018', 719955, 9066170, 'Clothing', 'Hoodie', 85, 'active', 'Áo sơ mi nam caro trẻ trung, năng động.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(19, 'Váy Công Sở Nữ', 'CLO019', 758931, 8774340, 'Clothing', 'Hoodie', 50, 'active', 'Váy công sở nữ thanh lịch, hiện đại.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(20, 'Áo Khoác Jean Nữ', 'CLO020', 934790, 5506480, 'Clothing', 'Hoodie', 40, 'active', 'Áo khoác jean nữ cá tính, dễ phối đồ.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(21, 'Áo Thun Nam Thể Thao', 'CLO021', 997158, 2278040, 'Clothing', 'thun', 100, 'active', 'Áo thun nam thể thao, thấm hút mồ hôi.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(22, 'Áo Thun Nữ Tay Lỡ', 'CLO022', 781417, 3884430, 'Clothing', 'thun', 80, 'active', 'Áo thun nữ tay lỡ, chất liệu mềm mại.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(23, 'Áo Thun Unisex In Hình', 'CLO023', 915613, 2564460, 'Clothing', 'thun', 120, 'active', 'Áo thun unisex in hình cá tính.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(24, 'Áo Thun Nam Cổ Tròn', 'CLO024', 833815, 7929190, 'Clothing', 'thun', 90, 'active', 'Áo thun nam cổ tròn, đơn giản, dễ mặc.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(25, 'Áo Thun Nữ Form Rộng', 'CLO025', 722235, 2271350, 'Clothing', 'thun', 70, 'active', 'Áo thun nữ form rộng, trẻ trung, năng động.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(116, 'Áo Thun Nữ Form Rộng', 'CL000021', 759730, 7974640, 'Clothing', 'thun', 120, 'active', 'Áo thun nữ form rộng, chất liệu cotton thoáng mát.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(117, 'Áo Thun Nam Tay Ngắn', 'CL00022', 931947, 4090410, 'Clothing', 'thun', 100, 'active', 'Áo thun nam tay ngắn, trẻ trung, năng động.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(118, 'Áo Thun Unisex In Hình', 'CL00023', 980543, 9874210, 'Clothing', 'thun', 90, 'active', 'Áo thun unisex in hình cá tính, phù hợp mọi giới tính.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(119, 'Áo Thun Nam Cổ Tròn', 'CL00024', 706874, 8667620, 'Clothing', 'thun', 80, 'active', 'Áo thun nam cổ tròn, đơn giản, dễ phối đồ.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(120, 'Áo Thun Nữ Tay Lỡ', 'CL00025', 942742, 1385460, 'Clothing', 'thun', 110, 'active', 'Áo thun nữ tay lỡ, phong cách Hàn Quốc.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(121, 'Áo Thun Nam In Chữ', 'CL00026', 843086, 6784610, 'Clothing', 'thun', 95, 'active', 'Áo thun nam in chữ nổi bật, cá tính.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(122, 'Áo Thun Nữ Croptop', 'CL00027', 1037210, 6852690, 'Clothing', 'thun', 70, 'active', 'Áo thun nữ croptop trẻ trung, năng động.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(123, 'Áo Thun Nam Basic', 'CL00028', 906773, 8072980, 'Clothing', 'thun', 130, 'active', 'Áo thun nam basic, phù hợp mặc hàng ngày.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(124, 'Áo Thun Nữ In Hoa', 'CL00029', 722244, 6811450, 'Clothing', 'thun', 85, 'active', 'Áo thun nữ in hoa nhẹ nhàng, nữ tính.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(125, 'Áo Thun Nam Oversize', 'CL00030', 890902, 7972990, 'Clothing', 'thun', 60, 'active', 'Áo thun nam oversize, phong cách streetwear.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(126, 'Áo Thun Nữ Cổ Tim', 'CL00031', 887780, 8183610, 'Clothing', 'thun', 75, 'active', 'Áo thun nữ cổ tim, tôn dáng, dễ thương.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(127, 'Áo Thun Nam Thể Thao', 'CL00032', 716192, 5440720, 'Clothing', 'thun', 90, 'active', 'Áo thun nam thể thao, thấm hút mồ hôi tốt.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(128, 'Áo Thun Nữ Tay Dài', 'CL00033', 917619, 9609280, 'Clothing', 'thun', 100, 'active', 'Áo thun nữ tay dài, phù hợp mùa thu đông.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(129, 'Áo Thun Nam In Logo', 'CL00034', 1039520, 2898090, 'Clothing', 'thun', 80, 'active', 'Áo thun nam in logo thương hiệu nổi bật.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(130, 'Áo Thun Nữ Form Ôm', 'CL00035', 1044750, 4809150, 'Clothing', 'thun', 60, 'active', 'Áo thun nữ form ôm, tôn dáng, quyến rũ.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(131, 'Quần Jean Nữ Skinny', 'JEANS001', 705184, 7547130, 'Clothing', 'jeans', 80, 'active', 'Quần jean nữ skinny co giãn, tôn dáng.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(132, 'Quần Jean Nam Rách Gối', 'JEANS002', 741670, 3431300, 'Clothing', 'jeans', 60, 'active', 'Quần jean nam rách gối phong cách cá tính.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(133, 'Quần Jean Nữ Lưng Cao', 'JEANS003', 892800, 10276400, 'Clothing', 'jeans', 70, 'active', 'Quần jean nữ lưng cao, dễ phối đồ.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(134, 'Quần Jean Nam Ống Đứng', 'JEANS004', 838988, 9420460, 'Clothing', 'jeans', 65, 'active', 'Quần jean nam ống đứng cổ điển.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(135, 'Quần Jean Nữ Ống Rộng', 'JEANS005', 816542, 8436740, 'Clothing', 'jeans', 55, 'active', 'Quần jean nữ ống rộng thời trang.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(136, 'Quần Jean Nam Xanh Đậm', 'JEANS006', 865743, 5364660, 'Clothing', 'jeans', 75, 'active', 'Quần jean nam màu xanh đậm, trẻ trung.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(137, 'Quần Jean Nữ Baggy', 'JEANS007', 829091, 4973560, 'Clothing', 'jeans', 50, 'active', 'Quần jean nữ baggy năng động.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(138, 'Quần Jean Nam Slim Fit', 'JEANS008', 848226, 6605460, 'Clothing', 'jeans', 60, 'active', 'Quần jean nam slim fit hiện đại.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(139, 'Quần Jean Nữ Rách Nhẹ', 'JEANS009', 703858, 2755970, 'Clothing', 'jeans', 45, 'active', 'Quần jean nữ rách nhẹ cá tính.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(140, 'Quần Jean Nam Lưng Thun', 'JEANS010', 974612, 4429350, 'Clothing', 'jeans', 70, 'active', 'Quần jean nam lưng thun thoải mái.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(141, 'Quần Jean Nữ Ống Loe', 'JEANS011', 1011480, 5541760, 'Clothing', 'jeans', 40, 'active', 'Quần jean nữ ống loe phong cách retro.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(142, 'Quần Jean Nam Wash Sáng', 'JEANS012', 733585, 9192450, 'Clothing', 'jeans', 55, 'active', 'Quần jean nam wash sáng trẻ trung.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(143, 'Quần Jean Nữ Lửng', 'JEANS013', 983471, 1531110, 'Clothing', 'jeans', 65, 'active', 'Quần jean nữ lửng cá tính.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(144, 'Quần Jean Nam Ống Suông', 'JEANS014', 966603, 8017650, 'Clothing', 'jeans', 50, 'active', 'Quần jean nam ống suông thoải mái.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(145, 'Quần Jean Nữ Xanh Nhạt', 'JEANS015', 832602, 3942290, 'Clothing', 'jeans', 60, 'active', 'Quần jean nữ màu xanh nhạt trẻ trung.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(146, 'Quần Jean Nam Đen', 'JEANS016', 913199, 800700, 'Clothing', 'jeans', 55, 'active', 'Quần jean nam màu đen lịch lãm.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(147, 'Quần Jean Nữ Lưng Thun', 'JEANS017', 1018190, 7278430, 'Clothing', 'jeans', 70, 'active', 'Quần jean nữ lưng thun thoải mái.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(148, 'Quần Jean Nam Ống Rộng', 'JEANS018', 951352, 5182830, 'Clothing', 'jeans', 45, 'active', 'Quần jean nam ống rộng cá tính.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(149, 'Quần Jean Nữ Wash Sáng', 'JEANS019', 1002190, 6688680, 'Clothing', 'jeans', 60, 'active', 'Quần jean nữ wash sáng năng động.', '../assets/product/product6829dfc23f6dd6.95252072.jpg'),
(150, 'Quần Jean Nam Baggy', 'JEANS020', 756904, 2336830, 'Clothing', 'jeans', 50, 'active', 'Quần jean nam baggy trẻ trung.', '../assets/product/product6829dfc23f6dd6.95252072.jpg');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart_item` (`customer_id`,`product_id`,`color`,`size`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Chỉ mục cho bảng `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact_settings`
--
ALTER TABLE `contact_settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `phone` (`phone`);

--
-- Chỉ mục cho bảng `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `phone` (`phone`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_customer` (`customer_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category` (`category`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contact_settings`
--
ALTER TABLE `contact_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
