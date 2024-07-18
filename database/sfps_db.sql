<<<<<<< HEAD
CREATE TABLE `courses` (
  `id` int(30) NOT NULL,
  `course` varchar(100) NULL,
  `department` text NULL,
  `description` text NULL,
  `level` varchar(150) NULL,
  `laboratory` int(11) NULL,
  `computer` int(11) NULL,
  `academic` int(11) NULL,
  `academic_nstp` int(11) NULL,
  `total_amount` float NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
);
=======
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2024 at 05:46 AM
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
-- Database: `sfps_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(30) NOT NULL,
  `course` varchar(100) NOT NULL,
  `department` text NOT NULL,
  `description` text NOT NULL,
  `level` varchar(150) NOT NULL,
  `laboratory` int(11) NOT NULL,
  `computer` int(11) NOT NULL,
  `academic` int(11) NOT NULL,
  `academic_nstp` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--
>>>>>>> origin/main

INSERT INTO `courses` (`id`, `course`, `department`, `description`, `level`, `laboratory`, `computer`, `academic`, `academic_nstp`, `total_amount`, `date_created`) VALUES
(2, 'Bachelor of Science in Information Technology(BSIT)', 'BSIT', 'dsfdsfsd', '3rd ', 0, 0, 0, 0, 3125.02, '2024-06-28 13:05:29');

<<<<<<< HEAD
CREATE TABLE `fees` (
  `id` int(30) NOT NULL,
  `course_id` int(30) NULL,
  `description` varchar(200) NULL,
  `amount` float NULL
);
=======
-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees`
--
>>>>>>> origin/main

INSERT INTO `fees` (`id`, `course_id`, `description`, `amount`) VALUES
(4, 2, 'Tuition Fee based on enrolled academic units(credit and none-credit courses) ', 1375.02),
(17, 2, 'NSTP based on enrolled academic units (credit and non-credit courses)', 0),
(18, 2, 'Athletic Fees', 150),
(19, 2, 'Computer Fees', 100),
(20, 2, 'Cultural Fees', 200),
(21, 2, 'Development Fees', 250),
(22, 2, 'Entrance/Admission Fees*', 200),
(23, 2, 'Guidance Fees', 100),
(24, 2, 'Handbook Fees', 0),
(25, 2, 'Laboratory Fees', 0),
(26, 2, 'Library Fee', 150),
(27, 2, 'Medical and Dental Fees', 300),
(28, 2, 'Registration Fees', 300),
(29, 2, 'School ID Fees', 0);

<<<<<<< HEAD

CREATE TABLE `payments` (
  `id` int(30) NOT NULL,
  `ef_id` int(30) NULL,
  `amount` float NULL,
  `remarks` text NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);

CREATE TABLE `student` (
  `id` int(30) NOT NULL,
  `sequence_no` varchar(255) NULL,
  `id_no` varchar(100) NULL,
  `name` text NULL,
  `fname` text NULL,
  `lname` text NULL,
  `mname` text DEFAULT NULL,
  `gender` text NULL,
  `contact` varchar(100) NULL,
  `address` text NULL,
  `email` varchar(200) NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
);
=======
-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(30) NOT NULL,
  `ef_id` int(30) NOT NULL,
  `amount` float NOT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(30) NOT NULL,
  `sequence_no` varchar(255) NOT NULL,
  `id_no` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `mname` text DEFAULT NULL,
  `gender` text NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
>>>>>>> origin/main

-- --------------------------------------------------------

--
-- Table structure for table `student_ef_list`
--

CREATE TABLE `student_ef_list` (
  `id` int(30) NOT NULL,
<<<<<<< HEAD
  `student_id` int(30) NULL,
  `ef_no` varchar(200) NULL,
  `course_id` int(30) NULL,
  `total_fee` float NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
);
=======
  `student_id` int(30) NOT NULL,
  `ef_no` varchar(200) NOT NULL,
  `course_id` int(30) NOT NULL,
  `total_fee` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
>>>>>>> origin/main

-- --------------------------------------------------------

--
-- Table structure for table `student_enroll`
--

CREATE TABLE `student_enroll` (
  `application_no` int(11) NOT NULL,
<<<<<<< HEAD
  `last_name` text NULL,
  `first_name` text NULL,
  `middle_name` text NULL,
  `home_address` text NULL,
  `present_address` text NULL,
  `contact` varchar(11) NULL,
  `sex` text NULL,
  `date_of_birth` text NULL,
  `email` text NULL,
  `place_of_birth` text NULL,
  `civil_status` text NULL,
  `elementary` text NULL,
  `elementary_year_graduated` text NULL,
  `high_school` text NULL,
  `high_school_year_graduated` text NULL,
  `shs` text NULL,
  `shs_year_graduated` text NULL,
  `track_and_strand` text NULL,
  `complete_name` text NULL,
  `date_signed` text NULL,
  `course_to_be_enrolled` text NULL
);
=======
  `last_name` text NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `home_address` text NOT NULL,
  `present_address` text NOT NULL,
  `contact` varchar(11) NOT NULL,
  `sex` text NOT NULL,
  `date_of_birth` text NOT NULL,
  `email` text NOT NULL,
  `place_of_birth` text NOT NULL,
  `civil_status` text NOT NULL,
  `elementary` text NOT NULL,
  `elementary_year_graduated` text NOT NULL,
  `high_school` text NOT NULL,
  `high_school_year_graduated` text NOT NULL,
  `shs` text NOT NULL,
  `shs_year_graduated` text NOT NULL,
  `track_and_strand` text NOT NULL,
  `complete_name` text NOT NULL,
  `date_signed` text NOT NULL,
  `course_to_be_enrolled` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
>>>>>>> origin/main

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
<<<<<<< HEAD
  `name` text NULL,
  `email` varchar(200) NULL,
  `contact` varchar(20) NULL,
  `cover_img` text NULL,
  `about_content` text NULL
);
=======
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
>>>>>>> origin/main

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Free Higher Education Billing System', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
<<<<<<< HEAD
  `name` text NULL,
  `username` varchar(200) NULL,
  `password` text NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff'
);

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'admin', 'admin', '0192023a7bbd73250516f069df18b500', 1);
=======
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'admin', 'admin', '0192023a7bbd73250516f069df18b500', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_ef_list`
--
ALTER TABLE `student_ef_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_enroll`
--
ALTER TABLE `student_enroll`
  ADD PRIMARY KEY (`application_no`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_ef_list`
--
ALTER TABLE `student_ef_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_enroll`
--
ALTER TABLE `student_enroll`
  MODIFY `application_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
>>>>>>> origin/main
