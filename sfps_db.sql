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

INSERT INTO `courses` (`id`, `course`, `department`, `description`, `level`, `laboratory`, `computer`, `academic`, `academic_nstp`, `total_amount`, `date_created`) VALUES
(2, 'Bachelor of Science in Information Technology(BSIT)', 'BSIT', 'dsfdsfsd', '3rd ', 0, 0, 0, 0, 3125.02, '2024-06-28 13:05:29');

CREATE TABLE `fees` (
  `id` int(30) NOT NULL,
  `course_id` int(30) NULL,
  `description` varchar(200) NULL,
  `amount` float NULL
);

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

-- --------------------------------------------------------

--
-- Table structure for table `student_ef_list`
--

CREATE TABLE `student_ef_list` (
  `id` int(30) NOT NULL,
  `student_id` int(30) NULL,
  `ef_no` varchar(200) NULL,
  `course_id` int(30) NULL,
  `total_fee` float NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
);

-- --------------------------------------------------------

--
-- Table structure for table `student_enroll`
--

CREATE TABLE `student_enroll` (
  `application_no` int(11) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NULL,
  `email` varchar(200) NULL,
  `contact` varchar(20) NULL,
  `cover_img` text NULL,
  `about_content` text NULL
);

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
  `name` text NULL,
  `username` varchar(200) NULL,
  `password` text NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff'
);

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'admin', 'admin', '0192023a7bbd73250516f069df18b500', 1);
