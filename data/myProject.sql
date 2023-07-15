-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2023 年 07 月 15 日 10:42
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
  `uid` int(5) NOT NULL DEFAULT 0,
  `name` varchar(20) NOT NULL,
  `createTime` datetime DEFAULT NULL,
  `modifyTime` datetime DEFAULT NULL,
  `isValid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `category`
--

INSERT INTO `category` (`id`, `uid`, `name`, `createTime`, `modifyTime`, `isValid`) VALUES
(1, 5, '蛋糕', '2023-07-13 18:02:30', '2023-07-13 18:59:06', 1),
(2, 5, '冷飲', '2023-07-13 18:03:05', NULL, 1),
(3, 5, '熱飲', '2023-07-13 18:03:13', NULL, 1),
(4, 2, '正餐', '2023-07-13 18:03:30', NULL, 1),
(5, 2, '酒類', '2023-07-13 18:03:37', NULL, 1),
(6, 5, '點心鹹食', '2023-07-13 18:03:55', NULL, 1),
(7, 2, '下酒菜', '2023-07-13 18:04:08', NULL, 1),
(8, 2, '午間套餐', '2023-07-13 18:04:30', NULL, 1),
(9, 2, '晚上套餐', '2023-07-13 18:04:38', NULL, 1),
(10, 2, '假日套餐', '2023-07-13 18:04:46', NULL, 1),
(11, 2, '兒童餐', '2023-07-13 18:05:07', NULL, 1),
(12, 2, '港式點心', '2023-07-13 18:20:34', '2023-07-13 18:24:50', 1),
(13, 1, '小說', '2023-07-15 10:23:55', NULL, 1),
(14, 1, '漫畫', '2023-07-15 10:24:11', NULL, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `id` int(5) NOT NULL,
  `orderID` varchar(20) DEFAULT NULL,
  `uid` int(5) NOT NULL DEFAULT 0,
  `createTime` datetime DEFAULT NULL,
  `modifyTime` datetime DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `isValid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `orders`
--

INSERT INTO `orders` (`id`, `orderID`, `uid`, `createTime`, `modifyTime`, `status`, `isValid`) VALUES
(1, 'OD_16894_06521', 3, '2023-07-15 15:35:21', NULL, 0, 1),
(2, 'OD_16894_06579', 1, '2023-07-15 15:36:19', NULL, 0, 1),
(3, 'OD_16894_09237', 4, '2023-07-15 16:20:37', NULL, 0, 1),
(4, 'OD_16894_09483', 2, '2023-07-15 16:24:43', NULL, 0, 1),
(5, 'OD_16894_09504', 2, '2023-07-15 16:25:04', NULL, 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `orders_product`
--

CREATE TABLE `orders_product` (
  `id` int(5) NOT NULL,
  `oid` int(5) NOT NULL,
  `pid` int(5) NOT NULL,
  `num` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `orders_product`
--

INSERT INTO `orders_product` (`id`, `oid`, `pid`, `num`) VALUES
(1, 1, 5, 1),
(2, 1, 6, 1),
(3, 1, 7, 1),
(4, 2, 1, 2),
(5, 2, 2, 1),
(6, 3, 1, 10),
(7, 4, 2, 2),
(8, 5, 7, 4);

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL DEFAULT 0,
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

INSERT INTO `product` (`id`, `uid`, `name`, `price`, `info`, `category`, `createTime`, `modifyTime`, `isValid`) VALUES
(1, 5, '全新鮮奶油草莓蛋糕 6吋', 920, '<div class=\"text-danger\">因疫情嚴峻，黑貓宅配公告為配合防疫，5/9起配送時間可能會有延遲情況發生，且無法指定配送時間段，造成您的不便敬請見諒。</div>\r\n六吋鮮奶油草莓蛋糕，搭配進口草莓內餡，經典草莓口味蛋糕體。\r\n隨蛋糕附贈問號蠟燭，如有其他特殊需求請在備註欄填寫。\r\n\r\n', 1, '2023-07-13 20:52:38', '2023-07-15 09:51:46', 1),
(2, 5, '鮮奶油水果蛋糕 8吋-12吋', 1500, '因疫情嚴峻，黑貓宅配公告為配合防疫，5/9起配送時間可能會有延遲情況發生，且無法指定配送時間段，造成您的不便敬請見諒。\r\n六吋鮮奶油草莓蛋糕，搭配進口草莓內餡，經典草莓口味蛋糕體。\r\n隨蛋糕附贈問號蠟燭，如有其他特殊需求請在備註欄填寫。', 1, '2023-07-13 20:57:04', '2023-07-15 09:32:48', 1),
(5, 1, '擁有超常技能的異世界流浪美食家(1)', 155, '能力值只是假象！擁有網購（？）能力的他，將在異世界掀起波瀾!?\r\n\r\n向田剛志（穆寇達）從現代日本被召喚到劍與魔法的異世界裡去了。本來還以為會有什麼大冒險在等著，結果自己只是個被牽連進「勇者召喚」儀式的一般人！與真正的勇者（有３個人！）比起來，穆寇達的初始能力值實在有夠低……再加上召喚穆寇達等人到這世界的王國感覺不太對勁，在察覺到「啊，這些人企圖利用勇者」後，穆寇達便單獨離開城堡了。穆寇達在這異世界裡唯一可仰賴的，就是能夠將現代商品送到異世界來的固有技能『網路超市』。雖然不適合戰鬥，但若能好好運用，也許便不愁吃穿了？穆寇達本來抱著這般輕鬆的想法，沒想到卻發現了驚人的事實──？\r\n\r\n一旦吃了用這項技能購買來的現代「食品」，就會發生驚人的效果！再加上又有些不得了的傢伙們被異世界的食物所吸引，而聚集到了穆寇達身邊……!?\r\n「成為小說家吧」網站年度排行榜第一名的神奇異世界冒險故事，終於堂堂登場\r\n\r\n作者簡介【江口 連  Ren Eguchi】\r\n各位好，我是江口連。我雖然喜歡看電影和外國影集，但最近卻幾乎沒在看……目前正在計劃利用假日，把近來喜歡的外國影集借一整季回家看個痛快。\r\n\r\n', 13, '2023-07-15 10:31:45', '2023-07-15 10:33:28', 1),
(6, 1, '擁有超常技能的異世界流浪美食家(2)', 160, '女神、萌寵增量中！吃遍天下的旅程，將迎來新的夥伴！\r\n\r\n上班族穆寇達（向田剛志）被牽連進「勇者召喚」儀式，從現代日本來到了劍與魔法的異世界。穆寇達本來只能依賴可送來現代日本商品的固有技能「網路超市」，但傳說的魔獸芬里爾──緋爾卻衝著他做的料理而來，還成了穆寇達的從魔！之後又加入了史萊姆幼兒史伊，一行人繼續踏上優哉游哉的旅程。穆寇達有時以冒險者之姿颯爽（？）地拯救城鎮於危機之中，有時又以商人的身分抓住太太們的心（？）。而在這樣的旅途中，即將邂逅新的同伴……？\r\n\r\n另一方面，風之女神寧利勒依然從神界暗地向穆寇達索求供品，但她的偷跑行徑終於被其他女神們發覺了！而寧利勒的同事們自然也不會放過穆寇達的「網路超市」……!?\r\n\r\n「成為小說家吧」網站年度排行榜第１名的神奇異世界冒險故事，第２集堂堂登場！\r\n\r\n作者簡介【江口 連  Ren Eguchi】\r\n各位好，我是江口連。之前很難得地去電影院看電影，果然大畫面的魄力就是不一樣呢！再度感受到去借ＤＶＤ在家悠哉地欣賞雖然不錯，但於電影院裡觀賞果然也很讚。\r\n\r\n', 13, '2023-07-15 10:35:04', NULL, 1),
(7, 1, '擁有超常技能的異世界流浪美食家(3)', 150, '（被美食引來的）夥伴陣容漸趨龐大！進入迷宮歷險的眾人，將遭遇何種異常事態？\r\n\r\n穆寇達被牽連進「勇者召喚」儀式，從現代日本來到了異世界。就在他與從魔緋爾與史伊悠哉地旅行途中，又有其他女神們覬覦供品再度賜予庇佑，妖精龍小多拉也為了料理成為他的從魔，讓穆寇達一行人變得愈來愈強大。\r\n在這種超常狀態下依然表現得很遜砲的穆寇達，被緋爾牠們逼著去迷宮都市德蘭，心不甘情不願地決定進入迷宮探險。他被讓人深感遺憾的分會長糾纏，又被給人印象過於強烈的男神們強要酒喝，還狠下心買了大型爐子，為攻略迷宮而細心地進行準備（事先做好料理）。\r\n\r\n於是穆寇達一行人準備萬全後，終於要潛進迷宮了。這座迷宮面對著這群超乎常理的對象，究竟能夠撐多久呢……!?\r\n\r\n在「成為小說家吧」網站閱覽數超過２億５千萬的超常異世界冒險故事，令人瞠目結舌的第３集！\r\n\r\n作者簡介【江口 連  Ren Eguchi】\r\n各位好，我是江口連。最近我為了歇一口氣，一口氣租了之前很好奇的外國影集。雖然很擔心是否能在租賃期間看完，結果因為內容很有趣，讓我看得停不下來。既然已經稍作喘息，就來努力更新作品的進度吧，這是我現在的想法。話說回來，外國影集還真好看。\r\n\r\n', 13, '2023-07-15 10:37:09', NULL, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `product_img`
--

CREATE TABLE `product_img` (
  `id` int(10) NOT NULL,
  `uid` int(5) NOT NULL DEFAULT 0,
  `pid` int(3) NOT NULL,
  `file` varchar(50) NOT NULL,
  `createTime` datetime DEFAULT NULL,
  `isValid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `product_img`
--

INSERT INTO `product_img` (`id`, `uid`, `pid`, `file`, `createTime`, `isValid`) VALUES
(1, 5, 1, '1689252758.png', '2023-07-13 20:52:38', 1),
(2, 5, 1, '1689252759.png', '2023-07-13 20:52:38', 1),
(3, 5, 1, '1689252760.png', '2023-07-13 20:52:38', 1),
(4, 5, 2, '1689253024.png', '2023-07-13 20:57:04', 1),
(5, 5, 2, '1689253025.png', '2023-07-13 20:57:04', 1),
(6, 5, 2, '1689253026.png', '2023-07-13 20:57:04', 1),
(7, 5, 2, '1689253027.png', '2023-07-13 20:57:04', 1),
(8, 5, 2, '1689253028.png', '2023-07-13 20:57:04', 1),
(16, 0, 5, '1689388305.jpg', '2023-07-15 10:31:45', 1),
(17, 0, 6, '1689388504.jpg', '2023-07-15 10:35:04', 1),
(18, 0, 7, '1689388629.jpg', '2023-07-15 10:37:09', 1);

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
(51, 2, 1),
(52, 2, 2),
(53, 1, 1),
(54, 1, 2),
(55, 1, 4),
(58, 5, 8),
(59, 5, 9),
(60, 5, 10),
(61, 6, 8),
(62, 6, 9),
(63, 6, 10),
(64, 7, 8),
(65, 7, 9),
(66, 7, 10);

-- --------------------------------------------------------

--
-- 資料表結構 `tag`
--

CREATE TABLE `tag` (
  `id` int(5) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `name` varchar(20) NOT NULL,
  `createTime` datetime DEFAULT NULL,
  `modifyTime` datetime DEFAULT NULL,
  `isValid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `tag`
--

INSERT INTO `tag` (`id`, `uid`, `name`, `createTime`, `modifyTime`, `isValid`) VALUES
(1, 5, '甜食', '2023-07-13 18:45:51', '2023-07-13 18:48:30', 1),
(2, 5, '蛋糕', '2023-07-13 18:46:30', NULL, 1),
(3, 2, '小編推薦', '2023-07-13 18:46:43', NULL, 1),
(4, 2, 'cake', '2023-07-13 18:48:01', NULL, 1),
(5, 2, 'comfort food', '2023-07-13 18:48:19', NULL, 1),
(6, 2, '鹹食', '2023-07-13 19:44:00', NULL, 1),
(7, 1, '轉生', '2023-07-15 10:24:52', NULL, 1),
(8, 1, '異世界', '2023-07-15 10:26:06', NULL, 1),
(9, 1, '美食番', '2023-07-15 10:26:17', NULL, 1),
(10, 1, '召喚', '2023-07-15 10:33:15', '2023-07-15 10:38:33', 1);

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
(1, 'jc@gmail.com', '接西西', '$2y$10$VBd6unNnk4g4wbniLtDedOynPd9ZsYM3svg6X.lU8Lx5zjgAvJPre', '1689240711.jpg', 2, '2023-07-13 15:48:12', '2023-07-15 10:39:42', 1),
(2, 'gy@gmail.com', 'Gregory Castillo', '$2y$10$IwL6YQMqqarBX/swiwF3e.HEyXjsuKgHwVd8a3hncH9eFqFJ1HgVy', '1689234599.jpg', 1, '2023-07-13 15:49:59', '2023-07-13 17:41:32', 1),
(3, 'rs@gmail.com', 'Russell Ray', '$2y$10$fkno4n8oeaxBb7.oCDryoOgk9Ayj7DRQyE8xrQA1Yg2DycVsEBUoi', '1689234634.jpg', 1, '2023-07-13 15:50:34', '2023-07-13 17:41:34', 1),
(4, 'ben@gmail.com', 'Ben Chen', '$2y$10$nm9frXdAJPMxnYpAFJSA2uXF3jFh4gyOkVoA3hC1rk/AC7Y1zNfmW', '1689234667.jpg', 9, '2023-07-13 15:51:07', '2023-07-13 17:41:37', 1),
(5, 'aben@gmail.com', '阿BEN', '$2y$10$tdzbMcNgrAzlFYVzfAOIEOKoAMspy3uHaQ07qBd8SmNe3v9ICScfK', '1689384724.jpg', 1, '2023-07-13 16:17:22', '2023-07-15 10:39:57', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `orders_product`
--
ALTER TABLE `orders_product`
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
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orders_product`
--
ALTER TABLE `orders_product`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product`
--
ALTER TABLE `product`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_img`
--
ALTER TABLE `product_img`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_tag`
--
ALTER TABLE `product_tag`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
