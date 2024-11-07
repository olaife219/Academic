-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 10:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `course_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `user_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`user_id`, `playlist_id`) VALUES
('XTfrFtwfllOVyYqRpFv8', '3UDFkdCWlUbx2Ir98ZEZ'),
('HplJ8jf6QgAADg6LkBD9', '3UDFkdCWlUbx2Ir98ZEZ'),
('HplJ8jf6QgAADg6LkBD9', 'WJkIfF6x0GEuhoXNSxiO');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content_id`, `user_id`, `tutor_id`, `comment`, `date`) VALUES
('HmA1vYMXSBJ2XPI1M5hj', 'eumAl2gd4ZyU5Sb41UXT', 'HplJ8jf6QgAADg6LkBD9', 'kynNNjROWLBZjioWmRJx', 'i love coding so much!', '2024-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` int(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`name`, `email`, `number`, `message`) VALUES
('Durodola Abdulhameed', 'olamidedurodola@gmail.com', 2147483647, 'i love coding, this is a test message');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `video` varchar(100) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `tutor_id`, `playlist_id`, `title`, `description`, `video`, `thumb`, `date`, `status`) VALUES
('IIeYt6aTGqAlgPCA7lCg', 'kynNNjROWLBZjioWmRJx', '3UDFkdCWlUbx2Ir98ZEZ', 'HTML Tutorial part 01', 'Function and uses of html, how to use html structure our website', 'uJZkCtu9UtB8Xa8W8j2G.mp4', 'tMBbjTxTnF18gFFfaju2.png', '2024-06-23', 'active'),
('eumAl2gd4ZyU5Sb41UXT', 'kynNNjROWLBZjioWmRJx', '3UDFkdCWlUbx2Ir98ZEZ', 'HTML Tutuorial part02', 'i love coding, test description', 'VrXrR8xUdZpxZoAyrjrQ.mp4', 'Bv2bkLuGOrVloQXsfQMh.png', '2024-07-01', 'active'),
('AmD76b0axFvaECVhRRgV', 'kynNNjROWLBZjioWmRJx', '3UDFkdCWlUbx2Ir98ZEZ', 'HTML Tutorial part 03', 'test description, i love coding!', 'gGC08Hjxz3fuzMpyNVJn.mp4', 'QKOEgL7LEqkGs6GgBqHW.png', '2024-07-01', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`user_id`, `tutor_id`, `content_id`) VALUES
('HplJ8jf6QgAADg6LkBD9', 'kynNNjROWLBZjioWmRJx', 'IIeYt6aTGqAlgPCA7lCg'),
('HplJ8jf6QgAADg6LkBD9', 'kynNNjROWLBZjioWmRJx', 'eumAl2gd4ZyU5Sb41UXT');

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`id`, `tutor_id`, `title`, `description`, `thumb`, `date`, `status`) VALUES
('3UDFkdCWlUbx2Ir98ZEZ', 'kynNNjROWLBZjioWmRJx', 'Complete HTML Tutorial', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo deleniti explicabo autem. Facilis reprehenderit labore cumque iusto omnis enim quis?', 'laIu91BPxgHCHE5lysyG.png', '2024-06-21', 'active'),
('8uFVGHHxTQYJVMQXXhyV', 'kynNNjROWLBZjioWmRJx', 'Complete CSS Tutorial', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo deleniti explicabo autem. Facilis reprehenderit labore cumque iusto omnis enim quis?', 'kaR700qKCCtLoyQl64fT.jpeg', '2024-06-21', 'active'),
('WJkIfF6x0GEuhoXNSxiO', 'a6VvV2JaWbr9vccpUTX3', 'Complete JavaScript Tutorial', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. In ipsa dicta consequuntur eaque labore! Praesentium et aliquam obcaecati accusamus animi.', 'OWHMe4Y2hOq0hc3lJT8b.png', '2024-06-28', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `profession` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`id`, `name`, `profession`, `email`, `password`, `image`) VALUES
('kynNNjROWLBZjioWmRJx', 'Durodola Abdulhameed', 'developer', 'durodolaabdulhameed2021@gmail.com', 'e37ffe856396228617bdcd8b5cb26cb9e978f5bb', 'y8HCPJ1zBfsXUMOLwyyT.png'),
('a6VvV2JaWbr9vccpUTX3', 'Durodola Olamide', 'engineer', 'horlarmedeydurodola@gmail.com', 'e37ffe856396228617bdcd8b5cb26cb9e978f5bb', 'V04vJD1zcIu3NetUv06j.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`) VALUES
('HplJ8jf6QgAADg6LkBD9', 'User A', 'user_01@gmail.com', 'e37ffe856396228617bdcd8b5cb26cb9e978f5bb', 'WI9kGcDPbtUUnM8hNSsE.jpg'),
('XTfrFtwfllOVyYqRpFv8', 'User B', 'user_02@gmail.com', 'e37ffe856396228617bdcd8b5cb26cb9e978f5bb', 'F5lIlEtjtkTibgeqkgba.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
