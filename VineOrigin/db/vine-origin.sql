-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 06:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vine-origin`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(52, 24, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` float(8,2) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price_total` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `payment_method` varchar(55) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gcash_reference` varchar(255) NOT NULL,
  `acc_name` varchar(255) NOT NULL,
  `acc_number` varchar(255) NOT NULL,
  `amount_paid` varchar(255) NOT NULL,
  `status` char(1) DEFAULT 'p' COMMENT 'p - pending\r\nt - to receive\r\nr - received\r\nc - cancelled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_name`, `product_price`, `quantity`, `price_total`, `full_name`, `contact_no`, `address`, `city`, `payment_method`, `order_date`, `gcash_reference`, `acc_name`, `acc_number`, `amount_paid`, `status`) VALUES
(16, 17, 'JAMORANT 1-PNK', 1499.00, 1, 1499, 'Testing3', '+639456823067', 'Zone 2', 'Libon, Albay', 'cash_on_delivery', '2024-06-01 14:16:46', '', '', '', '0', 'r'),
(19, 17, 'G.T CUT-3', 1799.00, 6, 10794, 'Coda Sonata', '+639456823067', 'Zone 3', 'Libon, Albay', 'Cash on Delivery', '2024-06-01 17:22:33', '', '', '', '0', 'r'),
(28, 17, 'G.T CUT-3', 1799.00, 2, 3598, 'selected test', '+639456823067', 'Zone 3', 'Oas, Albay', 'Cash on Delivery', '2024-06-01 17:44:44', '', '', '', '0', 'r'),
(29, 17, 'G.T. CUT 3-WHB', 1799.00, 2, 3598, 'selected test', '+639456823067', 'Zone 3', 'Oas, Albay', 'Cash on Delivery', '2024-06-01 17:44:44', '', '', '', '0', 'r'),
(30, 17, 'G.T CUT-3', 1799.00, 1, 1799, 'test test', '+639456823067', 'Zone 3', 'Oas, Albay', 'Cash on Delivery', '2024-06-02 03:59:21', '', '', '', '0', 'c'),
(31, 17, 'JORDAN TATUM 2-MNT', 1699.00, 1, 1699, 'froy rivera', '+639456823067', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-02 04:12:07', '', '', '', '0', 'r'),
(34, 23, 'G.T CUT-3', 1799.00, 4, 7196, 'domi', '+639456821234', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-02 04:36:07', '', '', '', '0', 'r'),
(35, 17, 'G.T CUT ACADEMY', 1599.00, 1, 1599, 'froy rivera', '+639456823067', 'Zone 2', 'Oas, Albay', 'Cash on Delivery', '2024-06-02 04:43:04', '', '', '', '0', 'c'),
(36, 17, 'PRECISION-6', 1499.00, 2, 2998, 'froy rivera', '+639456823067', 'Zone 3', 'Libon, Albay', 'Cash on Delivery', '2024-06-02 06:48:27', '', '', '', '0', 'r'),
(38, 22, 'JORDAN TATUM 2-MNT', 1699.00, 4, 6796, 'jayvick', '+639123456789', 'San Isidro', 'Libon, Albay', 'Cash on Delivery', '2024-06-02 07:09:16', '', '', '', '0', 'r'),
(40, 24, 'ADIDAS SAMBA-WS', 1299.00, 7, 9093, 'jojo olea', '+639127556241', 'san vicente', 'libon, albay', 'Cash on Delivery', '2024-06-02 10:14:02', '', '', '', '0', 'r'),
(41, 25, 'PRECISION-6', 1499.00, 1, 1499, 'mark segubiense', '+639123456789', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-02 13:16:12', '', '', '', '0', 'r'),
(42, 17, 'AIR JORDAN 4- TBK', 1799.00, 1, 1799, 'froy rivera', '+639456823067', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 05:19:36', '', '', '', '0', 'c'),
(43, 17, 'New Balance - WSM', 1599.00, 1, 1599, 'froy rivera', '+639456823067', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 05:19:36', '', '', '', '0', 'r'),
(44, 24, 'PRECISION-6', 1499.00, 1, 1499, 'jojo olea', '+639456821234', 'san vincente', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 05:24:13', '', '', '', '0', 'c'),
(45, 24, 'JORDAN TATUM 2-UNB', 1699.00, 1, 1699, 'jojo olea', '+639456821234', 'san vincente', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 05:24:13', '', '', '', '0', 'c'),
(46, 24, 'New Balance - WSM', 1599.00, 1, 1599, 'jojo olea', '+639456823067', 'san vincente', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 05:24:54', '', '', '', '0', 't'),
(47, 17, 'G.T CUT-3', 1799.00, 3, 5397, 'qwerty wasd', '+639456823067', 'Zone 3', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 07:15:46', '', '', '', '0', 'p'),
(48, 17, 'Adidas Campus- YOP', 1599.00, 1, 1599, '0', '+639456823067', 'Zone 2', 'Libon, Albay', 'GCASH', '2024-06-03 10:01:03', '3287654834674', 'mark froy rivera', '+639456823067', '2000', 'r'),
(63, 17, 'JORDAN TATUM 2-LMP', 1699.00, 1, 1699, '0', '+639456823067', 'Zone 2', 'Oas, Albay', 'Cash on Delivery', '2024-06-03 13:44:34', '', '', '', '0', 'p'),
(64, 17, 'G.T CUT-3', 1799.00, 1, 1799, 'froy rivera', '+639456823067', 'Zone 3', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 13:46:17', '', '', '', '0', 'p'),
(65, 17, 'G.T CUT ACADEMY', 1599.00, 1, 1599, '0', '+639456823067', 'Zone 3', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 13:49:17', '', '', '', '0', 'p'),
(66, 17, 'G.T CUT-3', 1799.00, 1, 1799, '0', '+639456823067', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 13:50:50', '', '', '', '0', 'p'),
(67, 17, 'JORDAN TATUM 2-LMP', 1699.00, 1, 1699, '0', '+639456823067', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 15:31:54', '', '', '', '0', 'p'),
(68, 17, 'New Balance - WSM', 1599.00, 1, 1599, '0', '+639456823067', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 15:31:54', '', '', '', '0', 'p'),
(69, 17, 'PRECISION-6', 1499.00, 3, 4497, '0', '+639456821234', 'Zone 3', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 15:41:14', '', '', '', '0', 'p'),
(70, 17, 'G.T CUT ACADEMY', 1599.00, 2, 3198, '0', '+639123456789', 'Zone 1', 'Oas, Albay', 'Cash on Delivery', '2024-06-03 15:42:26', '', '', '', '0', 'p'),
(71, 17, 'G.T CUT ACADEMY', 1599.00, 1, 1599, '0', '+639456823067', 'Zone 3', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 15:47:21', '', '', '', '0', 'p'),
(72, 17, 'ADIDAS SAMBA-BLG', 1399.00, 1, 1399, '0', '+639456823067', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 15:48:24', 'N/A', 'N/A', 'N/A', '0', 'r'),
(73, 17, 'AIR JORDAN 4- TBK', 1799.00, 1, 1799, '0', '+639456823067', 'Zone 2', 'Libon, Albay', 'GCASH', '2024-06-03 15:50:37', '3287654834674', 'mark froy rivera', '+639456823067', '1799', 'r'),
(74, 17, 'G.T CUT-3', 1799.00, 1, 1799, '0', '+639123456789', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 15:51:09', 'N/A', 'N/A', 'N/A', '0', 'c'),
(75, 17, 'G.T CUT-3', 1799.00, 1, 1799, '0', '+639456821234', 'Zone 7', 'Oas, Albay', 'Cash on Delivery', '2024-06-03 15:54:18', 'N/A', 'N/A', 'N/A', '0', 'p'),
(76, 17, 'New Balance - WSM', 1599.00, 1, 1599, '0', '+639456821234', 'Zone 3', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 16:02:55', 'N/A', 'N/A', 'N/A', '0', 'p'),
(77, 17, 'G.T CUT ACADEMY', 1599.00, 1, 1599, '0', '+639456821234', 'Zone 2', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 16:04:24', 'N/A', 'N/A', 'N/A', '0', 'p'),
(78, 17, 'ADIDAS SAMBA-BLG', 1399.00, 1, 1399, '0', '+639456823067', 'Zone 2', 'Oas, Albay', 'Cash on Delivery', '2024-06-03 16:06:25', 'N/A', 'N/A', 'N/A', '0', 'p'),
(79, 17, 'G.T. CUT 3-YLW', 1799.00, 1, 1799, '0', '+639456823067', 'Zone 3', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 16:08:11', 'N/A', 'N/A', 'N/A', '0', 'p'),
(80, 17, 'G.T CUT ACADEMY', 1599.00, 1, 1599, '0', '+639456821234', 'Zone 3', 'Libon, Albay', 'Cash on Delivery', '2024-06-03 16:09:26', 'N/A', 'N/A', 'N/A', '0', 'p');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `product_price` float(8,2) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `product_image` varchar(55) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a' COMMENT 'a - active\r\ni - inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `category`, `product_price`, `product_stock`, `product_image`, `status`) VALUES
(1, 'PRECISION-6', 'It designed to enable quick players to shift speed and change directions while staying control.', 'featured', 1499.00, 37, 'FEATURED-1.jpg', 'a'),
(2, 'G.T CUT ACADEMY', 'Designed to help you create space for stepback jumpers, backdoor cuts and other game-changing plays,', 'featured', 1599.00, 32, 'FEATURED-2.jpg', 'a'),
(3, 'G.T CUT-3', 'Designed to help you create space for stepback jumpers and backdoor cuts, its sticky multicourt traction helps you stop on a dime and shift gears at will. And when you\'re making all those game-changing plays, the newly added, ultra-responsive ZoomX foam.', 'featured', 1799.00, 26, 'FEATURED-3.jpg', 'a'),
(4, 'JORDAN TATUM 2-UNB', 'The Jordan Tatum 2 would be a better shoe if it weren\'t for the traction. The outsole collects dust.', 'bbshoes', 1699.00, 39, 'BBALL-1.jpg', 'a'),
(5, 'JORDAN TATUM 2-LMP', 'The Jordan Tatum 2 would be a better shoe if it weren\'t for the traction. The outsole collects dust quickly, which hinders performance. ', 'bbshoes', 1699.00, 37, 'BBALL-2.jpg', 'a'),
(6, 'JORDAN TATUM 2-MNT', 'The Jordan Tatum 2 would be a better shoe if it weren\'t for the traction. The outsole collects dust quickly, which hinders performance. ', 'bbshoes', 1699.00, 33, 'BBALL-4.jpg', 'a'),
(7, 'JORDAN TATUM 2-MMB', 'The Jordan Tatum 2 would be a better shoe if it weren\'t for the traction. The outsole collects dust quickly, which hinders performance. ', 'bbshoes', 1699.00, 40, 'BBALL-4.jpg', 'a'),
(8, 'JAMORANT 1-GRN', 'The Ja 1 is a testament to his rise. With an Air Zoom unit, it supports bunny hops and hyper speed without sacrificing comfort, so that you can control your own destiny on the court, Ja-style.', 'bbshoes', 1499.00, 57, 'BBALL-6.jpg', 'a'),
(9, 'JAMORANT 1-EPJ', 'The Ja 1 is a testament to his rise. With an Air Zoom unit, it supports bunny hops and hyper speed without sacrificing comfort, so that you can control your own destiny on the court, Ja-style.', 'bbshoes', 1499.00, 60, 'BBALL-5.jpg', 'a'),
(10, 'JAMORANT 1-PNK', 'The Ja 1 is a testament to his rise. With an Air Zoom unit, it supports bunny hops and hyper speed without sacrificing comfort, so that you can control your own destiny on the court, Ja-style.', 'bbshoes', 1499.00, 59, 'BBALL-7.jpg', 'a'),
(11, 'JAMORANT 1-TRV', 'The Ja 1 is a testament to his rise. With an Air Zoom unit, it supports bunny hops and hyper speed without sacrificing comfort, so that you can control your own destiny on the court, Ja-style.', 'bbshoes', 1499.00, 60, 'BBALL-8.jpg', 'a'),
(12, 'G.T. CUT 3-WHB', 'Designed to help you create space for stepback jumpers and backdoor cuts, its sticky multicourt traction helps you stop on a dime and shift gears at will. And when you\'re making all those game-changing plays, the newly added, ultra-responsive ZoomX foam.', 'bbshoes', 1799.00, 48, 'BBALL-9.jpg', 'a'),
(13, 'G.T. CUT 3-YLW', 'Designed to help you create space for stepback jumpers and backdoor cuts, its sticky multicourt traction helps you stop on a dime and shift gears at will. And when you\'re making all those game-changing plays, the newly added, ultra-responsive ZoomX foam ', 'bbshoes', 1799.00, 49, 'BBALL-10.jpg', 'a'),
(14, 'G.T.3-USA', 'Designed to help you create space for stepback jumpers and backdoor cuts, its sticky multicourt traction helps you stop on a dime and shift gears at will. And when you\'re making all those game-changing plays, the newly added, ultra-responsive ZoomX foam ', 'bbshoes', 1799.00, 50, 'BBALL-11.jpg', 'a'),
(15, 'G.T.3-RB', 'Designed to help you create space for stepback jumpers and backdoor cuts, its sticky multicourt traction helps you stop on a dime and shift gears at will. And when you\'re making all those game-changing plays, the newly added, ultra-responsive ZoomX foam ', 'bbshoes', 1799.00, 50, 'BBALL-12.jpg', 'a'),
(16, 'AIR JORDAN 4- TBK', 'Released in 1989, the Air Jordan 4 was the first global release of the franchise, and the first shoe in the line to feature its signature “over-molded” mesh. Another notable feature on the Air Jordan 4 OGs was the Nike Air logo featured on the heel.', 'cashoes', 1799.00, 43, 'CASUAL-1.jpg', 'a'),
(17, 'AIR JORDAN 4-PND', 'Released in 1989, the Air Jordan 4 was the first global release of the franchise, and the first shoe in the line to feature its signature “over-molded” mesh. Another notable feature on the Air Jordan 4 OGs was the Nike Air logo featured on the heel', 'bbshoes', 1799.00, 43, 'CASUAL-2.jpg', 'a'),
(18, 'AIR JORDAN 4-INB', 'Released in 1989, the Air Jordan 4 was the first global release of the franchise, and the first shoe in the line to feature its signature “over-molded” mesh. Another notable feature on the Air Jordan 4 OGs was the Nike Air logo featured on the heel', 'cashoes', 1799.00, 44, 'CASUAL-3.jpg', 'a'),
(19, 'AIR JORDAN 4-SLX', 'Released in 1989, the Air Jordan 4 was the first global release of the franchise, and the first shoe in the line to feature its signature “over-molded” mesh. Another notable feature on the Air Jordan 4 OGs was the Nike Air logo featured on the heel', 'cashoes', 1699.00, 45, 'CASUAL-4.jpg', 'a'),
(20, 'AIR JORDAN 1 LOW-TYK', 'Inspired by the original that debuted in 1985, the Air Jordan 1 Low offers a clean, classic look that\'s familiar yet always fresh. With an iconic design that pairs perfectly with any \'fit, these kicks ensure you\'ll always be on point.', 'cashoes', 1699.00, 30, 'CASUAL-5.jpg', 'a'),
(21, 'AIR JORDAN 1 LOW-PCL', 'Inspired by the original that debuted in 1985, the Air Jordan 1 Low offers a clean, classic look that\'s familiar yet always fresh. With an iconic design that pairs perfectly with any \'fit, these kicks ensure you\'ll always be on point.', 'cashoes', 1699.00, 30, 'CASUAL-6.jpg', 'a'),
(22, 'AIR JORDAN LOW 1- CRD', 'Inspired by the original that debuted in 1985, the Air Jordan 1 Low offers a clean, classic look that\'s familiar yet always fresh. With an iconic design that pairs perfectly with any \'fit, these kicks ensure you\'ll always be on point.', 'cashoes', 1699.00, 30, 'CASUAL-7.jpg', 'a'),
(23, 'AIR JORDAN 1 LOW- ER', 'Inspired by the original that debuted in 1985, the Air Jordan 1 Low offers a clean, classic look that\'s familiar yet always fresh. With an iconic design that pairs perfectly with any \'fit, these kicks ensure you\'ll always be on point.', 'cashoes', 1699.00, 30, 'CASUAL-8.jpg', 'a'),
(24, 'AIR JORDAN LOW 1-RBD', 'Inspired by the original that debuted in 1985, the Air Jordan 1 Low offers a clean, classic look that\'s familiar yet always fresh. With an iconic design that pairs perfectly with any \'fit, these kicks ensure you\'ll always be on point.', 'cashoes', 1699.00, 30, 'CASUAL-9.jpg', 'a'),
(25, 'ONITSUKA TIGER TOKTUTEN-PND', 'Leather and synthetic leather upper with rubber sole. Lace-up front. ', 'cashoes', 1599.00, 35, 'CASUAL-10.jpg', 'a'),
(26, 'ONISUKA TIGER TOKUTEN-BEG', 'Leather and synthetic leather upper with rubber sole. Lace-up front. ', 'cashoes', 1599.00, 35, 'CASUAL 11.jpg', 'a'),
(27, 'ADIDAS SAMBA-WS', 'Kick it old school with Samba shoes, a classic since 1950. Their low-profile design, iconic T-toe and rubber gumsole make them unmistakably adidas.', 'cashoes', 1299.00, 38, 'CASUAL-12.jpg', 'a'),
(28, 'ADIDAS SAMBA-WLB', 'Kick it old school with Samba shoes, a classic since 1950. Their low-profile design, iconic T-toe and rubber gumsole make them unmistakably adidas.', 'cashoes', 1399.00, 45, 'CASUAL-133.jpg', 'a'),
(29, 'ADIDAS SAMBA-BLG', 'Kick it old school with Samba shoes, a classic since 1950. Their low-profile design, iconic T-toe and rubber gumsole make them unmistakably adidas.', 'cashoes', 1399.00, 43, 'CASUAL-144.jpg', 'a'),
(30, 'New Balance - WSM', 'Designed for runners seeking a blend of cushioning and stability, these New Balance WSM shoes offer exceptional support with every stride. The lightweight construction ensures a comfortable fit, while the durable outsole provides reliable traction.', 'running_shoes', 1599.00, 16, 'nb-wsm.jpg', 'a'),
(31, 'Alpha Bounce-I', 'Elevate your running experience with the Alpha Bounce-I. Featuring a sleek design and responsive cushioning, these shoes are engineered to deliver comfort and performance mile after mile. Whether you\'re hitting the track or the treadmill, the Alpha Bounce', 'running_shoes', 1499.00, 25, 'ab-i.jpg', 'a'),
(32, 'Alpha Bounce GRY', 'Make a statement with the Alpha Bounce GRY. Combining style and functionality, these shoes boast a breathable mesh upper and plush cushioning for maximum comfort. Whether you\'re running errands or hitting the gym, the Alpha Bounce GRY has you covered.', 'running_shoes', 1499.00, 25, 'ab-gry.jpg', 'a'),
(33, 'Alpha Bounce-3B', 'Dominate your runs with the Alpha Bounce 3B. Engineered for speed and agility, these shoes feature a lightweight design and responsive cushioning to help you push past your limits. With a sleek silhouette and bold colors, the Alpha Bounce 3B', 'running_shoes', 1499.00, 25, 'ab-3b.jpg', 'a'),
(34, 'Bapesta- BLG', 'Step up your style game with the Bapesta BLG. Crafted with premium materials and a unique design, these shoes are perfect for adding a touch of flair to any outfit. Whether you\'re hitting the streets or hanging out with friends, the Bapesta BLG', 'running_shoes', 1299.00, 30, 'bs-blg.jpg', 'a'),
(35, 'Bapesta-NWT', 'Elevate your streetwear with the Bapesta NWT. Featuring a classic silhouette and modern details, these shoes are sure to make a statement wherever you go. With a comfortable fit and durable construction, the Bapesta NWT', 'running_shoes', 1299.00, 20, 'bs-nwt.jpg', 'a'),
(36, 'Bapesta-ORW', 'Add some edge to your look with the Bapesta ORW. With its bold design and eye-catching colorway, these shoes are sure to stand out from the crowd. Whether you\'re hitting the club or just hanging out, the Bapesta ORW will keep you looking cool and confiden', 'running_shoes', 1299.00, 20, 'bs-orw.jpg', 'a'),
(37, 'Adidas Campus- WB', 'Classic style meets modern comfort with the Adidas Campus WB. Featuring a timeless design and premium materials, these shoes are perfect for everyday wear. Whether you\'re hitting the books or hanging out with friends', 'running_shoes', 1599.00, 33, 'ads-wb.jpg', 'a'),
(38, 'Adidas Campus- BWG', 'Step up your sneaker game with the Adidas Campus BWG. Featuring a retro-inspired design and modern details, these shoes are sure to turn heads wherever you go. Whether you\'re hitting the streets or the skate park, the Adidas Campus BWG has you covered.', 'running_shoes', 1599.00, 33, 'ads-bwg.jpg', 'a'),
(39, 'Adidas Campus- YOP', 'Make a statement with the Adidas Campus YOP. Featuring a bold colorway and eye-catching design, these shoes are sure to stand out from the crowd. Whether you\'re hitting the court or the club, the Adidas Campus YOP will keep you looking fresh and stylish.', 'running_shoes', 1599.00, 32, 'ads-yop.jpg', 'a'),
(40, 'Nike Cortez- SGT', 'Step out in style with the Nike Cortez SGT. Featuring a classic silhouette and premium materials, these shoes are perfect for adding a retro vibe to any outfit. Whether you\'re hitting the streets or the gym, the Nike Cortez SGT will keep you looking', 'running_shoes', 1699.00, 43, 'c-sgt.jpg', 'a'),
(41, 'Nike Cortez- KCW', 'Elevate your sneaker game with the Nike Cortez KCW. Featuring a sleek design and modern details, these shoes are sure to make a statement wherever you go. Whether you\'re hitting the town or just hanging out, the Nike Cortez KCW will keep you looking fresh', 'running_shoes', 1699.00, 44, 'c-kcw.jpg', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(65) NOT NULL,
  `address` varchar(55) NOT NULL,
  `user_email` varchar(55) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` char(1) NOT NULL DEFAULT 'u' COMMENT 'u - user\r\na - admin',
  `user_status` char(1) NOT NULL DEFAULT 'a' COMMENT 'a - active\r\ni - inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `address`, `user_email`, `user_password`, `user_type`, `user_status`) VALUES
(11, 'admin', '123 Main Street', 'admin@gmail.com', '123123', 'a', 'a'),
(14, 'kenneth', 'sugcad', 'kenneth@gmail.com', '123123123', 'u', 'a'),
(15, 'divine', 'sugcad', 'divineorigin@gmail.com', '123123123', 'u', 'a'),
(16, 'johnuser', 'sugcad', 'johnuser123@gmail.com', '123123', 'u', 'a'),
(17, 'Froy', 'polangui', 'froy@gmail.com', '123123', 'u', 'a'),
(19, 'james', 'libon', 'james@gmail.com', '123123', 'u', 'a'),
(20, 'coda', 'oas', 'coda@gmail.com', '12345678', 'u', 'a'),
(21, 'vicky', 'libon', 'vick@gmail.com', '1234567', 'a', 'a'),
(22, 'vicky minaj', 'libon, albay', 'vicky1@gmail.com', '123456789', 'u', 'a'),
(23, 'domi', 'libon, albay', 'domi@gmail.com', '123456', 'u', 'a'),
(24, 'jojo', 'san vicente', 'jojo@gmail.com', '123123', 'u', 'a'),
(25, 'mark', 'libon, albay', 'mark@gmail.com', '123123', 'u', 'a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
