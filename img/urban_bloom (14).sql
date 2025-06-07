-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 07, 2025 at 01:11 AM
-- Server version: 10.4.32-MariaDB-log
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urban_bloom`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `size` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `added_at`, `size`) VALUES
(76, 3, 2, 1, '2025-06-05 21:49:03', NULL),
(86, 1, 1, 1, '2025-06-06 23:03:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `date_sent`) VALUES
(1, 'as', 'asnddojansd@gmail.com', 'aiosdh[iasjd', '2025-04-18 19:27:52'),
(4, 'ivo', 'ivailoaleksandrov12211221@abv.bg', 'vurnete mi parite\r\n', '2025-04-25 05:23:25');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(12, 2, 2, '2025-05-28 22:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` mediumtext NOT NULL,
  `order_status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `paypal_email` varchar(255) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `delivery_method` varchar(123) DEFAULT 'pickup',
  `city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `payment_type`, `created_at`, `address`, `order_status`, `paypal_email`, `postal_code`, `delivery_method`, `city`) VALUES
(19, 2, 131.00, 'credit_card', '2025-05-28 22:01:20', 'akmsdpkasd', 'pending', NULL, NULL, 'pickup', NULL),
(20, 3, 65.50, 'credit_card', '2025-06-03 19:27:00', 'aishjkdbasuiodjp', 'pending', NULL, NULL, 'pickup', NULL),
(27, 3, 59.99, 'credit_card', '2025-06-03 20:09:10', 'pkajsasdasd', 'pending', NULL, '1212', 'address', NULL),
(28, 3, 45.00, 'credit_card', '2025-06-03 20:14:38', 'iaspjdipasjkd', 'pending', NULL, '1231', 'address', NULL),
(32, 3, 45.00, 'paypal', '2025-06-03 20:37:16', 'До офис на Еконт: София Център', 'pending', 'asiopdjas@gmail.com', '', 'office', 'София'),
(42, 3, 89.50, 'credit_card', '2025-06-05 21:09:10', 'До офис на Еконт: София Център', 'pending', NULL, '', 'office', 'София'),
(55, 1, 148.38, 'credit_card', '2025-06-06 22:22:09', 'До офис на Еконт: Варна Център', 'pending', NULL, '', 'office', 'Варна'),
(56, 1, 59.99, 'cash_on_delivery', '2025-06-06 22:34:32', 'До офис на Еконт: Варна Център', 'pending', NULL, '', 'office', 'Варна');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `size`) VALUES
(20, 19, 2, 2, 65.50, NULL),
(21, 20, 2, 1, 65.50, NULL),
(27, 27, 6, 1, 59.99, '40'),
(28, 28, 4, 1, 45.00, NULL),
(32, 32, 4, 1, 45.00, NULL),
(42, 42, 7, 1, 89.50, '40'),
(50, 55, 2, 1, 65.50, NULL),
(51, 55, 6, 2, 59.99, '40'),
(52, 56, 6, 1, 59.99, '40');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `gender` enum('Kids','Men','Women') DEFAULT NULL,
  `sizes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sizes`))
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image_url`, `created_at`, `category`, `type`, `gender`, `sizes`) VALUES
(1, 'Classic Leather Handbag', 'Elegant leather handbag perfect for work or casual use.', 79.99, 20, 'images/bag1.jpg', '2025-04-18 15:29:32', 'Bags', NULL, 'Women', NULL),
(2, 'Vintage Shoulder Bag', 'Chic vintage style with modern functionality.', 65.50, 15, 'images/bag2.jpg', '2025-04-18 15:29:32', 'Bags', NULL, 'Women', NULL),
(3, 'Canvas Tote Bag', 'Spacious and eco-friendly canvas tote.', 29.90, 30, 'images/bag3.jpg', '2025-04-18 15:29:32', 'Bags', NULL, 'Women', NULL),
(4, 'Mini Crossbody Bag', 'Compact and stylish for your essentials.', 45.00, 25, 'images/bag4.jpg', '2025-04-18 15:29:32', 'Bags', NULL, 'Men', NULL),
(5, 'Luxury Clutch Bag', 'A glamorous choice for evening events.', 99.00, 10, 'images/bag5.jpg', '2025-04-18 15:29:32', 'Bags', NULL, 'Women', NULL),
(6, 'White Sneakers', 'Clean, minimal design with all-day comfort.', 59.99, 30, 'images/shoes1.jpg', '2025-04-18 15:29:32', 'Shoes', 'Sneakers', 'Men', '{\"EU_sizes\": {\"Men\": [\"40\", \"41\", \"42\", \"43\", \"44\"]}}'),
(7, 'Running Shoes', 'Engineered for performance and breathability.', 89.50, 20, 'images/shoes2.jpg', '2025-04-18 15:29:32', 'Shoes', 'Running Shoes', 'Men', '{\"EU_sizes\": {\"Men\": [\"40\", \"41\", \"42\", \"43\", \"44\"]}}'),
(8, 'Ankle Boots', 'Perfect for cooler days with a trendy finish.', 75.00, 18, 'images/shoes3.jpg', '2025-04-18 15:29:32', 'Shoes', 'Ankle Boots', 'Women', '{\"EU_sizes\": {\"Women\": [\"35\", \"36\", \"37\", \"38\", \"39\"]}}'),
(9, 'Loafers', 'Smart casual loafers for everyday wear.', 68.25, 22, 'images/shoes4.jpg', '2025-04-18 15:29:32', 'Shoes', 'Loafers', 'Men', '{\"EU_sizes\": {\"Women\": [\"35\", \"36\", \"37\", \"38\", \"39\"]}}'),
(10, 'High Heels', 'Sophisticated and feminine high heels.', 95.00, 12, 'images/shoes5.jpg', '2025-04-18 15:29:32', 'Shoes', 'High Heels', 'Women', '{\"EU_sizes\": {\"Women\": [\"35\", \"36\", \"37\", \"38\", \"39\"]}}'),
(19, 'Kids Light-Up Sneakers', 'Fun and comfy sneakers with light-up soles.', 49.99, 100, 'images/shoes6.jpg', '2025-04-24 15:20:24', 'Shoes', 'Sneakers', 'Kids', '{\"EU_sizes\":{\"Kids\":[\"28\",\"29\",\"30\",\"31\",\"32\"]}}'),
(20, 'Kids Rain Boots', 'Waterproof and playful rain boots for children.', 39.50, 30, 'images/shoes7.jpg', '2025-04-24 15:20:24', 'Shoes', 'Boots', 'Kids', '{\"EU_sizes\": {\"Kids\": [\"28\", \"29\", \"30\", \"31\", \"32\"]}}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `created_at`) VALUES
(1, 'Bojidar', 'angelovbojidar23@gmail.com', '$2y$10$PRNwLBq1XDns8r74ZZK4BO01StV/MlbMz6i8X4DaXu2RkOJ6x27Tq', '088945553535', 'customer', '2025-04-18 19:54:45'),
(2, 'Boored', 'bobo123@gmail.com', '$2y$10$Wt9SPb4ZCJpMDqjXkE0w7umjleg1oCM9BfgdpbCewcyfbNga6Ivq.', '0889455535', 'customer', '2025-05-28 05:43:26'),
(3, 'Boored2', 'bojidar123@gmail.com', '$2y$10$qMD/yIJVgGDG.vEzmFEu8uF3OEz8iHp6U643VoA8MaWBEQrOdYp/O', '0889455535', 'customer', '2025-06-03 19:22:09'),
(4, 'Boored2', 'admin@example.com', '$2y$10$GV6rpdShLyitYwRTDkl8qOc2OD.HO9EdSzFT2h0vV8tDyT5rocan.', '0885759695', 'admin', '2025-06-03 21:19:46'),
(5, 'Boored', 'laino123@gmail.com', '$2y$10$3gaDwedhiXCru3zt0oL7ie5.sovc6t9c4qLhgIkmwS6uS7/5fXYdy', '0889455535', 'customer', '2025-06-06 20:37:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_product_unique` (`user_id`,`product_id`),
  ADD KEY `favorites_ibfk_2` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
