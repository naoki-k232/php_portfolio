-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022 年 1 月 28 日 15:15
-- サーバのバージョン： 5.7.34
-- PHP のバージョン: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `shrines`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `Comments`
--

CREATE TABLE `Comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `shrines_id` int(11) NOT NULL COMMENT '投稿ID',
  `text` text NOT NULL COMMENT 'テキスト',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '投稿日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `Comments`
--

INSERT INTO `Comments` (`id`, `user_id`, `shrines_id`, `text`, `created_at`) VALUES
(14, 35, 4, 'コメント', '2022-01-23 17:03:46'),
(15, 35, 3, 'コメント', '2022-01-23 17:06:14'),
(16, 35, 3, 'コメント', '2022-01-23 17:08:28'),
(17, 42, 6, 'コメント投稿', '2022-01-23 19:40:28'),
(18, 42, 4, 'コメント', '2022-01-23 19:40:48'),
(19, 43, 8, 'コメント', '2022-01-23 19:47:35'),
(21, 43, 4, 'コメント', '2022-01-23 19:47:54'),
(22, 44, 9, 'コメント', '2022-01-23 19:49:25'),
(23, 44, 8, 'コメント', '2022-01-23 19:49:34'),
(24, 45, 10, 'コメント', '2022-01-23 19:51:29'),
(28, 46, 12, 'コメント', '2022-01-23 20:26:24'),
(29, 46, 12, 'aaa', '2022-01-23 20:26:29'),
(30, 35, 11, 'コメント', '2022-01-25 16:25:26'),
(31, 35, 11, 'コメント\nkomennto', '2022-01-25 16:25:41'),
(33, 35, 11, 'コメント', '2022-01-25 16:32:43'),
(34, 35, 8, 'コメント', '2022-01-25 18:57:24');

-- --------------------------------------------------------

--
-- テーブルの構造 `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shrines_id` int(11) NOT NULL,
  `create_ad` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `goods`
--

INSERT INTO `goods` (`id`, `user_id`, `shrines_id`, `create_ad`) VALUES
(53, 43, 8, '2022-01-23 19:47:03'),
(54, 43, 6, '2022-01-23 19:47:04'),
(55, 43, 4, '2022-01-23 19:47:06'),
(56, 43, 3, '2022-01-23 19:47:07'),
(57, 44, 3, '2022-01-23 19:48:46'),
(58, 44, 4, '2022-01-23 19:48:47'),
(59, 44, 6, '2022-01-23 19:48:48'),
(60, 44, 8, '2022-01-23 19:48:49'),
(62, 46, 12, '2022-01-23 20:19:11'),
(63, 46, 13, '2022-01-23 20:28:39'),
(64, 46, 15, '2022-01-23 20:37:10'),
(65, 46, 11, '2022-01-23 20:37:12'),
(66, 46, 10, '2022-01-23 20:37:13'),
(67, 46, 9, '2022-01-23 20:37:14'),
(69, 35, 6, '2022-01-23 20:39:12'),
(73, 35, 3, '2022-01-24 09:57:56'),
(81, 35, 10, '2022-01-26 10:08:49'),
(90, 35, 4, '2022-01-26 16:11:27'),
(91, 42, 13, '2022-01-28 14:18:31'),
(92, 45, 14, '2022-01-28 14:43:00'),
(94, 35, 11, '2022-01-28 14:58:09');

-- --------------------------------------------------------

--
-- テーブルの構造 `shrines_review`
--

CREATE TABLE `shrines_review` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `recommends` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `shrines_review`
--

INSERT INTO `shrines_review` (`id`, `title`, `recommends`, `description`, `image`, `created_at`, `updated_at`, `user_id`) VALUES
(3, 'テスト３', 3, 'テスト３', 'img/20220119050135python_18894.png', '2022-01-19 17:01:35', '2022-01-20 14:00:32', 35),
(4, '変更テスト', 1, '変更テスト', 'img/20220123050907tokyoyakeiIMGL32651930_TP_V4.jpg', '2022-01-20 10:31:23', '2022-01-23 17:09:07', 35),
(5, 'テスト', 2, '投稿テスト', 'img/20220123035820084AME0226_TP_Vのコピー.jpg', '2022-01-23 15:58:20', '2022-01-23 15:58:20', 40),
(8, 'テスト', 3, '投稿', 'img/20220123074137RED2182OPSO00_TP_V4.jpg', '2022-01-23 19:41:37', '2022-01-23 19:41:37', 42),
(9, 'テスト', 2, 'コメント', 'img/20220123074725YAT19725009_TP_V4.jpg', '2022-01-23 19:47:25', '2022-01-23 19:47:25', 43),
(10, 'テスト', 1, 'テスト', 'img/20220123074912GAK92_fusimiinari_TP_V4.jpg', '2022-01-23 19:49:12', '2022-01-23 19:49:12', 44),
(11, 'テスト変更', 5, 'テスト変更', 'img/20220128025639084AME0226_TP_Vのコピー.jpg', '2022-01-23 19:51:23', '2022-01-28 14:56:39', 45),
(12, 'テストタイトル', 5, 'テスト感想', 'img/20220127105052084AME0226_TP_Vのコピー.jpg', '2022-01-27 10:50:52', '2022-01-27 10:50:52', 35),
(13, 'テスト投稿', 3, 'テスト投稿', 'img/20220128021803084AME0226_TP_Vのコピー.jpg', '2022-01-28 14:18:03', '2022-01-28 14:18:03', 42),
(14, 'テスト投稿変更', 3, '感想投稿', 'img/20220128024337GAK92_fusimiinari_TP_V4.jpg', '2022-01-28 14:42:58', '2022-01-28 14:43:37', 45),
(15, '投稿', 3, 'テスト', 'img/20220128025555084AME0226_TP_Vのコピー.jpg', '2022-01-28 14:55:55', '2022-01-28 14:55:55', 45);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reset_date` datetime DEFAULT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '管理者=1\r\n一般＝０'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `reset_date`, `secret_key`, `role`) VALUES
(35, '管理ユーザー', 'test@test.com', '$2y$10$QR56Wfa8WhwoDGeQqjnYMucVcGqBba9zyw4Xucc2Ry1x1j0sRgwje', '2022-01-16 14:22:51', '2022-01-27 14:42:46', NULL, NULL, 1),
(36, '一般ユーザー', 'test2@test.com', '$2y$10$J8z8w9G.MxiHZX7ep8hRMOgnv5DpUFAjrMaSnjsV.97XpGue6.Lce', '2022-01-19 17:11:45', '2022-01-23 09:35:18', NULL, NULL, 0),
(37, 'テスト3一般', 'test3@test.com', '$2y$10$iKEMtrxJJMiP7PZUgCJQb.q/LB1DsZVITOQhDjiBCatDXnVj2Ccnq', '2022-01-20 22:32:57', '2022-01-20 22:32:57', NULL, NULL, 0),
(39, 'テストユーザー2', 'test@9test.com', '$2y$10$HjI3Pckv9A7y3p9VIBSKA.7DE23Mr7NzQiLM0d/2btv8DGO8psg.y', '2022-01-22 16:45:25', '2022-01-22 16:45:25', NULL, NULL, 0),
(42, 'テスト1ユーザー変更', 'test@2test.com', '$2y$10$Q4Qr/Vqg/AODJhtKvWW8z.fqZCNUNXBmYjPKHSXAXhPLe7.L29cMO', '2022-01-23 17:22:38', '2022-01-28 14:19:28', NULL, NULL, 0),
(43, 'テスト2ユーザー', 'test@3test.com', '$2y$10$4ZQW5F7xHhmh8n0JF9QGNuw2N.keRX0U1Zd1oy5v5IQ/RPXQwkeC.', '2022-01-23 17:25:02', '2022-01-23 17:25:02', NULL, NULL, 0),
(44, 'test3ユーザー', 'test@4test.com', '$2y$10$WJ37cFJYoh6RldiS.N8vJeTs6t69n8mpcK98v2qR5.bOXy91YtilO', '2022-01-23 17:26:16', '2022-01-23 17:26:16', NULL, NULL, 0),
(45, '鈴木テスト', 'suzukiitirou255@gmail.com', '$2y$10$S.eKiEOkGfmnJVQIPs6RMOfYKXYJBm/3ZFXqKy9jE.gfLkFKC19D6', '2022-01-23 19:50:46', '2022-01-28 14:40:49', '2022-01-28 14:40:49', NULL, 0),
(46, 'テスト5編集', 'test24@test.com', '$2y$10$ulzk0hZZ5fxK8jcuXPwq5OXqyKKv1AYqhSsmJR7tJpHsL203AVT4e', '2022-01-23 20:18:01', '2022-01-23 20:18:30', NULL, NULL, 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `shrines_review`
--
ALTER TABLE `shrines_review`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `name` (`name`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `Comments`
--
ALTER TABLE `Comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- テーブルの AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- テーブルの AUTO_INCREMENT `shrines_review`
--
ALTER TABLE `shrines_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
