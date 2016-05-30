-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 30, 2016 at 06:48 
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'Политика'),
(5, 'Hello'),
(6, 'Экономика');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `news_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `path`, `news_id`) VALUES
(90, '/images/articles/1679091c5a880faf6fb5e6087eb1b2dc.jpg', 0),
(91, '/images/articles/1679091c5a880faf6fb5e6087eb1b2dc.jpg', 7),
(92, '/images/articles/1679091c5a880faf6fb5e6087eb1b2dc.jpg', 9);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `article` varchar(255) NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  `text` text,
  `create` datetime DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `article`, `tag_name`, `text`, `create`, `category_id`) VALUES
(7, 'Ющенко уже давно не президетн', 'бджоли', 'бджоли', NULL, 4),
(8, 'asd', 'norm', 'norm', NULL, 5),
(9, 'Экономика сраны под угрозой', 'пчелы', 'necessitatibus, cumque numquam consequuntur perspiciatis pariatur at ut expedita quibusdam totam. Recusandae nesciunt enim, pariatur assumenda laboriosam debitis beatae fuga natus vero voluptatibus libero error, aut non tempore provident quidem dolor illum, cupiditate consequuntur. Tempora hic, doloremque porro pariatur quis perspiciatis ipsum voluptate earum deserunt facilis! Natus dolor, impedit aspernatur officia aliquam est quisquam debitis voluptatibus ullam ratione. Maxime corrupti impedit animi enim? Ducimus est officiis eum sed, nihil minus sint modi beatae veritatis illum asperiores aut id, delectus optio facilis voluptatum maxime nobis et odit enim doloribus ea. Assumenda porro corrupti, debitis! Tempora ea minus dolorem possimus molestias quaerat, vel adipisci doloribus in doloremque quasi, voluptatem debitis harum neque qui ipsum ratione accusantium maiores dignissimos a. Aut est magni dignissimos perspiciatis ratione quod quam repellat harum odit. Sequi praesentium accusantium beatae eligendi laboriosam facilis inventore, odio reiciendis assumenda necessitatibus sunt accusamus officiis hic rem sint, quis quasi alias numquam dignissimos omnis earum! Ad rerum possimus aliquid provident deserunt corporis at voluptatem, esse aperiam voluptate, quod fuga alias sint impedit, maxime sed obcaecati. Ipsam aut voluptatibus ipsum deserunt iure. Natus laboriosam ullam doloribus iusto minima et maiores incidunt, architecto atque, porro, veniam ut vel laborum aut quasi quam at! Ratione quisquam quos aut voluptas voluptates repellat odio ab, placeat culpa, rerum laudantium. Totam necessitatibus odio magni praesentium nostrum numquam dolores mollitia! Impedit possimus numquam quae reiciendis, cum eius magni fuga cumque, sapiente labore ducimus exercitationem rem ad inventore quia officia itaque! Ipsa quo eius qui eveniet odio. Nesciunt sapiente similique perferendis reiciendis odit doloribus enim laudantium distinctio vitae, beatae atque in odio dolore quisquam optio quibusdam impedit, maxime voluptatibus mollitia! In voluptatibus totam doloribus pariatur labore.', NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login_mail` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login_mail`, `full_name`, `pass`, `phone`, `photo_path`, `role`, `reg_date`, `active`) VALUES
(1, 'admin', 'Administrator', 'myWSCxSk12PxI', '0508005958', NULL, 'admin', '2016-05-22 00:57:32', 1),
(15, 'Vyacheslav', 'Vyacheslav Lynnyk', 'myWSCxSk12PxI', '0508005958', '/webroot/images/avatars/15Vyacheslav40.png', 'user', '2016-05-22 22:17:51', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_category_id_fk` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
