-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 07, 2025 at 03:06 PM
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
-- Database: `mydatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `user_id`, `quantity`) VALUES
(62, 10, 7, 3),
(72, 6, 2, 1),
(80, 17, 9, 1),
(110, 17, 4, 1),
(111, 18, 8, 3),
(112, 16, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `email`, `message`, `created_at`) VALUES
(1, '123antonslavchev@gmail.com', 'etye5tysrht467ioi', '2025-03-26 06:43:19'),
(2, 'dokibg5@gmail.com', 'Парфюма дойде счупен, има ли как да се достави отново с компенсация ?', '2025-04-15 20:13:02'),
(3, 'angelovbojidar23@gmail.com', 'hi i ordered ioadjnasiokjd, i want it back', '2025-06-07 11:47:34'),
(4, 'angelovbojidar23@gmail.com', 'uoahsdjo[uiashjodijasoidjuoahsdjo[uiashjodijasoidjuoahsdjo[uiashjodijasoidjuoahsdjo[uiashjodijasoidjuoahsdjo[uiashjodijasoidjuoahsdjo[uiashjodijasoidjuoahsdjo[uiashjodijasoidjuoahsdjo[uiashjodijasoidjuoahsdjo[uiashjodijasoidjuoahsdjo[uiashjodijasoidjuoahsdjo[uiashjodijasoidj', '2025-06-07 11:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `payment_method` enum('cash','card') DEFAULT NULL,
  `card_number` varchar(16) DEFAULT NULL,
  `cart_items` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gender` varchar(25) NOT NULL,
  `type` varchar(25) NOT NULL,
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`, `gender`, `type`, `quantity`) VALUES
(15, 'Bako Radhan', 'img/shop1.png', 30.00, 'male', 'woody', 49),
(16, 'YCL', 'img/shop2.png', 90.00, 'female', 'floral', 4),
(17, 'Eclipse Noir', 'img/shop3.png', 78.00, 'male', 'oriental', 49),
(18, 'Velvet Dusk', 'img/shop4.png', 56.00, 'female', 'fresh', 48),
(19, 'Moonlit Embrace', 'img/shop5.png', 53.00, 'male', 'woody', 50),
(20, 'Silk Reverie', 'img/shop6.png', 93.00, 'female', 'floral', 50),
(21, 'Mystic Bloom', 'img/shop7.png', 48.00, 'male', 'oriental', 50),
(22, 'Amber Mirage', 'img/shop8.png', 29.00, 'female', 'fresh', 50),
(23, 'Celestial Whisper', 'img/shop9.png', 79.00, 'male', 'woody', 50),
(24, 'Crimson Twilight', 'img/shop10.png', 33.00, 'female', 'floral', 50),
(25, 'Ivory Petal', 'img/shop11.png', 76.00, 'male', 'oriental', 50),
(26, 'Midnight Sonata', 'img/shop12.png', 49.99, 'male', 'woody', 50),
(27, 'Ivory Mirage', 'img/shop13.png', 54.99, 'female', 'floral', 50),
(28, 'Golden Euphoria', 'img/shop14.png', 59.99, 'male', 'oriental', 49),
(29, 'Velvet Ember', 'img/shop15.png', 45.50, 'female', 'fresh', 50),
(30, 'Seraphic Bloom', 'img/shop16.png', 64.99, 'male', 'woody', 50),
(31, 'Amber Cascade', 'img/shop17.png', 39.99, 'female', 'floral', 50),
(32, 'Opal Desire', 'img/shop18.png', 69.99, 'male', 'oriental', 50),
(33, 'Moonstone Essence', 'img/shop19.png', 55.00, 'female', 'fresh', 50),
(34, 'Saffron Twilight', 'img/shop20.png', 42.75, 'male', 'woody', 50),
(35, 'Whispering Orchid', 'img/shop21.png', 58.50, 'female', 'floral', 50),
(36, 'Rosewood Lullaby', 'img/shop22.png', 47.99, 'male', 'oriental', 49),
(37, 'Crimson Haze', 'img/shop23.png', 52.00, 'female', 'fresh', 50),
(38, 'Mystic Dew', 'img/shop24.png', 49.25, 'male', 'woody', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_descriptions`
--

CREATE TABLE `product_descriptions` (
  `product_id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_descriptions`
--

INSERT INTO `product_descriptions` (`product_id`, `description`) VALUES
(15, 'Bako Radhan is a daring woody fragrance that captures the essence of masculinity with rich cedarwood, earthy vetiver, and subtle hints of leather. Perfect for confident individuals who seek adventure and authenticity.'),
(16, 'YCL is a delicate floral perfume that opens with soft peony and sweet citrus, blossoming into a heart of jasmine and rose. It wraps the senses in a romantic embrace, ideal for elegant evenings or intimate moments.'),
(17, 'Eclipse Noir is an intense oriental fragrance crafted for the mysterious soul. With bold spices, warm amber, and a smoky oud base, it evokes the allure of the night and leaves a lasting impression.'),
(18, 'Velvet Dusk combines gentle lavender, creamy vanilla, and a whisper of powdery musk to create a soothing scent reminiscent of twilight serenity. Ideal for relaxed days and cozy nights.'),
(19, 'Moonlit Embrace offers a timeless woody aroma featuring sandalwood, patchouli, and a hint of smoky incense. It’s a grounding fragrance that embodies strength and calm under pressure.'),
(20, 'Silk Reverie is a floral masterpiece blending lily, tuberose, and white rose with a velvety musk base. Sensual and graceful, it lingers on the skin like a whispered dream.'),
(21, 'Mystic Bloom is an exotic oriental scent, merging saffron, clove, and dark resins with a soft touch of vanilla. Designed for those who thrive on mystery and allure.'),
(22, 'Amber Mirage is a fresh and revitalizing scent that opens with zesty bergamot and green tea, followed by delicate floral notes and soft musk. Ideal for daily wear with a clean finish.'),
(23, 'Celestial Whisper blends cedar, amber, and aromatic herbs to create a woody fragrance that is both uplifting and grounding. It inspires a sense of cosmic wonder and introspection.'),
(24, 'Crimson Twilight is a passionate floral scent with rose, red berries, and a heart of spicy carnation. Perfect for bold personalities and moments that demand attention.'),
(25, 'Ivory Petal is an oriental fragrance defined by spicy cardamom, creamy sandalwood, and a subtle vanilla finish. It’s luxurious, refined, and unforgettable.'),
(26, 'Midnight Sonata features rich wood notes, dark chocolate, and smoky vetiver to create a deep, alluring profile. Best worn on cold nights or formal events.'),
(27, 'Ivory Mirage is a feminine floral fragrance that enchants with orange blossom, freesia, and white musk. Light yet expressive, it’s made for graceful confidence.'),
(28, 'Golden Euphoria is an intense oriental blend of cinnamon, amber, and tonka bean, radiating warmth and mystery. A bold fragrance for unforgettable nights.'),
(29, 'Velvet Ember brings a modern touch to fresh perfumes with notes of pear, freesia, and soft musk. Its light sweetness is perfect for daytime elegance.'),
(30, 'Seraphic Bloom is a luxurious woody fragrance with notes of cypress, dry amber, and a floral heart of iris. It offers a harmonious blend of strength and serenity.'),
(31, 'Amber Cascade envelops you in a gentle stream of florals, with magnolia, rose, and a warm amber undertone. It’s feminine, radiant, and timeless.'),
(32, 'Opal Desire seduces the senses with deep oriental notes of incense, black pepper, and silky tonka. This scent speaks to bold spirits with a taste for the extraordinary.'),
(33, 'Moonstone Essence is a soothing fresh fragrance combining lotus, jasmine, and cool aquatic notes. Designed to relax the mind and uplift the soul.'),
(34, 'Saffron Twilight brings together rare saffron, dry woods, and smoky leather for a bold and sophisticated signature. Ideal for evening wear and powerful impressions.'),
(35, 'Whispering Orchid is a sensual floral fragrance with orchid, white peony, and a soft vanilla base. A perfect match for those who cherish elegance and poise.'),
(36, 'Rosewood Lullaby is a romantic oriental blend of rosewood, creamy sandalwood, and hints of sweet plum. Smooth and intoxicating, it is ideal for close encounters.'),
(37, 'Crimson Haze is a fresh and bold fragrance that pairs citrus zest with red currants and a green floral heart. It’s an energizing choice for confident individuals.'),
(38, 'Mystic Dew opens with mint and eucalyptus, transitions into herbal lavender, and settles into a mossy woody base. Refreshing, grounded, and mysteriously cool.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'img/default.jpg',
  `is_admin` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_picture`, `is_admin`) VALUES
(17, 'boored1', 'angelovbojidar23@gmail.com', '$2y$10$P4Kq7BqTn7SmYFsBWeF0TOIhFdyD/fa6zy9M0L5M4/Hziba0c0ycW', 'img/6844336a78b85.png', NULL),
(18, 'Admin01', 'admin@gmail.com', '$2y$10$E9JjEtkkm2wdAzdnPmppnOEn.jLv.Co0Y1Vbrl.PXPrnbNZpEeEVC', 'img/default.jpg', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_descriptions`
--
ALTER TABLE `product_descriptions`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `product_descriptions`
--
ALTER TABLE `product_descriptions`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
