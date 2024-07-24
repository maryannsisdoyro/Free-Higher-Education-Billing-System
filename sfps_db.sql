-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2024 at 04:17 AM
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

INSERT INTO `courses` (`id`, `course`, `department`, `description`, `level`, `laboratory`, `computer`, `academic`, `academic_nstp`, `total_amount`, `date_created`) VALUES
(2, 'Bachelor of Science in Information Technology(BSIT)', 'BSIT', 'dsfdsfsd', '3rd ', 0, 0, 0, 0, 3125.02, '2024-06-28 13:05:29');

-- --------------------------------------------------------

--
-- Table structure for table `enroll2024`
--

CREATE TABLE `enroll2024` (
  `id` int(11) NOT NULL,
  `application_no` int(20) NOT NULL,
  `stu_id` varchar(50) NOT NULL,
  `stu_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `stu_sta` varchar(50) NOT NULL,
  `course` varchar(50) DEFAULT NULL,
  `academic` text DEFAULT NULL,
  `major` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT '1st',
  `semester` varchar(20) NOT NULL DEFAULT '1st',
  `curr` varchar(255) DEFAULT NULL,
  `reli` varchar(255) DEFAULT NULL,
  `con_no` varchar(255) DEFAULT NULL,
  `home_ad` varchar(255) NOT NULL,
  `civil` varchar(50) DEFAULT NULL,
  `d_birth` varchar(255) DEFAULT NULL,
  `p_birth` varchar(100) DEFAULT NULL,
  `ele` varchar(255) DEFAULT NULL,
  `ele_year` varchar(255) DEFAULT NULL,
  `high` varchar(255) DEFAULT NULL,
  `high_year` varchar(255) DEFAULT NULL,
  `last_sc` varchar(255) DEFAULT NULL,
  `last_year` varchar(255) NOT NULL,
  `tot_units` varchar(50) DEFAULT NULL,
  `un_enrol` varchar(50) DEFAULT NULL,
  `rate_per` varchar(100) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `lib` varchar(255) DEFAULT NULL,
  `com` varchar(255) DEFAULT NULL,
  `lab1` varchar(255) DEFAULT NULL,
  `lab2` varchar(255) DEFAULT NULL,
  `lab3` varchar(255) NOT NULL,
  `sch_id` varchar(50) DEFAULT NULL,
  `ath` varchar(50) DEFAULT NULL,
  `adm` varchar(100) DEFAULT NULL,
  `dev` varchar(255) DEFAULT NULL,
  `guid` varchar(255) DEFAULT NULL,
  `hand` varchar(255) DEFAULT NULL,
  `entr` varchar(255) DEFAULT NULL,
  `reg_fe` varchar(255) DEFAULT NULL,
  `med_den` varchar(255) NOT NULL,
  `cul` varchar(50) DEFAULT NULL,
  `t_misfe` varchar(50) DEFAULT NULL,
  `g_tot` varchar(100) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `date_signed` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `year_level` text NOT NULL DEFAULT '\'1st\''
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

--
-- Dumping data for table `fees`
--

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

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `sem`, `year`, `course`, `tbl_time`, `tbl_day`, `subjectcode`, `subdes`, `prerequi`, `units`, `room`, `inst`) VALUES
(103, '1st', '1st', 'BSIT', '1:00-2:00', 'MWF', 'LIT 110', 'THE CONTEMPORARY WORLD', 'NONE', '3', 'TBA', 'TBA'),
(104, '1st', '1st', 'BSIT', '2:00-3:00', 'MWF', 'SOCSCI 110', 'UNDERSTANDING THE SELF', 'NONE', '3', 'TBA', 'TBA'),
(105, '1st', '1st', 'BSIT', '2:00-3:00', 'MWF', 'HIST 110', 'READINGS IN THE PHILLIPINE HISTORY', 'NONE', '3', 'TBA', 'TBA'),
(106, '1st', '1st', 'BSIT', '5:15-6:15', 'MWF', 'FIL 110', 'KOMUNIKASYON SA AKADEMIKONG FILIPINO', 'NONE', '3', 'TBA', 'TBA'),
(107, '1st', '1st', 'BSIT', '6:15-7:15', 'MWF', 'MATH 110', 'MATHEMATICS IN THE MODERN WORLD', 'NONE', '3', 'TBA', 'TBA'),
(108, '1st', '1st', 'BSIT', '8:00-9:00', 'TTH', 'PE 1', 'MOVEMENT ENHANCEMENT', 'NONE', '2', 'TBA', 'TBA'),
(109, '1st', '1st', 'BSIT', '9:30-10:30', 'TTH', 'ITE 112', 'COMPUTER PROGRAMMING 1 LAB', 'NONE', '1', 'TBA', 'TBA'),
(110, '1st', '1st', 'BSIT', '1:00-2:00', 'TTH', 'ITE 111', 'INTRODUCTION TO COMPUTING LAB', 'NONE', '1', 'TBA', 'TBA'),
(111, '1st', '1st', 'BSIT', '3:00-4:00', 'TTH', 'NSTP 1', 'NATIONAL SERVICE TRAINING PROGRAM 1', 'NONE', '3', 'TBA', 'TBA'),
(112, '1st', '1st', 'BSIT', '10:30-12:00', 'FRI', 'GENERAL BIOLOGY', 'GENERAL BIOLOGY', 'STEM', '3', 'TBA', 'TBA'),
(113, '1st', '1st', 'BSIT', '4:00-5:30', 'FRI', 'PRE-CALCULUS', 'PRE-CALCULUS', 'STEM', '3', 'TBA', 'TBA'),
(114, '1st', '1st', 'BSIT', '8:30-9:30', 'MWF', 'ITE 112', 'COMPUTER PROGRAMMING 1 LEC', 'NONE', '2', 'TBA', 'TBA'),
(115, '1st', '1st', 'BSIT', '9:30-10:30', 'MWF', 'ITE 111', 'INTRODUCTION TO COMPUTING LEC', 'NONE', '2', 'TBA', 'TBA'),
(116, '1st', '1st', 'BSBA', '8:30-9:30', 'MWF', 'SOCSCI 112', 'THE CONTEMPORARY WORLD', 'NONE', '3', 'TBA', 'TBA'),
(117, '1st', '1st', 'BSBA', '9:30-11:30', 'MWF', 'ECON 111', 'BASIC MICRO ECONOMICS', 'NONE', '3', 'TBA', 'TBA'),
(118, '1st', '1st', 'BSBA', '1:00-2:00', 'MW', 'PE 1', 'MOVEMENT ENHANCEMENT', 'NONE', '2', 'TBA', 'TBA'),
(119, '1st', '1st', 'BSBA', '3:00-4:00', 'MW', 'HIST 110', 'READINGS IN THE PHILLIPINE HISTORY', 'NONE', '3', 'TBA', 'TBA'),
(120, '1st', '1st', 'BSBA', '10:30-12:30', 'TTH', 'NSTP 1', 'NATIONAL SERVICE TRAINING PROGRAM 1', 'NONE', '3', 'TBA', 'TBA'),
(121, '1st', '1st', 'BSBA', '2:30-4:00', 'TTH', 'FIL 111', 'KOMUNIKASYON SA AKADEMIKONG FILIPINO', 'NONE', '3', 'TBA', 'TBA'),
(122, '1st', '1st', 'BSBA', '8:00-11:00', 'SAT', 'SOCSCI 111', 'UNDERSTANDING THE SELF', 'NONE', '3', 'TBA', 'TBA'),
(123, '1st', '1st', 'BSBA', '11:00-2:00', 'SAT', 'MATH 111', 'MATHEMATICS IN THE MODERN WORLD', 'NONE', '3', 'TBA', 'TBA'),
(124, '1st', '1st', 'BSBA', '8:30-9:30', 'MWF', 'ACCOUNTING 1', 'ACCOUNTING 1', 'ABM', '3', 'TBA', 'TBA'),
(125, '1st', '1st', 'BSBA', '8:00-11:00', 'SAT', 'APPLIED ECONOMICS 2', 'APPLIED ECONOMICS 2', 'ABM', '3', 'TBA', 'TBA'),
(126, '1st', '1st', 'BS-HM', '1:00-4:00', 'WED', 'HM 111.1', 'KITCHEN ESSENTIALS AND FOOD BASIC OPERATION LAB', 'NONE', '1', 'TBA', 'TBA'),
(127, '1st', '1st', 'BS-HM', '5:15-6:15', 'WED', 'HIST 110', 'READINGS IN THE PHILLIPINE HISTORY', 'NONE', '3', 'TBA', 'TBA'),
(128, '1st', '1st', 'BS-HM', '6:15-7:15', 'MWF', 'NSTP 1', 'NATIONAL SERVICE TRAINING PROGRAM 1', 'NONE', '3', 'TBA', 'TBA'),
(129, '1st', '1st', 'BS-HM', '7:30-9:00', 'TTH', 'THM 112', 'RISK MANAGEMENT AS APPLIED AND SECURITY', 'NONE', '3', 'TBA', 'TBA'),
(130, '1st', '1st', 'BS-HM', '9:30-10:30', 'TTH', 'PE 1', 'MOVEMENT ENHANCEMENT', 'NONE', '2', 'TBA', 'TBA'),
(131, '1st', '1st', 'BS-HM', '9:30-12:30', 'TTH', 'HM 111', 'KITCHEN ESSENTIALS AND FOOD BASIC OPERATION LEC', 'NONE', '2', 'TBA', 'TBA'),
(132, '1st', '1st', 'BS-HM', '1:00-2:30', 'TTH', 'ENGL 111', 'PURPOSIVE COMMUNICATION', 'NONE', '3', 'TBA', 'TBA'),
(133, '1st', '1st', 'BS-HM', '4:00-5:30', 'TTH', 'THM 111', 'MACRO PERSPECTIVE OF TOURISM AND HOSPITALITY', 'NONE', '3', 'TBA', 'TBA'),
(134, '1st', '1st', 'BS-HM', '5:30-7:00', 'TTH', 'MATH 110', 'MATHEMATICS IN THE MODERN WORLD', 'NONE', '3', 'TBA', 'TBA'),
(135, '1st', '1st', 'BS-HM', '8:30-9:30', 'MWF', 'BRIDGING', 'ORGANIZATION AND MANAGEMENT(BRIDGING)', 'ABM', '3', 'TBA', 'TBA'),
(136, '1st', '1st', 'BS-HM', '2:30-4:00', 'MWF', 'BRIDGING', 'FUNDAMENTALS OF ACCOUNTING, BUSINESS AND MANAGEMENT', 'ABM', '3', 'TBA', 'TBA'),
(137, '1st', '1st', 'BS-HM', '11:00-2:00', 'SAT', 'BRIDGING', 'BUSINESS MARKETING(BRIDGING)', 'ABM', '3', 'TBA', 'TBA'),
(138, '1st', '1st', 'BEED', '8:30-9:30', 'MWF', 'EDUC 111', 'THE CHILD AND ADOLESCENT LEARNERS AND LEARNING PRINCIPLES', 'NONE', '3', 'TBA', 'TBA'),
(139, '1st', '1st', 'BEED', '9:30-10:30', 'MWF', 'NSTP 1', 'NATIONAL SERVICE TRAINING PROGRAM ', 'NONE', '3', 'TBA', 'TBA'),
(140, '1st', '1st', 'BEED', '10:30-11:30', 'MW', 'PE 1', 'MOVEMENT ENHANCEMENT', 'NONE', '2', 'TBA', 'TBA'),
(141, '1st', '1st', 'BEED', '1:00-2:00', 'MWF', 'MST 114', 'PEOPLE AND THE EARTH\'S ECOSYSTEM', 'NONE', '3', 'TBA', 'TBA'),
(142, '1st', '1st', 'BEED', '3:00-4:00', 'MWF', 'SOCSCI 112', 'THE CONTEMPORARY WORLD', 'NONE', '3', 'TBA', 'TBA'),
(143, '1st', '1st', 'BEED', '7:30-9:00', 'TTH', 'SOCSCI 111', 'UNDERSTANDING THE SELF', 'NONE', '3', 'TBA', 'TBA'),
(144, '1st', '1st', 'BEED', '9:00-10:30', 'TTH', 'HIST 110', 'READINGS IN THE PHILLIPINE HISTORY', 'NONE', '3', 'TBA', 'TBA'),
(145, '1st', '1st', 'BEED', '1:00-2:00', 'TTH', 'MATH 110', 'MATHEMATICS IN THE MODERN WORLD', 'NONE', '3', 'TBA', 'TBA'),
(146, '1st', '1st', 'BEED', '2:30-4:00', 'TTH', 'FIL 110', 'KOMUNIKASYON SA AKADEMIKONG FILIPINO', 'NONE', '3', 'TBA', 'TBA'),
(147, '1st', '1st', 'BSED', '8:30-9:30', 'MWF', 'FIL 101', 'INTRODUKSYON SA PAG-AARAL NG WIKA', 'NONE', '3', 'TBA', 'TBA'),
(148, '1st', '1st', 'BSED', '9:30-10:30', 'MWF', 'FIL 110', 'KOMUNIKASYON SA AKADEMIKONG FILIPINO', 'NONE', '3', 'TBA', 'TBA'),
(149, '1st', '1st', 'BSED', '10:30-11:30', 'MW', 'PE 1', 'MOVEMENT ENHANCEMENT', 'NONE', '2', 'TBA', 'TBA'),
(150, '1st', '1st', 'BSED', '2:00-3:00', 'MWF', 'SOCSCI 111', 'UNDERSTANDING THE SELF', 'NONE', '3', 'TBA', 'TBA'),
(151, '1st', '1st', 'BSED', '4:00-5:00', 'MWF', 'MATH 110', 'MATHEMATICS IN THE MODERN WORLD', 'NONE', '3', 'TBA', 'TBA'),
(152, '1st', '1st', 'BSED', '5:15-6:15', 'MWF', 'FIL 102', 'PANIMULANG LINGGWISTIKA', 'NONE', '3', 'TBA', 'TBA'),
(153, '1st', '1st', 'BSED', '10:30-12:00', 'TTH', 'HIST 110', 'READINGS IN THE PHILLIPINE HISTORY', 'NONE', '3', 'TBA', 'TBA'),
(154, '1st', '1st', 'BSED', '1:00-2:30', 'TTH', 'SOCSCI 112', 'THE CONTEMPORARY WORLD', 'NONE', '3', 'TBA', 'TBA'),
(155, '1st', '1st', 'BSED', '2:30-4:00', 'TTH', 'NSTP 1', 'NATIONAL SERVICE TRAINING PROGRAM 1', 'NONE', '3', 'TBA', 'TBA');

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
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, ' admin', 'admin', '0192023a7bbd73250516f069df18b500', 1);

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
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `enroll2024`
--
ALTER TABLE `enroll2024`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

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
