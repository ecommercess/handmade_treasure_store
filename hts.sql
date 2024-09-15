-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2024 at 04:14 AM
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
-- Database: `hts`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_display` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `suffix` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_name` varchar(11) NOT NULL,
  `product_display` varchar(50) NOT NULL,
  `product_category` varchar(35) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_total` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `tracking_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_display` varchar(50) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_category` varchar(35) NOT NULL,
  `stocks` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `product_display`, `product_description`, `product_category`, `stocks`, `price`, `seller_id`, `created_at`, `updated_at`) VALUES
(1, 'Morning Dew Flower', 'crocheted1.jpg', ' Quisque vitae dolor at elit gravida varius. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut gravida, lacus nec fermentum sollicitudin, felis sem fermentum elit, nec ultrices orci sapien at lorem. ', 'Crocheted Item', 10, 199, 3, '2024-06-24 02:03:22', '2024-06-24 02:06:44'),
(2, 'Petal Whispers Blossom', 'crocheted3.jpg', 'Suspendisse potenti. Curabitur gravida turpis non nisl efficitur, ac fermentum erat scelerisque. Sed lobortis blandit ex, in vulputate nisl vehicula id.', 'Crocheted Item', 5, 499, 3, '2024-06-24 02:04:06', '2024-06-24 02:06:48'),
(3, 'Smiley Key Chain', 'keychain1.jpg', ' Nullam condimentum justo in nisi malesuada, sit amet dapibus dolor suscipit. Cras nec augue ac mi pharetra gravida a in urna. Pellentesque eu leo suscipit, convallis risus non, scelerisque eros.', 'Key Chain', 20, 59, 3, '2024-06-24 02:05:17', '2024-06-24 02:06:51'),
(4, 'Flower Phone Lace', 'laces2.jpg', ' Nullam condimentum justo in nisi malesuada, sit amet dapibus dolor suscipit. Cras nec augue ac mi pharetra gravida a in urna. Pellentesque eu leo suscipit, convallis risus non, scelerisque eros', 'Phone Lace', 10, 99, 3, '2024-06-24 02:06:20', '2024-06-24 02:06:56'),
(5, 'Velvet Petal Posy', 'crocheted4.jpg', '  Integer vestibulum, mauris vel fringilla ullamcorper, sapien purus sodales mi, eget pharetra lorem lacus in lectus.', 'Crocheted Item', 10, 100, 4, '2024-06-24 02:08:26', '2024-06-24 02:10:28'),
(6, 'Led White Baloons', 'other2.jpg', ' Integer vestibulum, mauris vel fringilla ullamcorper, sapien purus sodales mi, eget pharetra lorem lacus in lectus.', 'Others', 10, 199, 4, '2024-06-24 02:09:06', '2024-06-24 02:10:33'),
(7, 'Canada Key Chain', 'keychain2.jpg', ' Integer vestibulum, mauris vel fringilla ullamcorper, sapien purus sodales mi, eget pharetra lorem lacus in lectus.', 'Key Chain', 15, 100, 4, '2024-06-24 02:09:32', '2024-06-24 02:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_acc_data`
--

CREATE TABLE `user_acc_data` (
  `id` int(11) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `suffix` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `verified`  (1) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_acc_data`
--

INSERT INTO `user_acc_data` (`id`, `profile_picture`, `firstname`, `middlename`, `lastname`, `suffix`, `email`, `contact_number`, `address`, `password`, `role`, `verified`, `token`) VALUES
(1, 'user-icon.png', 'Princess', '', 'Ginon', '', 'princess@gmail.com', '09123456789', 'Morning Snow, Putik, Zamboanga City', 'princess', 'customer', 1, '50d4a5518951c9bb2e344b1feb697ff62f48b07366ff3bd7207be7d689d4e1602c3ada714ce4f763dadffbaa75c61c78fa7a'),
(2, 'user-icon.png', 'Bryalla', '', 'Jeidee', '', 'bryalla@gmail.com', '09586940173', 'Block A,Street Z, Talon-Talon, Zamboanga City', 'bryalla', 'customer', 1, '50d4a5518951c9bb2e344b1feb697ff62f48b07366ff3bd7207be7d689d4e1602c3ada714ce4f763dadffbaa75c61c78fa7a'),
(3, 'user-icon.png', 'Seller', '', 'One', '', 'seller1@gmail.com', '09586910234', 'Zone A1, Town, Zamboanga City', 'seller1', 'seller', 1, '50d4a5518951c9bb2e344b1feb697ff62f48b07366ff3bd7207be7d689d4e1602c3ada714ce4f763dadffbaa75c61c78fa7a'),
(4, 'user-icon.png', 'Seller', '', 'Two', '', 'seller2@gmail.com', '09123456789', 'Calle Otso, Tumaga, Zamboanga City', 'seller2', 'seller', 1, '50d4a5518951c9bb2e344b1feb697ff62f48b07366ff3bd7207be7d689d4e1602c3ada714ce4f763dadffbaa75c61c78fa7a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_acc_data`
--
ALTER TABLE `user_acc_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_acc_data`
--
ALTER TABLE `user_acc_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
