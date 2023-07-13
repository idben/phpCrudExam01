-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2023 年 07 月 13 日 17:23
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `myProject`
--

-- --------------------------------------------------------

--
-- 資料表結構 `category`
--

CREATE TABLE `category` (
  `id` int(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `createTime` datetime DEFAULT NULL,
  `modifyTime` datetime DEFAULT NULL,
  `isValid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `category`
--

INSERT INTO `category` (`id`, `name`, `createTime`, `modifyTime`, `isValid`) VALUES
(1, '蛋糕', '2023-07-13 18:02:30', '2023-07-13 18:59:06', 1),
(2, '冷飲', '2023-07-13 18:03:05', NULL, 1),
(3, '熱飲', '2023-07-13 18:03:13', NULL, 1),
(4, '正餐', '2023-07-13 18:03:30', NULL, 1),
(5, '酒類', '2023-07-13 18:03:37', NULL, 1),
(6, '點心鹹食', '2023-07-13 18:03:55', NULL, 1),
(7, '下酒菜', '2023-07-13 18:04:08', NULL, 1),
(8, '午間套餐', '2023-07-13 18:04:30', NULL, 1),
(9, '晚上套餐', '2023-07-13 18:04:38', NULL, 1),
(10, '假日套餐', '2023-07-13 18:04:46', NULL, 1),
(11, '兒童餐', '2023-07-13 18:05:07', NULL, 1),
(12, '港式點心', '2023-07-13 18:20:34', '2023-07-13 18:24:50', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(5) NOT NULL DEFAULT 0,
  `info` text NOT NULL,
  `category` int(5) NOT NULL DEFAULT 0,
  `createTime` datetime DEFAULT NULL,
  `modifyTime` datetime DEFAULT NULL,
  `isValid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `info`, `category`, `createTime`, `modifyTime`, `isValid`) VALUES
(1, '全新鮮奶油草莓蛋糕 6吋', 920, '因疫情嚴峻，黑貓宅配公告為配合防疫，5/9起配送時間可能會有延遲情況發生，且無法指定配送時間段，造成您的不便敬請見諒。\r\n六吋鮮奶油草莓蛋糕，搭配進口草莓內餡，經典草莓口味蛋糕體。\r\n隨蛋糕附贈問號蠟燭，如有其他特殊需求請在備註欄填寫。\r\n\r\n', 1, '2023-07-13 20:52:38', '2023-07-13 22:30:22', 1),
(2, '鮮奶油水果蛋糕 8吋-12吋', 1500, '因疫情嚴峻，黑貓宅配公告為配合防疫，5/9起配送時間可能會有延遲情況發生，且無法指定配送時間段，造成您的不便敬請見諒。\r\n六吋鮮奶油草莓蛋糕，搭配進口草莓內餡，經典草莓口味蛋糕體。\r\n隨蛋糕附贈問號蠟燭，如有其他特殊需求請在備註欄填寫。', 1, '2023-07-13 20:57:04', '2023-07-13 21:51:45', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `product_img`
--

CREATE TABLE `product_img` (
  `id` int(10) NOT NULL,
  `pid` int(3) NOT NULL,
  `file` varchar(50) NOT NULL,
  `createTime` datetime DEFAULT NULL,
  `isValid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `product_img`
--

INSERT INTO `product_img` (`id`, `pid`, `file`, `createTime`, `isValid`) VALUES
(1, 1, '1689252758.png', '2023-07-13 20:52:38', 1),
(2, 1, '1689252759.png', '2023-07-13 20:52:38', 1),
(3, 1, '1689252760.png', '2023-07-13 20:52:38', 1),
(4, 2, '1689253024.png', '2023-07-13 20:57:04', 1),
(5, 2, '1689253025.png', '2023-07-13 20:57:04', 1),
(6, 2, '1689253026.png', '2023-07-13 20:57:04', 1),
(7, 2, '1689253027.png', '2023-07-13 20:57:04', 1),
(8, 2, '1689253028.png', '2023-07-13 20:57:04', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `product_tag`
--

CREATE TABLE `product_tag` (
  `id` int(10) NOT NULL,
  `pid` int(5) NOT NULL,
  `tid` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `product_tag`
--

INSERT INTO `product_tag` (`id`, `pid`, `tid`) VALUES
(48, 1, 1),
(49, 1, 2),
(50, 1, 4);

-- --------------------------------------------------------

--
-- 資料表結構 `tag`
--

CREATE TABLE `tag` (
  `id` int(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `createTime` datetime DEFAULT NULL,
  `modifyTime` datetime DEFAULT NULL,
  `isValid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `tag`
--

INSERT INTO `tag` (`id`, `name`, `createTime`, `modifyTime`, `isValid`) VALUES
(1, '甜食', '2023-07-13 18:45:51', '2023-07-13 18:48:30', 1),
(2, '蛋糕', '2023-07-13 18:46:30', NULL, 1),
(3, '小編推薦', '2023-07-13 18:46:43', NULL, 1),
(4, 'cake', '2023-07-13 18:48:01', NULL, 1),
(5, 'comfort food', '2023-07-13 18:48:19', NULL, 1),
(6, '鹹食', '2023-07-13 19:44:00', NULL, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `email` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `img` varchar(50) DEFAULT NULL,
  `level` int(2) DEFAULT 0,
  `createTime` datetime DEFAULT NULL,
  `modifyTime` datetime DEFAULT NULL,
  `isValid` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`id`, `email`, `name`, `password`, `img`, `level`, `createTime`, `modifyTime`, `isValid`) VALUES
(1, 'jc@gmail.com', 'Jacie Chen', '$2y$10$Ext7.MRAAxDSG1sQzhdpQeyzZD3jlTMQscQSIlnPTm97RnRvgkGpG', '1689240711.jpg', 1, '2023-07-13 15:48:12', '2023-07-13 18:58:48', 1),
(2, 'gy@gmail.com', 'Gregory Castillo', '$2y$10$IwL6YQMqqarBX/swiwF3e.HEyXjsuKgHwVd8a3hncH9eFqFJ1HgVy', '1689234599.jpg', 1, '2023-07-13 15:49:59', '2023-07-13 17:41:32', 1),
(3, 'rs@gmail.com', 'Russell Ray', '$2y$10$fkno4n8oeaxBb7.oCDryoOgk9Ayj7DRQyE8xrQA1Yg2DycVsEBUoi', '1689234634.jpg', 1, '2023-07-13 15:50:34', '2023-07-13 17:41:34', 1),
(4, 'ben@gmail.com', 'Ben Chen', '$2y$10$nm9frXdAJPMxnYpAFJSA2uXF3jFh4gyOkVoA3hC1rk/AC7Y1zNfmW', '1689234667.jpg', 9, '2023-07-13 15:51:07', '2023-07-13 17:41:37', 1),
(5, 'aben@gmail.com', 'ABen', '$2y$10$R6XMUvWYfe3hqp/8/Egi0ON.nfWLI72nE42l1KNcgxHS0JI4gX/QG', '1689236242.jpg', 1, '2023-07-13 16:17:22', '2023-07-13 17:41:39', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `product_img`
--
ALTER TABLE `product_img`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `product_tag`
--
ALTER TABLE `product_tag`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `category`
--
ALTER TABLE `category`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product`
--
ALTER TABLE `product`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_img`
--
ALTER TABLE `product_img`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_tag`
--
ALTER TABLE `product_tag`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
