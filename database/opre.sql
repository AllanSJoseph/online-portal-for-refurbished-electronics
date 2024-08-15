-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2024 at 04:34 PM
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
-- Database: `opre`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `c_id` int(11) NOT NULL,
  `b_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `bid`, `pid`, `sid`, `qty`, `order_date`, `status`) VALUES
(1, 3, 1, 2, 1, '2024-06-12', 0),
(2, 3, 1, 2, 1, '2024-06-12', 1),
(3, 3, 14, 4, 1, '2024-06-18', NULL),
(4, 3, 11, 2, 1, '2024-08-14', NULL),
(23, 5, 12, 4, 1, '2024-08-14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pid` int(11) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `images` text NOT NULL,
  `seller` int(255) NOT NULL,
  `status` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pid`, `pname`, `brand`, `category`, `price`, `quantity`, `description`, `images`, `seller`, `status`, `added_at`) VALUES
(1, 'Refurbished MacBook Air', 'Apple', 'Laptops', 45000.00, 0, 'Refurbished MacBook Air\r\nGood Condition\r\nScreen is replaced', '../productimages/mcbok.webp', 2, 2, '2024-05-20 07:30:32'),
(2, 'Refurbished Oppo A38', 'oppo', 'Phones', 6999.00, 5, 'Good Condition,\r\nPoor Battery,\r\nHas some scratches', '../productimages/oppophone.jpg', 2, 0, '2024-05-20 19:35:25'),
(4, 'Nothing Phone 2', 'Nothing', 'Phones', 6400.00, 2, 'Nothing Phone 2\r\nGood Condition\r\nOn Latest Software Update\r\nStable', '../productimages/notph2.jpg', 2, 0, '2024-05-22 12:14:05'),
(6, 'Refurbished Samsung Fridge', 'Samsung', 'Home Appliances', 4500.00, 1, 'Refurbished Samsung Fridge\r\nGood Condition', '../productimages/samsungfridge.jpg', 4, 0, '2024-05-25 08:58:13'),
(7, 'Nothing Phone 1', 'Nothing', 'Phones', 7000.00, 4, 'Refurbished Nothing Phone 1\r\nSnapdragon 7 Gen 1 CPU, 8 GB/256GB storage\r\nCharger included, Screen and Battery Replaced', '../productimages/NothingPhone1.png', 4, 0, '2024-05-25 15:00:10'),
(9, 'iphone 6s Second Hand', 'Apple', 'Phones', 7500.00, 1, 'Bad Condition\r\nScreen Replaced, bad battery backup', '../productimages/iphone6s.jpg', 2, 0, '2024-05-25 16:39:07'),
(10, 'Galaxy S9', 'Samsung', 'Phones', 2000.00, 2, 'Broken Galaxy S9\r\nOnly back glass broken\r\nscreen and camera working completely', '../productimages/brokens9.jpg', 2, 0, '2024-06-12 20:19:50'),
(11, 'Second Hand Dishwasher', 'TCL', 'Home Appliances', 5000.00, 1, 'Old Dishwasher\r\nUsed for 5 years\r\nWorking perfectly fine\r\nminor scratches on surface', '../productimages/secondhnddishwasher.jpg', 2, 1, '2024-06-12 20:22:58'),
(12, 'Used Projector', 'EPSON', 'Home Appliances', 2500.00, 0, 'Used Projector\r\ndecent image quality\r\nmake: 2004', '../productimages/secondprojector.jpg', 4, 2, '2024-06-12 20:26:57'),
(13, 'Refurbished Airpods PRO', 'Apple', 'Phone Accessories', 4000.00, 1, 'Apple Refurbished Airpods Pro\r\nWell maintained for 2 years of use', '../productimages/airpod.jpg', 4, 0, '2024-06-12 20:29:57'),
(14, 'Second hand Iphone 12 PRO ', 'Apple', 'Phones', 5000.00, 3, 'Only back is broken\r\nPhone is working perfectly fine\r\nback camera has some problem\r\nUsed for 2 years', '../productimages/iphone12broken.jpeg', 4, 1, '2024-06-12 20:34:57'),
(15, 'Second Hand TCL Fridge', 'TCL', 'Home Appliances', 7000.00, 1, 'Second Hand TCL Fridge\r\n5 star power efficiency rating\r\nhas some dents on corners\r\nstill on compressor warranty (1 more year left)', '../productimages/tclrfurbished.jpg', 4, 0, '2024-06-12 20:40:44'),
(16, 'Refurbished Lenovo Thinkpad Laptop', 'Lenovo', 'Laptops', 27000.00, 1, 'Refurbished Lenovo Thinkpad 15 inch laptop\r\nOn Good Condition\r\nWindows 10\r\n1 TB SSD, 16 GB DDR4 RAM\r\nIntel i5 12540 H, Nvidia GeForce RTX 2050 Ti Graphics', '../productimages/lenthinkpad.png', 4, 0, '2024-06-20 19:35:56'),
(17, 'Samsung Fridge', 'Samsung', 'Home Appliances', 25000.00, 1, 'Samsung Fridge, Refurbished, good working condition', '../productimages/OIP.jpg', 2, 0, '2024-07-12 04:49:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mob_no` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `email`, `name`, `mob_no`, `address`, `password`, `type`) VALUES
(1, 'admin@opre.com', 'Admin', '4555334422', 'administrator', 'admin123', 'Admin'),
(2, 'seller1@opre.com', 'seller1', '3445566213', 'seller 1, Kozhikode, Kerala, India', 's123', 'Seller'),
(3, 'buyer1@gmail.com', 'Buyer 1', '9993421256', 'buyer1, Ernakulam, kerala, india', 'buyer1', 'Buyer'),
(4, 'seller2@opre.com', 'seller2', '9876875643', 'seller2, Kasaragod, Kerala, India', 's234', 'Seller'),
(5, 'buyer2@gmail.com', 'Buyer2', '9658296363', 'Buyer 2 , Thiruvananthapuram, Kerala, India', 'buy234', 'Buyer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
