-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 09:41 AM
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
-- Database: `roroferry`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('nenish@gmail.com', 'nenish123');

-- --------------------------------------------------------

--
-- Table structure for table `admin_contact`
--

CREATE TABLE `admin_contact` (
  `id` int(11) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `gmap` varchar(100) DEFAULT NULL,
  `pn1` bigint(20) DEFAULT NULL,
  `pn2` bigint(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fb` varchar(100) DEFAULT NULL,
  `insta` varchar(100) DEFAULT NULL,
  `tw` varchar(100) DEFAULT NULL,
  `iframe` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_contact`
--

INSERT INTO `admin_contact` (`id`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`) VALUES
(1, '102, International Business Hub, Vesu, Surat', 'https://maps.app.goo.gl/edZJ2p5cthX7gSkw7', 917069385883, 919724481146, 'support@roroferry.com', 'https://www.facebook.com/dgseaconnect/photos/', 'https://www.instagram.com/reel/CwHy2n2IC_I/', 'https://x.com/DGSeaconnect?s=09Twitter.com', 'https://www.google.com/maps/d/embed?mid=1r6vDdBdPn1j8kIdcXsOgTjuo5ts');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `trip_id` int(11) DEFAULT NULL,
  `seat_numbers` text NOT NULL,
  `passenger_details` text NOT NULL,
  `total_amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `uid`, `pid`, `trip_id`, `seat_numbers`, `passenger_details`, `total_amount`, `created_at`, `status`) VALUES
(36, 38, 26, 80, 'P26-T80-A2', '[{\"seat\":\"P26-T80-A2\",\"name\":\"Nenish Jajadiya\",\"age\":\"21\",\"gender\":\"Male\"}]', 14999, '2025-04-14 06:21:01', 1),
(37, 38, 26, 80, 'P26-T80-A2', '[{\"seat\":\"P26-T80-A2\",\"name\":\"Nenish Jajadiya\",\"age\":\"21\",\"gender\":\"Male\"}]', 14999, '2025-04-14 06:22:23', 0),
(38, 38, 26, 79, 'P26-T79-A3', '[{\"seat\":\"P26-T79-A3\",\"name\":\"Purv Jajadiya\",\"age\":\"21\",\"gender\":\"Male\"}]', 14999, '2025-04-14 06:33:22', 0),
(39, 38, 28, 78, 'P28-T78-A3', '[{\"seat\":\"P28-T78-A3\",\"name\":\"Nenish Jajadiya\",\"age\":\"21\",\"gender\":\"Male\"}]', 6999, '2025-04-14 06:38:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `cid` int(11) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`cid`, `image`) VALUES
(3, 'carousel_67f0c7d860f727.18039212.jpg'),
(4, 'carousel_67f0c7e15292d2.81453086.jpg'),
(5, 'carousel_67f0c7f73adca9.67514763.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `message` varchar(150) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `fid` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`fid`, `icon`, `name`, `description`) VALUES
(18, 'facility_67fc98800dfe63.70963263.jpeg', 'Club', 'The Club is here to help you feel 🌿 calm, 😊 happy, and ✨ peaceful in everyday life.'),
(19, 'facility_67fc98bfbf3918.51407367.jpg', 'Swimming Pool', 'Nothing beats a fun time in the pool! 🏖️ The water is as clear as glass 💎 and as blue as the summer sky 🌞.'),
(20, 'facility_67fc9900bdc492.12452683.jpeg', 'Cinema Hall', 'Step into the cinema for a fun movie experience 🎥 and enjoy exciting films with your loved ones 🍿.'),
(21, 'facility_67fc9936ede785.34812106.jpg', 'Gym', 'A gym is not just for getting fit; it’s also where you unwind, make friends, and feel great! 💪😊'),
(22, 'facility_67fc999e67eab9.74018571.jpeg', 'Hotel', 'Experience top-notch facilities with breathtaking views at every turn 🌳.'),
(23, 'facility_67fc9a497967c2.30418478.jpeg', 'Game Zone', 'Step into the Game Zone for nonstop fun and excitement 🕹️🎉!');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `feid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`feid`, `name`) VALUES
(38, 'Snacks'),
(39, 'Wi-Fi'),
(40, 'Café'),
(41, 'VIP Lounge'),
(42, 'Priority boarding'),
(43, 'Extra baggage'),
(44, 'Quick refund'),
(45, 'Sunset deck'),
(46, 'Recliners');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `pid` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `adult` int(11) DEFAULT NULL,
  `children` int(11) DEFAULT NULL,
  `description` varchar(350) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `removed` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`pid`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(26, 'Diamond', 1500, 14999, 10, 3, 2, 'The Diamond Package offers the ultimate in luxury and convenience, providing exclusive access to premium facilities and personalized services. Enjoy VIP Lounge, Extra baggage, Quick refund and much more for a truly exceptional travel experience.', 1, 0),
(27, 'Gold', 1000, 9999, 15, 4, 3, 'The Gold Package offers a perfect balance of comfort and convenience, with access to premium facilities and attentive services. Enjoy Free Snacks, Sunset Deck and much more for a memorable and enjoyable travel experience.', 1, 0),
(28, 'Silver', 700, 6999, 20, 4, 4, 'The Silver Package offers a blend of value and convenience, providing access to essential facilities and dependable services. Enjoy comfortable seating, prompt check-in, free wi-fi, swimming pool and efficient support — all designed for a smooth and satisfying travel experience.', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `package_facilities`
--

CREATE TABLE `package_facilities` (
  `pfid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `fid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_facilities`
--

INSERT INTO `package_facilities` (`pfid`, `pid`, `fid`) VALUES
(123, 26, 18),
(124, 26, 19),
(125, 26, 20),
(126, 26, 21),
(127, 26, 22),
(128, 26, 23),
(129, 27, 18),
(130, 27, 19),
(131, 27, 21),
(132, 27, 22),
(133, 28, 18),
(134, 28, 19);

-- --------------------------------------------------------

--
-- Table structure for table `package_features`
--

CREATE TABLE `package_features` (
  `pfeid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `feid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_features`
--

INSERT INTO `package_features` (`pfeid`, `pid`, `feid`) VALUES
(117, 26, 38),
(118, 26, 39),
(119, 26, 40),
(120, 26, 41),
(121, 26, 42),
(122, 26, 43),
(123, 26, 44),
(124, 26, 45),
(125, 26, 46),
(126, 27, 38),
(127, 27, 39),
(128, 27, 40),
(129, 27, 44),
(130, 27, 45),
(131, 28, 38),
(132, 28, 39),
(133, 28, 40);

-- --------------------------------------------------------

--
-- Table structure for table `package_image`
--

CREATE TABLE `package_image` (
  `piid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_image`
--

INSERT INTO `package_image` (`piid`, `pid`, `image`, `thumb`) VALUES
(23, 26, 'IMG_23497.jpg', 1),
(24, 26, 'IMG_11630.jpg', 0),
(25, 26, 'IMG_32034.jpg', 0),
(26, 26, 'IMG_62007.jpg', 0),
(27, 27, 'IMG_63713.jpg', 1),
(28, 27, 'IMG_96745.jpg', 0),
(29, 27, 'IMG_83081.webp', 0),
(30, 28, 'IMG_31268.jpg', 1),
(31, 28, 'IMG_81815.jpg', 0),
(32, 28, 'IMG_88769.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seat_id` int(11) NOT NULL,
  `trip_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `seat_number` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `is_booked` tinyint(1) DEFAULT 0,
  `booked_by` int(11) DEFAULT NULL,
  `booked_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`seat_id`, `trip_id`, `package_id`, `seat_number`, `status`, `is_booked`, `booked_by`, `booked_at`) VALUES
(641, 78, 26, 'P26-T78-A1', 0, 0, NULL, NULL),
(642, 78, 26, 'P26-T78-A2', 0, 0, NULL, NULL),
(643, 78, 26, 'P26-T78-A3', 0, 0, NULL, NULL),
(644, 78, 26, 'P26-T78-A4', 0, 0, NULL, NULL),
(645, 78, 26, 'P26-T78-A5', 0, 0, NULL, NULL),
(646, 78, 26, 'P26-T78-A6', 0, 0, NULL, NULL),
(647, 78, 26, 'P26-T78-A7', 0, 0, NULL, NULL),
(648, 78, 26, 'P26-T78-A8', 0, 0, NULL, NULL),
(649, 78, 26, 'P26-T78-A9', 0, 0, NULL, NULL),
(650, 78, 26, 'P26-T78-A10', 0, 0, NULL, NULL),
(651, 78, 27, 'P27-T78-A1', 0, 0, NULL, NULL),
(652, 78, 27, 'P27-T78-A2', 0, 0, NULL, NULL),
(653, 78, 27, 'P27-T78-A3', 0, 0, NULL, NULL),
(654, 78, 27, 'P27-T78-A4', 0, 0, NULL, NULL),
(655, 78, 27, 'P27-T78-A5', 0, 0, NULL, NULL),
(656, 78, 27, 'P27-T78-A6', 0, 0, NULL, NULL),
(657, 78, 27, 'P27-T78-A7', 0, 0, NULL, NULL),
(658, 78, 27, 'P27-T78-A8', 0, 0, NULL, NULL),
(659, 78, 27, 'P27-T78-A9', 0, 0, NULL, NULL),
(660, 78, 27, 'P27-T78-A10', 0, 0, NULL, NULL),
(661, 78, 27, 'P27-T78-A11', 0, 0, NULL, NULL),
(662, 78, 27, 'P27-T78-A12', 0, 0, NULL, NULL),
(663, 78, 27, 'P27-T78-A13', 0, 0, NULL, NULL),
(664, 78, 27, 'P27-T78-A14', 0, 0, NULL, NULL),
(665, 78, 27, 'P27-T78-A15', 0, 0, NULL, NULL),
(666, 78, 28, 'P28-T78-A1', 0, 0, NULL, NULL),
(667, 78, 28, 'P28-T78-A2', 0, 0, NULL, NULL),
(668, 78, 28, 'P28-T78-A3', 0, 1, NULL, NULL),
(669, 78, 28, 'P28-T78-A4', 0, 0, NULL, NULL),
(670, 78, 28, 'P28-T78-A5', 0, 0, NULL, NULL),
(671, 78, 28, 'P28-T78-A6', 0, 0, NULL, NULL),
(672, 78, 28, 'P28-T78-A7', 0, 0, NULL, NULL),
(673, 78, 28, 'P28-T78-A8', 0, 0, NULL, NULL),
(674, 78, 28, 'P28-T78-A9', 0, 0, NULL, NULL),
(675, 78, 28, 'P28-T78-A10', 0, 0, NULL, NULL),
(676, 78, 28, 'P28-T78-A11', 0, 0, NULL, NULL),
(677, 78, 28, 'P28-T78-A12', 0, 0, NULL, NULL),
(678, 78, 28, 'P28-T78-A13', 0, 0, NULL, NULL),
(679, 78, 28, 'P28-T78-A14', 0, 0, NULL, NULL),
(680, 78, 28, 'P28-T78-A15', 0, 0, NULL, NULL),
(681, 78, 28, 'P28-T78-A16', 0, 0, NULL, NULL),
(682, 78, 28, 'P28-T78-A17', 0, 0, NULL, NULL),
(683, 78, 28, 'P28-T78-A18', 0, 0, NULL, NULL),
(684, 78, 28, 'P28-T78-A19', 0, 0, NULL, NULL),
(685, 78, 28, 'P28-T78-A20', 0, 0, NULL, NULL),
(686, 79, 26, 'P26-T79-A1', 0, 0, NULL, NULL),
(687, 79, 26, 'P26-T79-A2', 0, 0, NULL, NULL),
(688, 79, 26, 'P26-T79-A3', 0, 0, NULL, NULL),
(689, 79, 26, 'P26-T79-A4', 0, 0, NULL, NULL),
(690, 79, 26, 'P26-T79-A5', 0, 0, NULL, NULL),
(691, 79, 26, 'P26-T79-A6', 0, 0, NULL, NULL),
(692, 79, 26, 'P26-T79-A7', 0, 0, NULL, NULL),
(693, 79, 26, 'P26-T79-A8', 0, 0, NULL, NULL),
(694, 79, 26, 'P26-T79-A9', 0, 0, NULL, NULL),
(695, 79, 26, 'P26-T79-A10', 0, 0, NULL, NULL),
(696, 79, 27, 'P27-T79-A1', 0, 0, NULL, NULL),
(697, 79, 27, 'P27-T79-A2', 0, 0, NULL, NULL),
(698, 79, 27, 'P27-T79-A3', 0, 0, NULL, NULL),
(699, 79, 27, 'P27-T79-A4', 0, 0, NULL, NULL),
(700, 79, 27, 'P27-T79-A5', 0, 0, NULL, NULL),
(701, 79, 27, 'P27-T79-A6', 0, 0, NULL, NULL),
(702, 79, 27, 'P27-T79-A7', 0, 0, NULL, NULL),
(703, 79, 27, 'P27-T79-A8', 0, 0, NULL, NULL),
(704, 79, 27, 'P27-T79-A9', 0, 0, NULL, NULL),
(705, 79, 27, 'P27-T79-A10', 0, 0, NULL, NULL),
(706, 79, 27, 'P27-T79-A11', 0, 0, NULL, NULL),
(707, 79, 27, 'P27-T79-A12', 0, 0, NULL, NULL),
(708, 79, 27, 'P27-T79-A13', 0, 0, NULL, NULL),
(709, 79, 27, 'P27-T79-A14', 0, 0, NULL, NULL),
(710, 79, 27, 'P27-T79-A15', 0, 0, NULL, NULL),
(711, 79, 28, 'P28-T79-A1', 0, 0, NULL, NULL),
(712, 79, 28, 'P28-T79-A2', 0, 0, NULL, NULL),
(713, 79, 28, 'P28-T79-A3', 0, 0, NULL, NULL),
(714, 79, 28, 'P28-T79-A4', 0, 0, NULL, NULL),
(715, 79, 28, 'P28-T79-A5', 0, 0, NULL, NULL),
(716, 79, 28, 'P28-T79-A6', 0, 0, NULL, NULL),
(717, 79, 28, 'P28-T79-A7', 0, 0, NULL, NULL),
(718, 79, 28, 'P28-T79-A8', 0, 0, NULL, NULL),
(719, 79, 28, 'P28-T79-A9', 0, 0, NULL, NULL),
(720, 79, 28, 'P28-T79-A10', 0, 0, NULL, NULL),
(721, 79, 28, 'P28-T79-A11', 0, 0, NULL, NULL),
(722, 79, 28, 'P28-T79-A12', 0, 0, NULL, NULL),
(723, 79, 28, 'P28-T79-A13', 0, 0, NULL, NULL),
(724, 79, 28, 'P28-T79-A14', 0, 0, NULL, NULL),
(725, 79, 28, 'P28-T79-A15', 0, 0, NULL, NULL),
(726, 79, 28, 'P28-T79-A16', 0, 0, NULL, NULL),
(727, 79, 28, 'P28-T79-A17', 0, 0, NULL, NULL),
(728, 79, 28, 'P28-T79-A18', 0, 0, NULL, NULL),
(729, 79, 28, 'P28-T79-A19', 0, 0, NULL, NULL),
(730, 79, 28, 'P28-T79-A20', 0, 0, NULL, NULL),
(731, 80, 26, 'P26-T80-A1', 0, 0, NULL, NULL),
(732, 80, 26, 'P26-T80-A2', 0, 0, NULL, NULL),
(733, 80, 26, 'P26-T80-A3', 0, 0, NULL, NULL),
(734, 80, 26, 'P26-T80-A4', 0, 0, NULL, NULL),
(735, 80, 26, 'P26-T80-A5', 0, 0, NULL, NULL),
(736, 80, 26, 'P26-T80-A6', 0, 0, NULL, NULL),
(737, 80, 26, 'P26-T80-A7', 0, 0, NULL, NULL),
(738, 80, 26, 'P26-T80-A8', 0, 0, NULL, NULL),
(739, 80, 26, 'P26-T80-A9', 0, 0, NULL, NULL),
(740, 80, 26, 'P26-T80-A10', 0, 0, NULL, NULL),
(741, 80, 27, 'P27-T80-A1', 0, 0, NULL, NULL),
(742, 80, 27, 'P27-T80-A2', 0, 0, NULL, NULL),
(743, 80, 27, 'P27-T80-A3', 0, 0, NULL, NULL),
(744, 80, 27, 'P27-T80-A4', 0, 0, NULL, NULL),
(745, 80, 27, 'P27-T80-A5', 0, 0, NULL, NULL),
(746, 80, 27, 'P27-T80-A6', 0, 0, NULL, NULL),
(747, 80, 27, 'P27-T80-A7', 0, 0, NULL, NULL),
(748, 80, 27, 'P27-T80-A8', 0, 0, NULL, NULL),
(749, 80, 27, 'P27-T80-A9', 0, 0, NULL, NULL),
(750, 80, 27, 'P27-T80-A10', 0, 0, NULL, NULL),
(751, 80, 27, 'P27-T80-A11', 0, 0, NULL, NULL),
(752, 80, 27, 'P27-T80-A12', 0, 0, NULL, NULL),
(753, 80, 27, 'P27-T80-A13', 0, 0, NULL, NULL),
(754, 80, 27, 'P27-T80-A14', 0, 0, NULL, NULL),
(755, 80, 27, 'P27-T80-A15', 0, 0, NULL, NULL),
(756, 80, 28, 'P28-T80-A1', 0, 0, NULL, NULL),
(757, 80, 28, 'P28-T80-A2', 0, 0, NULL, NULL),
(758, 80, 28, 'P28-T80-A3', 0, 0, NULL, NULL),
(759, 80, 28, 'P28-T80-A4', 0, 0, NULL, NULL),
(760, 80, 28, 'P28-T80-A5', 0, 0, NULL, NULL),
(761, 80, 28, 'P28-T80-A6', 0, 0, NULL, NULL),
(762, 80, 28, 'P28-T80-A7', 0, 0, NULL, NULL),
(763, 80, 28, 'P28-T80-A8', 0, 0, NULL, NULL),
(764, 80, 28, 'P28-T80-A9', 0, 0, NULL, NULL),
(765, 80, 28, 'P28-T80-A10', 0, 0, NULL, NULL),
(766, 80, 28, 'P28-T80-A11', 0, 0, NULL, NULL),
(767, 80, 28, 'P28-T80-A12', 0, 0, NULL, NULL),
(768, 80, 28, 'P28-T80-A13', 0, 0, NULL, NULL),
(769, 80, 28, 'P28-T80-A14', 0, 0, NULL, NULL),
(770, 80, 28, 'P28-T80-A15', 0, 0, NULL, NULL),
(771, 80, 28, 'P28-T80-A16', 0, 0, NULL, NULL),
(772, 80, 28, 'P28-T80-A17', 0, 0, NULL, NULL),
(773, 80, 28, 'P28-T80-A18', 0, 0, NULL, NULL),
(774, 80, 28, 'P28-T80-A19', 0, 0, NULL, NULL),
(775, 80, 28, 'P28-T80-A20', 0, 0, NULL, NULL),
(911, 84, 26, 'P26-T84-A1', 0, 0, NULL, NULL),
(912, 84, 26, 'P26-T84-A2', 0, 0, NULL, NULL),
(913, 84, 26, 'P26-T84-A3', 0, 0, NULL, NULL),
(914, 84, 26, 'P26-T84-A4', 0, 0, NULL, NULL),
(915, 84, 26, 'P26-T84-A5', 0, 0, NULL, NULL),
(916, 84, 26, 'P26-T84-A6', 0, 0, NULL, NULL),
(917, 84, 26, 'P26-T84-A7', 0, 0, NULL, NULL),
(918, 84, 26, 'P26-T84-A8', 0, 0, NULL, NULL),
(919, 84, 26, 'P26-T84-A9', 0, 0, NULL, NULL),
(920, 84, 26, 'P26-T84-A10', 0, 0, NULL, NULL),
(921, 84, 27, 'P27-T84-A1', 0, 0, NULL, NULL),
(922, 84, 27, 'P27-T84-A2', 0, 0, NULL, NULL),
(923, 84, 27, 'P27-T84-A3', 0, 0, NULL, NULL),
(924, 84, 27, 'P27-T84-A4', 0, 0, NULL, NULL),
(925, 84, 27, 'P27-T84-A5', 0, 0, NULL, NULL),
(926, 84, 27, 'P27-T84-A6', 0, 0, NULL, NULL),
(927, 84, 27, 'P27-T84-A7', 0, 0, NULL, NULL),
(928, 84, 27, 'P27-T84-A8', 0, 0, NULL, NULL),
(929, 84, 27, 'P27-T84-A9', 0, 0, NULL, NULL),
(930, 84, 27, 'P27-T84-A10', 0, 0, NULL, NULL),
(931, 84, 27, 'P27-T84-A11', 0, 0, NULL, NULL),
(932, 84, 27, 'P27-T84-A12', 0, 0, NULL, NULL),
(933, 84, 27, 'P27-T84-A13', 0, 0, NULL, NULL),
(934, 84, 27, 'P27-T84-A14', 0, 0, NULL, NULL),
(935, 84, 27, 'P27-T84-A15', 0, 0, NULL, NULL),
(936, 84, 28, 'P28-T84-A1', 0, 0, NULL, NULL),
(937, 84, 28, 'P28-T84-A2', 0, 0, NULL, NULL),
(938, 84, 28, 'P28-T84-A3', 0, 0, NULL, NULL),
(939, 84, 28, 'P28-T84-A4', 0, 0, NULL, NULL),
(940, 84, 28, 'P28-T84-A5', 0, 0, NULL, NULL),
(941, 84, 28, 'P28-T84-A6', 0, 0, NULL, NULL),
(942, 84, 28, 'P28-T84-A7', 0, 0, NULL, NULL),
(943, 84, 28, 'P28-T84-A8', 0, 0, NULL, NULL),
(944, 84, 28, 'P28-T84-A9', 0, 0, NULL, NULL),
(945, 84, 28, 'P28-T84-A10', 0, 0, NULL, NULL),
(946, 84, 28, 'P28-T84-A11', 0, 0, NULL, NULL),
(947, 84, 28, 'P28-T84-A12', 0, 0, NULL, NULL),
(948, 84, 28, 'P28-T84-A13', 0, 0, NULL, NULL),
(949, 84, 28, 'P28-T84-A14', 0, 0, NULL, NULL),
(950, 84, 28, 'P28-T84-A15', 0, 0, NULL, NULL),
(951, 84, 28, 'P28-T84-A16', 0, 0, NULL, NULL),
(952, 84, 28, 'P28-T84-A17', 0, 0, NULL, NULL),
(953, 84, 28, 'P28-T84-A18', 0, 0, NULL, NULL),
(954, 84, 28, 'P28-T84-A19', 0, 0, NULL, NULL),
(955, 84, 28, 'P28-T84-A20', 0, 0, NULL, NULL),
(956, 85, 26, 'P26-T85-A1', 0, 0, NULL, NULL),
(957, 85, 26, 'P26-T85-A2', 0, 0, NULL, NULL),
(958, 85, 26, 'P26-T85-A3', 0, 0, NULL, NULL),
(959, 85, 26, 'P26-T85-A4', 0, 0, NULL, NULL),
(960, 85, 26, 'P26-T85-A5', 0, 0, NULL, NULL),
(961, 85, 26, 'P26-T85-A6', 0, 0, NULL, NULL),
(962, 85, 26, 'P26-T85-A7', 0, 0, NULL, NULL),
(963, 85, 26, 'P26-T85-A8', 0, 0, NULL, NULL),
(964, 85, 26, 'P26-T85-A9', 0, 0, NULL, NULL),
(965, 85, 26, 'P26-T85-A10', 0, 0, NULL, NULL),
(966, 85, 27, 'P27-T85-A1', 0, 0, NULL, NULL),
(967, 85, 27, 'P27-T85-A2', 0, 0, NULL, NULL),
(968, 85, 27, 'P27-T85-A3', 0, 0, NULL, NULL),
(969, 85, 27, 'P27-T85-A4', 0, 0, NULL, NULL),
(970, 85, 27, 'P27-T85-A5', 0, 0, NULL, NULL),
(971, 85, 27, 'P27-T85-A6', 0, 0, NULL, NULL),
(972, 85, 27, 'P27-T85-A7', 0, 0, NULL, NULL),
(973, 85, 27, 'P27-T85-A8', 0, 0, NULL, NULL),
(974, 85, 27, 'P27-T85-A9', 0, 0, NULL, NULL),
(975, 85, 27, 'P27-T85-A10', 0, 0, NULL, NULL),
(976, 85, 27, 'P27-T85-A11', 0, 0, NULL, NULL),
(977, 85, 27, 'P27-T85-A12', 0, 0, NULL, NULL),
(978, 85, 27, 'P27-T85-A13', 0, 0, NULL, NULL),
(979, 85, 27, 'P27-T85-A14', 0, 0, NULL, NULL),
(980, 85, 27, 'P27-T85-A15', 0, 0, NULL, NULL),
(981, 85, 28, 'P28-T85-A1', 0, 0, NULL, NULL),
(982, 85, 28, 'P28-T85-A2', 0, 0, NULL, NULL),
(983, 85, 28, 'P28-T85-A3', 0, 0, NULL, NULL),
(984, 85, 28, 'P28-T85-A4', 0, 0, NULL, NULL),
(985, 85, 28, 'P28-T85-A5', 0, 0, NULL, NULL),
(986, 85, 28, 'P28-T85-A6', 0, 0, NULL, NULL),
(987, 85, 28, 'P28-T85-A7', 0, 0, NULL, NULL),
(988, 85, 28, 'P28-T85-A8', 0, 0, NULL, NULL),
(989, 85, 28, 'P28-T85-A9', 0, 0, NULL, NULL),
(990, 85, 28, 'P28-T85-A10', 0, 0, NULL, NULL),
(991, 85, 28, 'P28-T85-A11', 0, 0, NULL, NULL),
(992, 85, 28, 'P28-T85-A12', 0, 0, NULL, NULL),
(993, 85, 28, 'P28-T85-A13', 0, 0, NULL, NULL),
(994, 85, 28, 'P28-T85-A14', 0, 0, NULL, NULL),
(995, 85, 28, 'P28-T85-A15', 0, 0, NULL, NULL),
(996, 85, 28, 'P28-T85-A16', 0, 0, NULL, NULL),
(997, 85, 28, 'P28-T85-A17', 0, 0, NULL, NULL),
(998, 85, 28, 'P28-T85-A18', 0, 0, NULL, NULL),
(999, 85, 28, 'P28-T85-A19', 0, 0, NULL, NULL),
(1000, 85, 28, 'P28-T85-A20', 0, 0, NULL, NULL),
(1001, 86, 26, 'P26-T86-A1', 0, 0, NULL, NULL),
(1002, 86, 26, 'P26-T86-A2', 0, 0, NULL, NULL),
(1003, 86, 26, 'P26-T86-A3', 0, 0, NULL, NULL),
(1004, 86, 26, 'P26-T86-A4', 0, 0, NULL, NULL),
(1005, 86, 26, 'P26-T86-A5', 0, 0, NULL, NULL),
(1006, 86, 26, 'P26-T86-A6', 0, 0, NULL, NULL),
(1007, 86, 26, 'P26-T86-A7', 0, 0, NULL, NULL),
(1008, 86, 26, 'P26-T86-A8', 0, 0, NULL, NULL),
(1009, 86, 26, 'P26-T86-A9', 0, 0, NULL, NULL),
(1010, 86, 26, 'P26-T86-A10', 0, 0, NULL, NULL),
(1011, 86, 27, 'P27-T86-A1', 0, 0, NULL, NULL),
(1012, 86, 27, 'P27-T86-A2', 0, 0, NULL, NULL),
(1013, 86, 27, 'P27-T86-A3', 0, 0, NULL, NULL),
(1014, 86, 27, 'P27-T86-A4', 0, 0, NULL, NULL),
(1015, 86, 27, 'P27-T86-A5', 0, 0, NULL, NULL),
(1016, 86, 27, 'P27-T86-A6', 0, 0, NULL, NULL),
(1017, 86, 27, 'P27-T86-A7', 0, 0, NULL, NULL),
(1018, 86, 27, 'P27-T86-A8', 0, 0, NULL, NULL),
(1019, 86, 27, 'P27-T86-A9', 0, 0, NULL, NULL),
(1020, 86, 27, 'P27-T86-A10', 0, 0, NULL, NULL),
(1021, 86, 27, 'P27-T86-A11', 0, 0, NULL, NULL),
(1022, 86, 27, 'P27-T86-A12', 0, 0, NULL, NULL),
(1023, 86, 27, 'P27-T86-A13', 0, 0, NULL, NULL),
(1024, 86, 27, 'P27-T86-A14', 0, 0, NULL, NULL),
(1025, 86, 27, 'P27-T86-A15', 0, 0, NULL, NULL),
(1026, 86, 28, 'P28-T86-A1', 0, 0, NULL, NULL),
(1027, 86, 28, 'P28-T86-A2', 0, 0, NULL, NULL),
(1028, 86, 28, 'P28-T86-A3', 0, 0, NULL, NULL),
(1029, 86, 28, 'P28-T86-A4', 0, 0, NULL, NULL),
(1030, 86, 28, 'P28-T86-A5', 0, 0, NULL, NULL),
(1031, 86, 28, 'P28-T86-A6', 0, 0, NULL, NULL),
(1032, 86, 28, 'P28-T86-A7', 0, 0, NULL, NULL),
(1033, 86, 28, 'P28-T86-A8', 0, 0, NULL, NULL),
(1034, 86, 28, 'P28-T86-A9', 0, 0, NULL, NULL),
(1035, 86, 28, 'P28-T86-A10', 0, 0, NULL, NULL),
(1036, 86, 28, 'P28-T86-A11', 0, 0, NULL, NULL),
(1037, 86, 28, 'P28-T86-A12', 0, 0, NULL, NULL),
(1038, 86, 28, 'P28-T86-A13', 0, 0, NULL, NULL),
(1039, 86, 28, 'P28-T86-A14', 0, 0, NULL, NULL),
(1040, 86, 28, 'P28-T86-A15', 0, 0, NULL, NULL),
(1041, 86, 28, 'P28-T86-A16', 0, 0, NULL, NULL),
(1042, 86, 28, 'P28-T86-A17', 0, 0, NULL, NULL),
(1043, 86, 28, 'P28-T86-A18', 0, 0, NULL, NULL),
(1044, 86, 28, 'P28-T86-A19', 0, 0, NULL, NULL),
(1045, 86, 28, 'P28-T86-A20', 0, 0, NULL, NULL),
(1046, 87, 26, 'P26-T87-A1', 0, 0, NULL, NULL),
(1047, 87, 26, 'P26-T87-A2', 0, 0, NULL, NULL),
(1048, 87, 26, 'P26-T87-A3', 0, 0, NULL, NULL),
(1049, 87, 26, 'P26-T87-A4', 0, 0, NULL, NULL),
(1050, 87, 26, 'P26-T87-A5', 0, 0, NULL, NULL),
(1051, 87, 26, 'P26-T87-A6', 0, 0, NULL, NULL),
(1052, 87, 26, 'P26-T87-A7', 0, 0, NULL, NULL),
(1053, 87, 26, 'P26-T87-A8', 0, 0, NULL, NULL),
(1054, 87, 26, 'P26-T87-A9', 0, 0, NULL, NULL),
(1055, 87, 26, 'P26-T87-A10', 0, 0, NULL, NULL),
(1056, 87, 27, 'P27-T87-A1', 0, 0, NULL, NULL),
(1057, 87, 27, 'P27-T87-A2', 0, 0, NULL, NULL),
(1058, 87, 27, 'P27-T87-A3', 0, 0, NULL, NULL),
(1059, 87, 27, 'P27-T87-A4', 0, 0, NULL, NULL),
(1060, 87, 27, 'P27-T87-A5', 0, 0, NULL, NULL),
(1061, 87, 27, 'P27-T87-A6', 0, 0, NULL, NULL),
(1062, 87, 27, 'P27-T87-A7', 0, 0, NULL, NULL),
(1063, 87, 27, 'P27-T87-A8', 0, 0, NULL, NULL),
(1064, 87, 27, 'P27-T87-A9', 0, 0, NULL, NULL),
(1065, 87, 27, 'P27-T87-A10', 0, 0, NULL, NULL),
(1066, 87, 27, 'P27-T87-A11', 0, 0, NULL, NULL),
(1067, 87, 27, 'P27-T87-A12', 0, 0, NULL, NULL),
(1068, 87, 27, 'P27-T87-A13', 0, 0, NULL, NULL),
(1069, 87, 27, 'P27-T87-A14', 0, 0, NULL, NULL),
(1070, 87, 27, 'P27-T87-A15', 0, 0, NULL, NULL),
(1071, 87, 28, 'P28-T87-A1', 0, 0, NULL, NULL),
(1072, 87, 28, 'P28-T87-A2', 0, 0, NULL, NULL),
(1073, 87, 28, 'P28-T87-A3', 0, 0, NULL, NULL),
(1074, 87, 28, 'P28-T87-A4', 0, 0, NULL, NULL),
(1075, 87, 28, 'P28-T87-A5', 0, 0, NULL, NULL),
(1076, 87, 28, 'P28-T87-A6', 0, 0, NULL, NULL),
(1077, 87, 28, 'P28-T87-A7', 0, 0, NULL, NULL),
(1078, 87, 28, 'P28-T87-A8', 0, 0, NULL, NULL),
(1079, 87, 28, 'P28-T87-A9', 0, 0, NULL, NULL),
(1080, 87, 28, 'P28-T87-A10', 0, 0, NULL, NULL),
(1081, 87, 28, 'P28-T87-A11', 0, 0, NULL, NULL),
(1082, 87, 28, 'P28-T87-A12', 0, 0, NULL, NULL),
(1083, 87, 28, 'P28-T87-A13', 0, 0, NULL, NULL),
(1084, 87, 28, 'P28-T87-A14', 0, 0, NULL, NULL),
(1085, 87, 28, 'P28-T87-A15', 0, 0, NULL, NULL),
(1086, 87, 28, 'P28-T87-A16', 0, 0, NULL, NULL),
(1087, 87, 28, 'P28-T87-A17', 0, 0, NULL, NULL),
(1088, 87, 28, 'P28-T87-A18', 0, 0, NULL, NULL),
(1089, 87, 28, 'P28-T87-A19', 0, 0, NULL, NULL),
(1090, 87, 28, 'P28-T87-A20', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `picture`) VALUES
(28, 'Smit Chakrani', 'uploads/1744606220_Screenshot 2025-04-14 101429.png'),
(29, 'Nenish Jajadiya', 'uploads/1744606239_Screenshot 2025-04-14 101429.png'),
(30, 'Krunal Kaklotar', 'uploads/1744606253_Screenshot 2025-04-14 101429.png');

-- --------------------------------------------------------

--
-- Table structure for table `trip`
--

CREATE TABLE `trip` (
  `trip_id` int(11) NOT NULL,
  `trip_day` varchar(50) NOT NULL,
  `dep_place` varchar(255) NOT NULL,
  `arr_place` varchar(255) NOT NULL,
  `dep_date` date NOT NULL,
  `dep_time` varchar(50) NOT NULL,
  `arr_time` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trip`
--

INSERT INTO `trip` (`trip_id`, `trip_day`, `dep_place`, `arr_place`, `dep_date`, `dep_time`, `arr_time`, `status`) VALUES
(78, 'Thursday', 'Hajira', 'Porbandar', '2025-05-01', '08:00', '15:00', 1),
(79, 'Tuesday', 'Porbandar', 'Hajira', '2025-05-06', '21:00', '04:00', 1),
(80, 'Friday', 'Hajira', 'Bhavnagar', '2025-05-02', '16:00', '23:00', 1),
(84, 'Wednesday', 'Hajira', 'Bhavnagar', '2025-05-07', '02:00', '10:00', 1),
(85, 'Sunday', 'Hajira', 'Veraval', '2025-05-11', '04:00', '13:00', 1),
(86, 'Monday', 'Veraval', 'Hajira', '2025-05-12', '15:00', '22:00', 1),
(87, 'Saturday', 'Bhavnagar', 'Hajira', '2025-05-03', '11:00', '19:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phonenum` varchar(20) NOT NULL,
  `pincode` int(11) NOT NULL,
  `dob` date NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `token_expire` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `is_verified`, `token`, `token_expire`, `status`, `created_at`, `reset_token`, `token_expiry`) VALUES
(38, 'Krunal Kaklotar', 'krunalkaklotar2283@gmail.com', '45\r\nVina nagar society katargam', '7069385883', 395004, '2004-12-26', 'IMG_67ef73132b9753.70855498.jpg', '$2y$10$9C2qPzGzra9H35d4ibfkz.wwWUId7IcSEl/X0CrvSwWF9vhmHxppS', 1, NULL, NULL, 1, '2025-04-04 05:50:11', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_contact`
--
ALTER TABLE `admin_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feid`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `package_facilities`
--
ALTER TABLE `package_facilities`
  ADD PRIMARY KEY (`pfid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `fid` (`fid`);

--
-- Indexes for table `package_features`
--
ALTER TABLE `package_features`
  ADD PRIMARY KEY (`pfeid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `feid` (`feid`);

--
-- Indexes for table `package_image`
--
ALTER TABLE `package_image`
  ADD PRIMARY KEY (`piid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `trip_id` (`trip_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`trip_id`);

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
-- AUTO_INCREMENT for table `admin_contact`
--
ALTER TABLE `admin_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `package_facilities`
--
ALTER TABLE `package_facilities`
  MODIFY `pfid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `package_features`
--
ALTER TABLE `package_features`
  MODIFY `pfeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `package_image`
--
ALTER TABLE `package_image`
  MODIFY `piid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1226;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `trip`
--
ALTER TABLE `trip`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `package_facilities`
--
ALTER TABLE `package_facilities`
  ADD CONSTRAINT `package_facilities_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `package` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_facilities_ibfk_2` FOREIGN KEY (`fid`) REFERENCES `facilities` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `package_features`
--
ALTER TABLE `package_features`
  ADD CONSTRAINT `package_features_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `package` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_features_ibfk_2` FOREIGN KEY (`feid`) REFERENCES `features` (`feid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `package_image`
--
ALTER TABLE `package_image`
  ADD CONSTRAINT `package_image_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `package` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`trip_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seats_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `package` (`pid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
