-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2024 at 06:08 PM
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
-- Table structure for table `academic`
--

CREATE TABLE `academic` (
  `id` int(11) NOT NULL,
  `year` text DEFAULT NULL,
  `semester` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(30) NOT NULL,
  `course` varchar(100) NOT NULL,
  `department` text NOT NULL,
  `description` text DEFAULT NULL,
  `level` varchar(150) NOT NULL,
  `semester` text DEFAULT NULL,
  `laboratory` int(11) NOT NULL,
  `computer` int(11) NOT NULL,
  `academic` int(11) NOT NULL,
  `academic_nstp` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enroll2024`
--

CREATE TABLE `enroll2024` (
  `id` int(11) NOT NULL,
  `application_no` text NOT NULL,
  `stu_id` varchar(50) DEFAULT NULL,
  `learners_number` text DEFAULT NULL,
  `fname` text DEFAULT NULL,
  `mname` text DEFAULT NULL,
  `lname` text DEFAULT NULL,
  `stu_name` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `stu_sta` varchar(50) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `academic` text DEFAULT NULL,
  `major` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `semester` varchar(20) NOT NULL DEFAULT '1st',
  `curr` varchar(255) DEFAULT NULL,
  `reli` varchar(255) DEFAULT NULL,
  `con_no` varchar(255) DEFAULT NULL,
  `home_ad` varchar(255) DEFAULT NULL,
  `civil` varchar(50) DEFAULT NULL,
  `d_birth` varchar(255) DEFAULT NULL,
  `p_birth` varchar(100) DEFAULT NULL,
  `ele` varchar(255) DEFAULT NULL,
  `ele_year` varchar(255) DEFAULT NULL,
  `high` varchar(255) DEFAULT NULL,
  `high_year` varchar(255) DEFAULT NULL,
  `last_sc` varchar(255) DEFAULT NULL,
  `last_year` varchar(255) DEFAULT NULL,
  `tot_units` varchar(50) DEFAULT NULL,
  `un_enrol` varchar(50) DEFAULT NULL,
  `rate_per` varchar(100) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `lib` varchar(255) DEFAULT NULL,
  `com` varchar(255) DEFAULT NULL,
  `lab1` varchar(255) DEFAULT NULL,
  `lab2` varchar(255) DEFAULT NULL,
  `lab3` varchar(255) DEFAULT NULL,
  `sch_id` varchar(50) DEFAULT NULL,
  `ath` varchar(50) DEFAULT NULL,
  `adm` varchar(100) DEFAULT NULL,
  `dev` varchar(255) DEFAULT NULL,
  `guid` varchar(255) DEFAULT NULL,
  `hand` varchar(255) DEFAULT NULL,
  `entr` varchar(255) DEFAULT NULL,
  `reg_fe` varchar(255) DEFAULT NULL,
  `med_den` varchar(255) DEFAULT NULL,
  `cul` varchar(50) DEFAULT NULL,
  `t_misfe` varchar(50) DEFAULT NULL,
  `g_tot` varchar(100) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `date_signed` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `year_level` text DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `delete_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=active,2=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `application_no` int(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `present_address` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `place_of_birth` varchar(100) DEFAULT NULL,
  `civil_status` varchar(20) DEFAULT NULL,
  `elementary` varchar(100) DEFAULT NULL,
  `elementary_year_graduated` year(4) DEFAULT NULL,
  `high_school` varchar(100) DEFAULT NULL,
  `high_school_year_graduated` year(4) DEFAULT NULL,
  `shs` varchar(100) DEFAULT NULL,
  `shs_year_graduated` year(4) DEFAULT NULL,
  `track_and_strand` varchar(100) DEFAULT NULL,
  `complete_name` varchar(100) DEFAULT NULL,
  `date_signed` date DEFAULT NULL,
  `course_to_be_enrolled` varchar(100) DEFAULT NULL,
  `status` enum('Unread','Read') DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_ef_list`
--

CREATE TABLE `student_ef_list` (
  `id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `ef_no` varchar(200) NOT NULL,
  `course_id` int(30) NOT NULL,
  `total_fee` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_enroll`
--

CREATE TABLE `student_enroll` (
  `application_no` int(11) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `sem` varchar(50) NOT NULL,
  `year` varchar(255) NOT NULL,
  `course` varchar(50) NOT NULL,
  `tbl_time` varchar(50) DEFAULT NULL,
  `tbl_day` varchar(255) DEFAULT NULL,
  `subjectcode` varchar(255) DEFAULT NULL,
  `subdes` varchar(255) DEFAULT NULL,
  `prerequi` varchar(255) NOT NULL,
  `units` varchar(10) DEFAULT NULL,
  `room` varchar(100) NOT NULL,
  `inst` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'MCC Free Higher Education Billing System', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff',
  `verification` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `type`, `verification`) VALUES
(1, ' admin', 'admin', 'sisdoyromaryannlawan20@gmail.com', '$2y$10$awTNsqce99hhkGBto/0iguI4OukSRUJwBCbIWGgNAS.UiYi3BPuZa', 1, '66a52bd54b7df');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic`
--
ALTER TABLE `academic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enroll2024`
--
ALTER TABLE `enroll2024`
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
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`application_no`),
  ADD KEY `index_application_no` (`application_no`,`first_name`,`last_name`,`middle_name`);

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
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `academic`
--
ALTER TABLE `academic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enroll2024`
--
ALTER TABLE `enroll2024`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `application_no` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
