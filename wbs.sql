-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2017 at 03:40 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wbs`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `due_date` date DEFAULT NULL,
  `img` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`p_id`, `p_name`, `type`, `description`, `created_at`, `due_date`, `img`) VALUES
(50, 'A', 'B', '', '2017-12-06 03:35:45', '0000-00-00', ''),
(59, 'COMP 341 Project', 'Academic', 'The goal of this project is to create a Mozilla Firefox plugin that will allow a user to highlight an unfamiliar word in order to find the definition via JavaScript modal popup. The program will be written mostly in JavaScript, but will likely employ CSS for formatting purposes. Optimally, the plugin will be versatile enough to allow a user to use the plugin with a dictionary website/database of their choice. Once completed, the plugin will be available for download at addons.mozilla.org.A major challenge with this project is the issue of \"stemming\" words. If a dictionary only recognizes the singular form of a word, for example, it would be difficult to define a word such as \"oxen,\" or \"geese.\" By the final version of this program, this plugin will be able to define words in both English and Spanish.', '2017-12-06 05:53:19', '2018-01-29', 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/99/Unofficial_JavaScript_logo_2.svg/1200px-Unofficial_JavaScript_logo_2.svg.png'),
(60, 'Habitat 67', 'Architecture', 'The modular unit is the base, the means and the finality of Habitat 67. 354 magnificent grey-beige modules are stacked one on another to form 148 residences, nestled between sky and earth, city and river, greenery and light. It all comes together in a gigantic sculpture of futuristic interiors, links, pedestrian streets and suspended terraces, aerial spaces, skylights of different angles, large esplanades and monumental elevator pillars. Habitat 67 is an invitation to contemplation.', '2017-12-06 05:55:05', '2019-03-15', 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Montreal_-_QC_-_Habitat67.jpg/1200px-Montreal_-_QC_-_Habitat67.jpg'),
(62, 'El Cap', '', '', '2017-12-06 05:58:11', '0000-00-00', 'https://www.yosemite.com/wp-content/uploads/2016/04/El-Capitan.jpg'),
(63, 'Brown Hills', '', '', '2017-12-06 05:58:39', '0000-00-00', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Andes1a.JPG/220px-Andes1a.JPG'),
(64, 'Hiking Macchu Picchu', '', '', '2017-12-06 05:59:13', '0000-00-00', 'https://media-cdn.tripadvisor.com/media/photo-s/02/e1/93/0b/andes.jpg'),
(65, 'Something in Trottier', '', '', '2017-12-06 05:59:47', '0000-00-00', 'http://www.imtl.org/image/big/mcGill_Lorne-M.-Trottier.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `project_user`
--

CREATE TABLE `project_user` (
  `p_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `ver_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_user`
--

INSERT INTO `project_user` (`p_id`, `u_id`, `ver_num`) VALUES
(5, 1, 0),
(6, 1, 0),
(59, 1, 0),
(60, 1, 0),
(0, 1, 0),
(0, 1, 0),
(62, 1, 0),
(63, 1, 0),
(64, 1, 0),
(65, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `p_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `t_name` varchar(50) NOT NULL,
  `description` text,
  `due_date` date DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`p_id`, `t_id`, `parent_id`, `depth`, `width`, `t_name`, `description`, `due_date`, `progress`) VALUES
(59, 32, 0, 0, 0, 'COMP 341 Project', 'Firefox plugin', '2017-12-27', 75),
(60, 33, 0, 0, 0, 'Habitat 67', NULL, NULL, 0),
(0, 34, 0, 0, 0, 'Climbing El Capitan', NULL, NULL, 0),
(0, 35, 0, 0, 0, 'Climbing El Capitan', NULL, NULL, 0),
(62, 37, 0, 0, 0, 'El Cap', NULL, NULL, 0),
(63, 38, 0, 0, 0, 'Brown Hills', NULL, NULL, 0),
(64, 39, 0, 0, 0, 'Hiking Macchu Picchu', NULL, NULL, 0),
(65, 40, 0, 0, 0, 'Something in Trottier', NULL, NULL, 0),
(0, 44, 0, 0, 1, 'Design the building', NULL, NULL, 0),
(60, 45, 33, 1, 0, 'Design the building', NULL, NULL, 0),
(60, 46, 45, 2, 0, 'Measure windows', NULL, NULL, 0),
(60, 47, 45, 2, 1, 'Decide the color of the building', NULL, NULL, 0),
(60, 49, 46, 3, 0, 'Buy glass', NULL, NULL, 0),
(60, 50, 49, 4, 0, 'Shine glass', NULL, NULL, 0),
(59, 52, 32, 1, 0, 'Front-End', NULL, NULL, 0),
(59, 53, 32, 1, 1, 'Back-End', NULL, NULL, 0),
(59, 54, 32, 1, 2, 'Database', 'mySQL database to store our users, projects, tasks', '2017-12-01', 90),
(59, 55, 52, 2, 0, 'welcome.php', NULL, NULL, 0),
(59, 56, 52, 2, 1, 'editor.php', 'draws tree from nodes in db that correspond to current project', '2017-12-13', 20),
(59, 57, 55, 3, 0, 'XML', NULL, NULL, 0),
(59, 58, 55, 3, 1, 'Bootstrap', NULL, NULL, 0),
(59, 59, 57, 4, 0, 'JS', NULL, NULL, 0),
(59, 60, 58, 4, 0, 'HTML', NULL, NULL, 0),
(59, 62, 56, 3, 1, 'CSS', NULL, NULL, 0),
(59, 63, 56, 3, 0, 'canvasJS', NULL, NULL, 0),
(59, 64, 63, 4, 0, 'drawTask', NULL, NULL, 0),
(59, 65, 53, 2, 0, 'welcome.php', NULL, NULL, 0),
(59, 67, 65, 3, 0, 'PHP', 'Goes into database to retrieve all projects associated with current user.', '2017-12-14', 55),
(59, 77, 53, 2, 1, 'editor.php', 'Retrieves all tasks associated with current project.', '2017-12-22', 80),
(59, 78, 77, 3, 0, 'JSON', NULL, NULL, 0),
(59, 79, 77, 3, 1, 'PHP', 'Find all projects associated with user logged in.', '2017-12-07', 44),
(59, 80, 79, 4, 0, 'SQL', NULL, NULL, 0),
(59, 81, 54, 2, 0, 'Tables', NULL, NULL, 0),
(59, 82, 81, 3, 0, 'users', 'Database of users and passwords. Unique PIDs.', NULL, 0),
(59, 83, 81, 3, 1, 'projects', NULL, NULL, 0),
(59, 84, 82, 4, 0, 'user-project', NULL, NULL, 0),
(59, 85, 83, 4, 0, 'tasks', NULL, NULL, 0),
(0, 87, 0, 0, 2, 'C273A4 Q3', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `color` varchar(50) DEFAULT NULL,
  `IP` varchar(50) DEFAULT NULL,
  `login` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `password`, `created_at`, `color`, `IP`, `login`) VALUES
(1, 'user1', '$2y$10$zi1cp1vPZmBYzi1Wn56yguKUB4TBVdnpHavY6VrY/X4frJf4RjhHS', '2017-11-22 20:23:16', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
