-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 12:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$cB8L8WeYhHj5gLQghtFl3uov5MhwHkB.WQ/nm9v/fVNGSn/LvKIYS');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(32) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_modify` datetime NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(128) NOT NULL,
  `author` varchar(64) NOT NULL,
  `publisher` varchar(64) NOT NULL,
  `language` varchar(32) NOT NULL,
  `format` varchar(32) NOT NULL,
  `pages` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category`, `date_create`, `date_modify`, `description`, `thumbnail`, `author`, `publisher`, `language`, `format`, `pages`) VALUES
(1, 'Amazon Kindle', 99.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'Amazon Kindle – The lightest and most compact Kindle, with extended battery life, adjustable front light, and 16 GB storage – Denim 4.7 out of 5 stars 17,294', 'products_images/71dFhAIwENL._AC_UY218_.jpg', 'Amazon', 'Amazon', 'English', 'ebook', 0),
(2, 'Kindle Paperwhite Kids', 299.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'Kindle Paperwhite Kids – kids read, on average, more than an hour a day with their Kindle - 16 GB, Emerald Forest', 'products_images/61mQ-gPhWlL._AC_UY218_.jpg', 'Amazon', 'Amazon', 'English', 'ebook', 0),
(3, 'A Gentleman in Moscow: A Novel', 20.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'A Gentleman in Moscow: A Novel', 'products_images/91Jq5eWCNYL._AC_UY218_.jpg', 'Amor Towles', 'Viking', 'English', 'Hardcover', 480),
(4, 'The 4 Pillars of Critical Thinking', 78.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'The 4 Pillars of Critical Thinking: 103 Techniques & Hacks to Improve Your Work and Personal Life by Mastering Mental Skills. Analyze Situations Better and Reason Well by Detecting Logical Fallacies', 'products_images/61HPS4EC6VL._AC_UY218_.jpg', 'Michael Driscoll', 'Unknown', 'English', 'Paperback', 197),
(5, 'How Highly Effective People Speak', 19.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'How Highly Effective People Speak: How High Performers Use Psychology to Influence With Ease (Speak for Success)', 'products_images/613LB27NEkL._AC_UY218_.jpg', 'Unknown Author', 'Unknown Publisher', 'English', 'Paperback', 200),
(6, 'Selling Used Books Online', 60.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'Make $1000+ A Month Selling Used Books Online WITHOUT Amazon: Easy Ways to Make Extra Money With Websites That Pay Cash For Books! (Sell Books Fast Online Book 5)', 'products_images/81nm9c0M-xL._AC_UY218_.jpg', 'Michael Driscoll', 'Unknown', 'English', 'Paperback', 150),
(7, 'Chasing Justice', 67.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'Chasing Justice (Piper Anderson Series Book 1)', 'products_images/81EQMKgsuqL._AC_UY218_.jpg', 'Danielle Stewart', 'Independently published', 'English', 'Paperback', 340),
(8, 'The Family Secret', 67.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'The Family Secret', 'products_images/914661eRCnL._AC_UY218_.jpg', 'Terry Lynn Thomas', 'HQ Digital', 'English', 'Paperback', 450),
(9, 'The Silent Patient', 56.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'The Silent Patient', 'products_images/91BbLCJOruL._AC_UY218_.jpg', 'Alex Michaelides', 'Celadon Books', 'English', 'Hardcover', 320),
(10, 'My Life in Rhinestones', 45.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'Behind the Seams: My Life in Rhinestones', 'products_images/91Mh9bDFK5L._AC_UY218_.jpg', 'Ginger Rue', 'Graphix', 'English', 'Paperback', 150),
(11, 'Dark State (Jason Trapp Thriller Book 1)', 45.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'Dark State (Jason Trapp Thriller Book 1)', 'products_images/813+6qFA5pL._AC_UY218_.jpg', 'William Hertling', 'Liquididea Press', 'English', 'Paperback', 270),
(12, 'Coaching Habit', 64.00, 'books', '2024-05-11 15:44:53', '2024-05-11 15:44:53', 'Coaching Habit', 'products_images/71SJhMsQe7S._AC_UY218_.jpg', 'Michael Bungay Stanier', 'Box of Crayons Press', 'English', 'Hardcover', 290);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_unique` (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
