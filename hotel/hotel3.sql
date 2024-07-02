-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 02:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel3`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `adults` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `special_request` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Booked',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `guest_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` int(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`guest_id`, `name`, `email`, `phone`, `password`, `created_at`) VALUES
(5, 'faisa', 'faisa@gmail.com', 12345676, '111', '2024-06-22 08:41:06'),
(6, 'wonuu', 'wonu@gmail.com', 123244, '000', '2024-06-22 09:32:45');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `availability` tinyint(1) DEFAULT 1,
  `description` text DEFAULT NULL,
  `bed` int(2) DEFAULT NULL,
  `bath` int(2) DEFAULT NULL,
  `wifi` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_type`, `price`, `availability`, `description`, `bed`, `bath`, `wifi`, `created_at`) VALUES
(1, 'Super Deluxe', 10000000, 1, 'Super Deluxe Room menawarkan pengalaman menginap yang luar biasa dengan kombinasi kemewahan dan kenyamanan. Kamar ini lebih besar dari kamar deluxe biasa dan dilengkapi dengan fasilitas modern serta pemandangan yang indah.', 2, 2, 1, '2024-06-22 08:05:16'),
(2, 'Executive Suite', 7000000, 1, 'Executive Suite menawarkan kemewahan dan ruang yang lebih luas, ideal untuk tamu yang membutuhkan fasilitas tambahan dan privasi. Kamar ini memiliki ruang tamu terpisah. Desain interiornya modern dan elegan, memberikan kesan eksklusif dan prestisius.', 2, 2, 1, '2024-06-22 08:05:55'),
(3, 'Junior Suite', 5000000, 1, 'Junior Suite dirancang untuk memberikan kenyamanan dan kemewahan. Kamar ini biasanya dilengkapi dengan area tempat duduk terpisah. Interiornya elegan dengan perabotan modern dan dekorasi yang menawan, menciptakan suasana yang hangat dan ramah.', 2, 1, 1, '2024-06-22 08:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `services_id` int(11) NOT NULL,
  `services_name` varchar(20) NOT NULL,
  `services_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`services_id`, `services_name`, `services_desc`) VALUES
(1, 'Rooms', 'Nikmati pilihan kamar mewah kami yang dirancang untuk memberikan kenyamanan maksimal dan suasana elegan. Setiap kamar mendapatkan pemandangan menakjubkan yang dapat dinikmati dari jendela kamar Anda'),
(2, 'Food & Restaurants', 'Menawarkan beragam hidangan lezat, mulai dari masakan lokal otentik hingga kreasi internasional yang inovatif. Dengan suasana yang hangat dan pelayanan yang ramah, setiap santapan di restoran kami adalah pengalaman kuliner yang tak terlupakan'),
(3, 'Spa & Fitness', 'Manjakan diri anda di spa kami yang tenang, tempat perawatan holistik dan pijat menyeluruh akan meremajakan tubuh dan pikiran anda. Lengkapi pengalaman dengan fasilitas kebugaran kami yang canggih untuk menjaga kebugaran anda selama menginap'),
(4, 'Sports & Gaming', 'Nikmati beragam fasilitas olahraga dan hiburan kami, termasuk kolam renang, lapangan tenis, dan ruang permainan yang dilengkapi dengan permainan video terbaru dan meja biliar. Kami menyediakan aktivitas yang sesuai untuk semua usia dan minat'),
(5, 'Event & Party', 'Tempat yang sempurna untuk menyelenggarakan berbagai bidang acara spesial. Dengan ruang serbaguna yang elegan dan tim penyelenggara acara yang profesional, kami menjamin setiap detail acara Anda akan dikelola dengan sempurna, dari pesta pribadi hingga konferensi bisnis'),
(6, 'GYM & Yoga', 'Tingkatkan rutinitas kebugaran anda di pusat kebugaran kami yang lengkap, atau temukan keseimbangan dan ketenangan di kelas yoga kami.Dengan peralatan modern dan instruktur berpengalaman, kami memastikan anda tetap aktif dan sehat selama menginap');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` double NOT NULL,
  `payment_method` varchar(20) NOT NULL DEFAULT 'Credit Card',
  `transaction_status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`guest_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payments_transaction` (`transaction_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`services_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD UNIQUE KEY `booking_id` (`booking_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `services_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`guest_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_transaction` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`),
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
