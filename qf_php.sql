-- phpMyAdmin SQL Dump
-- version 4.4.15.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-08-22 15:59:48
-- 服务器版本： 5.5.48-log
-- PHP Version: 7.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qf_php`
--

-- --------------------------------------------------------

--
-- 表的结构 `qf_admin`
--

CREATE TABLE IF NOT EXISTS `qf_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `pwd` char(32) CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `qf_admin`
--

INSERT INTO `qf_admin` (`id`, `name`, `pwd`, `create_time`) VALUES
(1, 'admin', 'd92e10938a91accb632d71175a7549dd', 1495526072),
(2, 'yx_admin', '6baedcb9bdd0fa51714e0308243e51cb', 1496237673),
(3, 'wz_admin', 'a66824169e2322f3977bb8bca0e0b1cb', 1496237716);

-- --------------------------------------------------------

--
-- 表的结构 `qf_record`
--

CREATE TABLE IF NOT EXISTS `qf_record` (
  `r_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL COMMENT '用户ID',
  `h_id` int(11) NOT NULL COMMENT '谁帮助的用户ID',
  `h_money` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '助力金额',
  `register_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `qf_record`
--

INSERT INTO `qf_record` (`r_id`, `u_id`, `h_id`, `h_money`, `register_time`) VALUES
(1, 3, 4, '3.41', 1501582203),
(2, 3, 5, '4.33', 1501582321),
(5, 3, 6, '4.71', 1501584792),
(32, 3, 8, '10.44', 1501837482),
(33, 3, 3, '11.29', 1501837964),
(34, 3, 9, '14.76', 1501838915),
(35, 3, 5, '14.73', 1501839246),
(36, 3, 10, '3.00', 1501839246),
(37, 3, 11, '3.30', 1501839246),
(38, 3, 12, '1.00', 1501839246),
(39, 3, 13, '3.20', 1501839246),
(40, 3, 14, '4.00', 1501839246),
(41, 3, 15, '2.00', 1501839246),
(42, 3, 16, '1.50', 1501839246),
(43, 3, 17, '2.00', 1501839246),
(44, 3, 18, '5.00', 1501839246),
(45, 3, 19, '6.00', 1501839246),
(50, 3, 20, '3.03', 1502066248),
(51, 20, 20, '11.06', 1502066347),
(52, 5, 5, '14.00', 1502066779),
(53, 21, 21, '10.25', 1502072724),
(66, 3, 7, '4.50', 1502078162),
(67, 5, 5, '11.41', 1502079088),
(78, 5, 3, '3.05', 1502106340),
(79, 23, 23, '14.31', 1502109024),
(80, 24, 24, '10.05', 1502186713),
(81, 10, 10, '11.86', 1502186881),
(82, 24, 3, '4.91', 1502186927),
(83, 32, 32, '12.48', 1502208306),
(84, 9, 9, '13.59', 1502344686),
(85, 23, 3, '3.92', 1502606556),
(86, 22, 5, '4.96', 1502776464),
(87, 22, 22, '12.47', 1502776486),
(88, 5, 22, '4.10', 1502776527),
(91, 22, 3, '3.29', 1502787313);

-- --------------------------------------------------------

--
-- 表的结构 `qf_user`
--

CREATE TABLE IF NOT EXISTS `qf_user` (
  `id` int(11) NOT NULL,
  `wx_openid` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '微信openid',
  `wx_name` varchar(50) CHARACTER SET utf8mb4 NOT NULL COMMENT '微信昵称',
  `wx_headimgurl` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '微信头像',
  `help_money` decimal(7,2) NOT NULL DEFAULT '0.00',
  `help_num` int(11) NOT NULL DEFAULT '0' COMMENT '助力人数',
  `real_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '真实姓名',
  `phone` char(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '手机号码',
  `m_money` float DEFAULT NULL COMMENT '自己抢的金额',
  `status` tinyint(11) NOT NULL DEFAULT '0' COMMENT '助力到1000标识',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `over_time` int(11) NOT NULL COMMENT '完成时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `from_stu` int(4) DEFAULT '1' COMMENT '为1是网络咨询，2是院校',
  `ispay` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否缴费1是交费'
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `qf_user`
--

INSERT INTO `qf_user` (`id`, `wx_openid`, `wx_name`, `wx_headimgurl`, `help_money`, `help_num`, `real_name`, `phone`, `m_money`, `status`, `create_time`, `over_time`, `update_time`, `from_stu`, `ispay`) VALUES
(3, 'oOeQPxN4YBxFe7MhXLtwtBrulCzM', '王丽娟😎', 'http://wx.qlogo.cn/mmhead/Q3auHgzwzM4OvBNF5cpFetg83cxNGc56ibBHGAK2TRobYWEmtNqaIpQ/0', '0.00', 0, NULL, NULL, NULL, 0, 1500606719, 0, 1502096531, 1, 1),
(4, 'oOeQPxGiDVW2aQPFmz8kM5qw4apI', '洪涛同學', 'http://wx.qlogo.cn/mmopen/d2fJZTzRTumRibrBTEh4UXbnHQOzhiaKuHnPzdzPapwpXGXrGpzaR6OMH6Nibk2ckpLxdsnyvCOibtI1wDQHMwUmJkznk8icFaBEg/0', '0.00', 0, NULL, NULL, NULL, 0, 1500884191, 0, 1500884191, 1, 0),
(5, 'oOeQPxJz41xHSf1ZXqfTU6rPdxro', '白开水一样', 'http://wx.qlogo.cn/mmopen/KJjIsr1BPnQlr9Wq2ia0G5GicnMYMPItnQXZeG1GxkHZdDZ6BAPQichy3Ke6uAX7sn1earrcuwlEjBibicRNPjc2PorEkkMTbgSzO/0', '32.56', 4, '薛美娟', '17801072011', 11.41, 2, 1501564099, 0, 1502776527, 2, 0),
(6, 'oOeQPxPJ6d80dWAo4IVgJkU2c8_I', '婷', 'http://wx.qlogo.cn/mmopen/AqEIVwciaRtiaSbJdKZNG5BLcL6DIdqkWBClfHBndfFGia2fQEHfEolplxeGjCTbqg4cPexVSicklRHKGzQIiaJfxGOJ4eusI4ILJ/0', '204.06', 30, '马婷', '13260351938', NULL, 1, 1501586416, 0, 1502097856, 1, 0),
(7, 'oOeQPxPK2yeDZL3o57g5nylfEOIg', 'Hello World', 'http://wx.qlogo.cn/mmopen/AqEIVwciaRtgprRibEK83dI4lgnLbqtD6w5X0Ars5AcsnY2EQAIsJ7ZZAf6eDqgeHpRkEtHEQRmcPEsrfbuC2hrbYyODtXyXjp/0', '0.00', 0, '陈蔚磊', '13211760635', NULL, 0, 1501666811, 0, 1501667960, 1, 0),
(8, 'oOeQPxNt9_YUfGHuNV-ZYLCmIt7I', 'My name are HAPPY', 'http://wx.qlogo.cn/mmopen/d2fJZTzRTumRibrBTEh4UXYTfGyPpny15wbh6nY69nw0PnjqesTic5uCiblF0ib2q73rMLd1J0hUccCcDgm2NKCH605nUHaIAW3u/0', '0.00', 0, NULL, NULL, NULL, 0, 1495782479, 1495782479, 1495782479, 1, 0),
(9, 'oOeQPxI-RX5CqwpU1j-lsOEMufOI', 'wwwww', 'http://wx.qlogo.cn/mmopen/AqEIVwciaRthYiaKjGjibvWyib9eQBulObWCqEnwQ2uRwseETQUMFz9ZliaPx2yBbupd6ytkS6cZTuMMtAtB61VwKsQXMpkRa4u2T/0', '13.59', 1, 'ertgg', '13688854688', 13.59, 2, 1495782479, 1495782479, 1502344686, 1, 0),
(10, 'oOeQPxP7oXJekGkLn-MYgnCKMMJs', 'jingjing', 'http://wx.qlogo.cn/mmopen/AqEIVwciaRtjnCrrPmadtfxFpic7uFiaicAC3RFUW8KTQzG4BSWch33IzKosu0rrdia7YSE0JVT6o5VWJKyGbBlULtQ/0', '11.86', 1, '王静', '18611551266', 11.86, 2, 1496295024, 1496295024, 1502186881, 1, 0),
(11, 'oOeQPxK-QihAHQV4oKDhN9T9isYI', 'honghong', 'http://wx.qlogo.cn/mmopen/d2fJZTzRTun0jlXK7vpXs6vFl49tr3JKRhbuiaP1U6ebQXbldg7tmT454UBTUTacuaA2yHq1LT5QgcTAsuoiawqA/0', '0.00', 0, NULL, NULL, NULL, 0, 1496295024, 1496295024, 1496295024, 1, 0),
(12, 'oOeQPxAR_sJx3zAvUJWKr7i0QiGA', 'guwei', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEKGALFEpALhCHc71Z5NflaVicWm0iaEJ6HUpbpiaKo6XPWlx2Sksxq3E8fc1qglOt09rrAfY5ctLyoibw/0', '0.00', 0, NULL, NULL, NULL, 0, 1496295024, 1496295024, 1496295024, 1, 0),
(13, 'oOeQPxODpokGaoWeeMaRXDJkK-Bg', 'tiantian', 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM76bHg6kOs7N4y6OMEy7uHcia8Sgy7uPnc580SwtvKiaD8rZIS2lvnRhZ9GQ03jNA2ria8A05rVRsAsQ/0', '0.00', 0, NULL, NULL, NULL, 0, 1496295024, 1496295024, 1496295024, 1, 0),
(14, 'oOeQPxNkxRHfkQjxxDZM3RI8XzyQ', 'chuxin', 'http://wx.qlogo.cn/mmopen/AqEIVwciaRtiaeicCAicjZxh8Idz1U6FxCfaVfCoK3ktWqiclrKeMJwRpZDZYA1hDJ8SjQtAvWVASgiaQAAua50726hw/0', '0.00', 0, NULL, NULL, NULL, 0, 1496295024, 1496295024, 1496295024, 1, 0),
(15, 'oOeQPxJFDq8zWkXe4loWE4j8pjsM', 'dashu', 'http://wx.qlogo.cn/mmopen/AqEIVwciaRtiaSbJdKZNG5BAzspCPibVD9r2JHdoDWx4b58cehZxsTa33QRHibJhiaVMkLEDGiaaNOa5JfcOIQ5JUgLq6yMhBlN2via/0', '0.00', 0, NULL, NULL, NULL, 0, 1496295024, 1496295024, 1496295024, 1, 0),
(16, 'oOeQPxHZvESDm3YsorEgIouMXmiY', 'qiang', 'http://wx.qlogo.cn/mmopen/KJjIsr1BPnQlr9Wq2ia0G5Chlsd1D0GUKtBZ3QxPtLD29pmrqtN4EibS2Z8n25y6dfK5A0UaW6cAFKibTIrrWDvNibcLtdUYRnoh/0', '0.00', 0, NULL, NULL, NULL, 0, 1496295024, 1496295024, 1496295024, 1, 0),
(17, 'oOeQPxGPh0Cba-5n1oj1eTG9kueg', 'liubin', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEITRuU83fCpdBuwUvrkUPvWwDsnMCnKoIdicYqobQJzziahicGcwwekghPsLHicJD5KfV9K8gQZ4XUGNQ/0', '0.00', 0, NULL, NULL, NULL, 0, 1496295024, 1496295024, 1496295024, 1, 0),
(18, 'oOeQPxPZ0orzBmCtkZxU0bizyrAk', 'youyou', 'http://wx.qlogo.cn/mmopen/KJjIsr1BPnQlr9Wq2ia0G5BZlwpfoqkeDoMZO8WG8Fm1pTjgW7J4WkpGHSfUpkzkFVT7nNCbaQVy0FicjkAOuicD6FuRnWXT6SB/0', '0.00', 0, NULL, NULL, NULL, 0, 1496295024, 1496295024, 1496295024, 1, 0),
(19, 'oOeQPxA-bJNlPGteijQBzmNgrWmc', 'rongma', 'http://wx.qlogo.cn/mmopen/AqEIVwciaRtiaSbJdKZNG5BOCQHJJ4fHt8O453KzOibznbRibN5GuLHt5z6IonQHxLibJAfdTY8ZqYR49dasp51B0qUoCzsz9gB2O/0', '0.00', 0, NULL, NULL, NULL, 0, 1496295024, 1496295024, 1496295024, 1, 0),
(20, 'oOeQPxNjcaXXaVx9GHXXu2y12-uE', '刘恒', 'http://wx.qlogo.cn/mmopen/C14Kv21fjN0uzrPtnC3v8Rebko7gibYcvOlicibJdyfpps0UicLBK4svyppIAqYaciaDC8BgvydxUVIEHI6e6hpicmS0hVOHeJNGNT/0', '11.06', 1, '刘恒', '15145153621', 11.06, 2, 1502065414, 0, 1502066347, 1, 0),
(21, 'oOeQPxIaxgs_7ef6lRNm_7LpKZj0', 'A娟娟', 'http://wx.qlogo.cn/mmopen/d2fJZTzRTumRibrBTEh4UXScQBuiaNSphI9BvAPXCibyJgjX3gVyM9aGBISsR6WHRsVZQwCUfEl0JT7kua1BtibL61E1Zw55o7KU/0', '10.25', 1, '黑道皇后', '13100849632', 10.25, 2, 1502072684, 0, 1502072724, 1, 0),
(22, 'oOeQPxGGWja0RlpyfgY8MTi1Kw3E', '郑宁伟', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLCD5mUw2csBWtEpyOsC04l7thCA8A5OQibh05TLW9Ribh4pBvCR53nmn1pz9khnfwTKlZjiaLGRgiaHQ4VGEZCBkwGibltribe2zBvB8/0', '27.32', 5, '郑宁伟', '18515011741', 12.47, 2, 1502078691, 0, 1502787313, 1, 0),
(23, 'oOeQPxEqzQhA3R3E5saKr9AlAqtM', '褚小波', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAXKLAjicNUdUsAXgsGR4yMnC6WcwyJ0sQDGDUZSdsLBj9H3SSGkzj37p21qyEiaxWDcof7icj2byKRg/0', '18.23', 2, '褚洪波', '18101035231', 14.31, 2, 1502108972, 0, 1502606556, 1, 0),
(24, 'oOeQPxBK8QWXMbX8CQNN6DX7R_qA', '李文凯', 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM7jxFRHHHhgvzCwZ5fmNalIoNTLeo68wWrTUVwlibo9BBaiaa50gcJtpp1riakAKAdibibUMz9IsrIa1xg/0', '14.96', 2, '李文凯', '18911300582', 10.05, 2, 1502186682, 0, 1502186927, 1, 0),
(25, 'oOeQPxEtybPX5lD6DqQGd3uCIxZY', 'GeorgeMax', 'http://wx.qlogo.cn/mmopen/KJjIsr1BPnTeoZ2yrapsq3LRb0ic5B7Z79tia9tesbjuwPw1XpCPHjI5fvxIMcDHLrdKKjx9fTXG4XuHlR30SicMLEOufuOStgA/0', '0.00', 0, NULL, NULL, NULL, 0, 1502186792, 0, 1502186792, 1, 0),
(26, 'oOeQPxC4P58Wa1SUYWIZ_ywen4eA', '把青春编织成朵花', 'http://wx.qlogo.cn/mmopen/d2fJZTzRTukGXfUV9FdUBwTialPgGwyCxUVPDVpczamb86ktNdOUSdrxzFhQMlOMwPHta9oJYmiaRboFlMWOJ0dA/0', '0.00', 0, NULL, NULL, NULL, 0, 1502186934, 0, 1502186934, 1, 0),
(27, 'oOeQPxLdtqw4RKcFtFL6mhFkiyFY', '旺', 'http://wx.qlogo.cn/mmopen/KJjIsr1BPnT6TFeSDz9iahibwibTGa7XxSPd9tDiavN5wuicIyrrhBKvHibkmXReCdeWIictUaksDwXfP4aiaguQKq0icicA/0', '0.00', 0, NULL, NULL, NULL, 0, 1502187107, 0, 1502187107, 1, 0),
(28, 'oOeQPxNmi3sRPm7-B-1jCTxw87n4', '杨乐', 'http://wx.qlogo.cn/mmopen/KJjIsr1BPnQlr9Wq2ia0G5OVjZQLmzuVvja3HSUGK8uFlFribSpx9FNXdAJc3siaxsf51uVU1HvNy21CwNic97sMkNnuia8E66IUu/0', '0.00', 0, NULL, NULL, NULL, 0, 1502187151, 0, 1502187151, 1, 0),
(29, 'oOeQPxBKtHVupiad3FBpAcpKn3rg', '透明', 'http://wx.qlogo.cn/mmopen/KJjIsr1BPnQlr9Wq2ia0G5NPIJCeWiaicxdiah7YuRDnMLicub9icHaGYpTpr0GysBGSVfhtUu0I0J8OckTC9ch57GqJuveiacDYQvK/0', '0.00', 0, NULL, NULL, NULL, 0, 1502188215, 0, 1502188215, 1, 0),
(30, 'oOeQPxOh3X-u_NZosLCtAh-Gecro', 'cocoa', 'http://wx.qlogo.cn/mmopen/KJjIsr1BPnS5e9DVO9RiaElxUckkU3IUplqrSI3fOv2EhPCXIqVFx9QSGoqNvA0SzbflndichKwiaqAiamkHb0d1OIj4KJRGTnD3/0', '0.00', 0, NULL, NULL, NULL, 0, 1502188991, 0, 1502188991, 1, 0),
(31, 'oOeQPxLneDz-mlQtIXDwt7-8BDJQ', 'DiNozzo', 'http://wx.qlogo.cn/mmopen/AqEIVwciaRtiaSbJdKZNG5BEN1ibL6j5BjTBMrRmuiaGb45DsPSxOekcd8KwZlxBDVO3hjWPmarPnsz0qQWvj7mQdENCeN8XHnvK/0', '0.00', 0, NULL, NULL, NULL, 0, 1502195426, 0, 1502195426, 1, 0),
(32, 'oOeQPxOTZvl_IJ2XE-hASOd4NRqk', '杰♛', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLBIicaWSR03bw1x4kvczak6MOd8OUKqtOC17vAuCtfhUVhV0FIt9I36VPyiaOblso0ZEPdJictZ8YXIWuibJia4b7Fv45E4WHAumRms/0', '12.48', 1, '高海杰', '15313921315', 12.48, 2, 1502208271, 0, 1502208306, 1, 0),
(33, 'oOeQPxBgy9DDeIiS3ZKU-hCQ7RqM', 'FAN', 'http://wx.qlogo.cn/mmopen/d2fJZTzRTumicqpInYjMG43cKPrS7ibu5rNb4gTMPSW8HZjqU7hZ0YjQPtpyEeZd9NOZzP3qoPHZt4v7LJV6SgKQ/0', '0.00', 0, 'aaa', '18518779098', NULL, 1, 1502250212, 0, 1502250239, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `qf_admin`
--
ALTER TABLE `qf_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qf_record`
--
ALTER TABLE `qf_record`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `qf_user`
--
ALTER TABLE `qf_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `qf_admin`
--
ALTER TABLE `qf_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `qf_record`
--
ALTER TABLE `qf_record`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `qf_user`
--
ALTER TABLE `qf_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
