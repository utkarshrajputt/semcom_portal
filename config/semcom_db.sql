-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 02, 2024 at 05:48 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `semcom_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

DROP TABLE IF EXISTS `admin_login`;
CREATE TABLE IF NOT EXISTS `admin_login` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `admin_email` varchar(25) NOT NULL,
  `password` varchar(15) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`admin_id`, `admin_email`, `password`) VALUES
(1, 'admin@semcom.com', 'semcom');

-- --------------------------------------------------------

--
-- Table structure for table `course_class`
--

DROP TABLE IF EXISTS `course_class`;
CREATE TABLE IF NOT EXISTS `course_class` (
  `class_id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `class_semester` char(1) NOT NULL,
  `class_div` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '-',
  `class_enroll_start` varchar(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `class_enroll_end` varchar(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`class_id`),
  UNIQUE KEY `unique_row` (`course_name`,`class_semester`,`class_div`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course_class`
--

INSERT INTO `course_class` (`class_id`, `course_name`, `class_semester`, `class_div`, `class_enroll_start`, `class_enroll_end`) VALUES
(9, 'BCA', '1', 'A', '12101150801001', '12101150801020'),
(10, 'BCA', '1', 'B', '12101150801021', '12101150801040'),
(12, 'BBA', '1', 'A', '12101150801041', '12101150801060'),
(13, 'BBA-ITM', '1', 'A', '12101150801061', '12101150801080'),
(14, 'BBA-ITM', '1', 'B', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_class_assign`
--

DROP TABLE IF EXISTS `staff_class_assign`;
CREATE TABLE IF NOT EXISTS `staff_class_assign` (
  `a_id` int NOT NULL AUTO_INCREMENT,
  `staff_email` varchar(35) NOT NULL,
  `course` varchar(7) NOT NULL,
  `semester` char(1) NOT NULL,
  `division` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '-',
  PRIMARY KEY (`a_id`),
  KEY `staff_foreign` (`staff_email`),
  KEY `fk_child_parent` (`course`,`semester`,`division`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff_class_assign`
--

INSERT INTO `staff_class_assign` (`a_id`, `staff_email`, `course`, `semester`, `division`) VALUES
(16, 'ami@semcom.edu.in', 'BCA', '1', 'A'),
(17, 'premal@semcom.edu.in', 'BCA', '1', 'B'),
(18, 'palak@semcom.edu.in', 'BBA', '1', 'A'),
(19, 'mikita@semcom.edu.in', 'BBA-ITM', '1', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `staff_dtl`
--

DROP TABLE IF EXISTS `staff_dtl`;
CREATE TABLE IF NOT EXISTS `staff_dtl` (
  `staff_id` int NOT NULL AUTO_INCREMENT,
  `prefix` varchar(7) NOT NULL,
  `full_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` varchar(6) NOT NULL,
  `dob` date NOT NULL,
  `doj` date NOT NULL,
  `mob_no` varchar(11) NOT NULL,
  `hi_qualification` varchar(50) NOT NULL,
  `exp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `skills` varchar(100) NOT NULL,
  `qualifications` varchar(100) NOT NULL,
  `clg_email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `staff_img` varchar(50) NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `clg_email` (`clg_email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff_dtl`
--

INSERT INTO `staff_dtl` (`staff_id`, `prefix`, `full_name`, `gender`, `dob`, `doj`, `mob_no`, `hi_qualification`, `exp`, `skills`, `qualifications`, `clg_email`, `password`, `staff_img`) VALUES
(4, 'Ms.', 'Ami Trivedi', 'female', '2024-06-01', '2024-06-02', '3242342343', 'Post Graduate', '12', 'Programming', 'MCA', 'ami@semcom.edu.in', '12345678', 'Ami20240630171642.jpg'),
(5, 'Ms.', 'Palak Patel', 'female', '2024-06-08', '2024-06-17', '3516315315', 'Post Graduate', '5', 'Database', 'MCA', 'palak@semcom.edu.in', '12345678', 'Palak20240630172811.jpg'),
(6, 'Dr.', 'Mehul Patel', 'male', '2024-06-11', '2024-06-13', '3253425435', 'Ph.D', '5', 'ML', 'MCA', 'mehul@semcom.edu.in', '12345678', 'Mehul20240630172959.jpg'),
(8, 'Ms.', 'Mikita Bhatiya', 'male', '2024-06-01', '2024-06-15', '2589631478', 'Post Graduate', '5', 'Programming', 'MCA', 'mikita@semcom.edu.in', '12345678', 'Mikita20240630173648.jpg'),
(10, 'Mr.', 'Premal Soni', 'male', '2024-06-06', '2024-06-14', '3242342343', 'Post Graduate', '5', 'ML', 'MCA', 'premal@semcom.edu.in', '12345678', 'Premal20240630174138.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stud_academic_details`
--

DROP TABLE IF EXISTS `stud_academic_details`;
CREATE TABLE IF NOT EXISTS `stud_academic_details` (
  `academic_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) NOT NULL,
  `ssc_board` varchar(60) NOT NULL,
  `ssc_month_year` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ssc_percentage` varchar(5) NOT NULL,
  `ssc_school` varchar(50) NOT NULL,
  `ssc_medium` varchar(10) NOT NULL,
  `hsc_board` varchar(60) NOT NULL,
  `hsc_month_year` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `hsc_percentage` varchar(5) NOT NULL,
  `hsc_school` varchar(50) NOT NULL,
  `hsc_medium` varchar(10) NOT NULL,
  `stud_achieve` varchar(50) NOT NULL,
  PRIMARY KEY (`academic_id`),
  KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_academic_details`
--

INSERT INTO `stud_academic_details` (`academic_id`, `enroll_no`, `ssc_board`, `ssc_month_year`, `ssc_percentage`, `ssc_school`, `ssc_medium`, `hsc_board`, `hsc_month_year`, `hsc_percentage`, `hsc_school`, `hsc_medium`, `stud_achieve`) VALUES
(1, '12101150801011', 'GSEB', '2018-03', '82.33', 'Shantiniketan Vidhyalaya', 'Gujarati', 'GSEB', '2020-03', '78', 'Narayan Vidhyalaya', 'Gujarati', 'Essay Competition Winner at School'),
(2, '12101150801038', 'CBSE', '2018-12', '99', 'SHan', 'Guj', 'CBSE', '2020-03', '100', 'Shanti', 'Guj', 'CEO'),
(3, '12101150801074', 'ICSE', '2024-01', '33.33', 'IB Patel', 'Charotari', 'NIOS', '2024-02', '33.34', 'Desi Public School', 'Nigerian', 'Principal Peon'),
(4, '12101150801017', 'ICSE', '2024-02', '85', 'ZEN Patel', 'Hindi', 'CBSE', '2024-04', '86', 'ZEN', 'English', 'Karate'),
(5, '12101150801006', 'IB', '2024-01', '85', 'IB Patel', 'Hindi', 'CBSE', '2024-04', '56', 'ZEN', 'English', 'Badminton'),
(6, '12101150801036', 'ICSE', '2024-02', '98', 'ZEN Patel', 'English', 'CBSE', '2024-02', '86', 'Delhi Public School', 'English', 'Sketching Champion'),
(7, '12101150801040', 'GSEB', '2024-01', '89', 'VC Patel', 'Gujarati', 'GSEB', '2024-02', '86', 'Delhi Public School', 'Gujarati', 'Chess Champion'),
(8, '12101150801042', 'NIOS', '2024-01', '89', 'VC Patel', 'Gujarati', 'ICSE', '2024-02', '86', 'Delhi Public School', 'Gujarati', 'Chess Champion'),
(9, '12101150801001', 'GSEB', '2024-01', '33.33', 'IB Patel', 'Hindi', 'GSEB', '2024-03', '56', 'ZEN', 'Gujarati', 'Karate');

-- --------------------------------------------------------

--
-- Table structure for table `stud_achieve`
--

DROP TABLE IF EXISTS `stud_achieve`;
CREATE TABLE IF NOT EXISTS `stud_achieve` (
  `ach_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) NOT NULL,
  `semester` varchar(5) NOT NULL,
  `event_date` date NOT NULL,
  `event` varchar(60) NOT NULL,
  `description` varchar(150) NOT NULL,
  PRIMARY KEY (`ach_id`),
  KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_achieve`
--

INSERT INTO `stud_achieve` (`ach_id`, `enroll_no`, `semester`, `event_date`, `event`, `description`) VALUES
(1, '12101150801074', '4', '2024-06-17', 'BBIC', 'won first prize and cash prize of 1Lakh.'),
(3, '12101150801074', '6', '2024-06-04', 'CVMU HACKATHON', 'won last prize and humiliation also.'),
(4, '12101150801011', '1', '2024-02-18', 'other', '2nd Prize'),
(5, '12101150801011', '2', '2024-05-28', 'Hindi Essay', '1st'),
(6, '12101150801074', '1', '2024-06-24', 'Smart Eye', 'Won first prize in '),
(7, '12101150801006', '1', '2024-07-09', '', 'SSIP');

-- --------------------------------------------------------

--
-- Table structure for table `stud_address`
--

DROP TABLE IF EXISTS `stud_address`;
CREATE TABLE IF NOT EXISTS `stud_address` (
  `add_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `resident_type` varchar(12) NOT NULL,
  `permanent_add` varchar(40) NOT NULL,
  `permanent_add2` varchar(40) NOT NULL,
  `permanent_city` varchar(20) NOT NULL,
  `permanent_pincode` varchar(7) NOT NULL,
  `present_add` varchar(40) NOT NULL,
  `present_add2` varchar(40) NOT NULL,
  `present_city` varchar(20) NOT NULL,
  `present_pincode` varchar(7) NOT NULL,
  PRIMARY KEY (`add_id`),
  KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_address`
--

INSERT INTO `stud_address` (`add_id`, `enroll_no`, `resident_type`, `permanent_add`, `permanent_add2`, `permanent_city`, `permanent_pincode`, `present_add`, `present_add2`, `present_city`, `present_pincode`) VALUES
(9, '12101150801011', 'localite', '20-a Housing Society', 'Kalol', 'Kalol', '389330', '20-a Housing Society', 'Kalol', 'Kalol', '389330'),
(10, '12101150801038', 'localite', 'Anand', 'Anand', 'Anand', '325896', 'Anand', 'Anand', 'Anand', '123456'),
(11, '12101150801074', 'localite', 'ram street', 'gokul nagar west andheri east', 'Kolkata', '321321', 'anand', 'Oppo. APIED', 'Kolkata', '523234'),
(12, '12101150801017', 'localite', 'Ravi kiran', 'karamsad road', 'VVnagar', '388120', 'Ravi kiran', 'karamsad road', 'VVnagar', '388120'),
(13, '12101150801006', 'localite', 'Gyan Society', 'b/h Railway Station', 'Nadiad', '388125', 'Gyan Society', 'b/h Railway Station', 'Nadiad', '388125'),
(14, '12101150801036', 'hostalite', 'Shubh Society', 'mandal road', 'Porbandar', '523234', 'AM Naik', 'Oppo. APIED', 'VVNagar', '388120'),
(15, '12101150801040', 'localite', 'Tirth Bunglows', 'Nr. AVD', 'Bakrol', '388123', 'Tirth Bunglows', 'Nr. AVD', 'Bakrol', '388123'),
(16, '12101150801042', 'hostalite', 'manan flats', 'gotri', 'vadodra', '123154', 'Square Hostel', 'BH Bust stand', 'VVNagar', '388120'),
(17, '12101150801001', 'localite', 'Ravi Kiran', 'karamsad road', 'VVNagar', '321321', 'Ravi Kiran', 'karamsad road', 'VVNagar', '321321');

-- --------------------------------------------------------

--
-- Table structure for table `stud_attendance`
--

DROP TABLE IF EXISTS `stud_attendance`;
CREATE TABLE IF NOT EXISTS `stud_attendance` (
  `at_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) NOT NULL,
  `course` varchar(10) NOT NULL,
  `semester` varchar(5) NOT NULL,
  `division` varchar(5) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `at_percentage` float NOT NULL,
  PRIMARY KEY (`at_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_attendance`
--

INSERT INTO `stud_attendance` (`at_id`, `enroll_no`, `course`, `semester`, `division`, `start_date`, `end_date`, `at_percentage`) VALUES
(9, '12101150801006', 'BCA', '1', 'A', '2024-06-03', '2024-06-08', 85),
(10, '12101150801011', 'BCA', '1', 'A', '2024-06-03', '2024-06-08', 32),
(11, '12101150801017', 'BCA', '1', 'A', '2024-06-03', '2024-06-08', 99),
(12, '12101150801006', 'BCA', '1', 'A', '2024-07-01', '2024-07-06', 85),
(13, '12101150801011', 'BCA', '1', 'A', '2024-07-01', '2024-07-06', 69),
(14, '12101150801017', 'BCA', '1', 'A', '2024-07-01', '2024-07-06', 88);

-- --------------------------------------------------------

--
-- Table structure for table `stud_counsel`
--

DROP TABLE IF EXISTS `stud_counsel`;
CREATE TABLE IF NOT EXISTS `stud_counsel` (
  `c_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) NOT NULL,
  `c_date` date NOT NULL,
  `counselling_of` varchar(15) NOT NULL,
  `mode_counsel` varchar(15) NOT NULL,
  `c_time` varchar(15) NOT NULL,
  `counsel_session_info` varchar(100) NOT NULL,
  PRIMARY KEY (`c_id`),
  KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_counsel`
--

INSERT INTO `stud_counsel` (`c_id`, `enroll_no`, `c_date`, `counselling_of`, `mode_counsel`, `c_time`, `counsel_session_info`) VALUES
(27, '12101150801011', '2024-06-26', 'Parents', 'Call', '12:11', 'short meeting with father'),
(30, '12101150801074', '2024-06-26', 'Parents', 'Letter', '12:18', 'attendance notice sent'),
(31, '12101150801074', '2024-06-26', 'Other', 'Physical', '12:18', 'parents were called for a short meeting'),
(32, '12101150801006', '2024-06-27', 'Students', 'Physical', '12:31', 'Asked about the probelms faced by him in the college');

-- --------------------------------------------------------

--
-- Table structure for table `stud_login`
--

DROP TABLE IF EXISTS `stud_login`;
CREATE TABLE IF NOT EXISTS `stud_login` (
  `stud_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(15) NOT NULL,
  `complete_register` varchar(3) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`stud_id`),
  UNIQUE KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_login`
--

INSERT INTO `stud_login` (`stud_id`, `enroll_no`, `password`, `complete_register`) VALUES
(1, '12101150801011', '12345', 'yes'),
(2, '12101150801038', '12345', 'yes'),
(3, '12101150801074', '123', 'yes'),
(10, '12101150801001', 'semcom@1001', 'yes'),
(11, '12101150801002', 'semcom@1002', 'no'),
(12, '12101150801003', 'semcom@1003', 'no'),
(13, '12101150801004', 'semcom@1004', 'no'),
(14, '12101150801005', 'semcom@1005', 'no'),
(15, '12101150801006', 'semcom@1006', 'yes'),
(16, '12101150801007', 'semcom@1007', 'no'),
(17, '12101150801008', 'semcom@1008', 'no'),
(18, '12101150801009', 'semcom@1009', 'no'),
(19, '12101150801010', 'semcom@1010', 'no'),
(27, '12101150801012', 'semcom@1012', 'no'),
(28, '12101150801013', 'semcom@1013', 'no'),
(29, '12101150801014', 'semcom@1014', 'no'),
(30, '12101150801015', 'semcom@1015', 'no'),
(31, '12101150801016', 'semcom@1016', 'no'),
(32, '12101150801017', 'semcom@1017', 'yes'),
(33, '12101150801018', 'semcom@1018', 'no'),
(34, '12101150801019', 'semcom@1019', 'no'),
(35, '12101150801020', 'semcom@1020', 'no'),
(36, '12101150801021', 'semcom@1021', 'no'),
(37, '12101150801022', 'semcom@1022', 'no'),
(38, '12101150801023', 'semcom@1023', 'no'),
(39, '12101150801024', 'semcom@1024', 'no'),
(40, '12101150801025', 'semcom@1025', 'no'),
(41, '12101150801026', 'semcom@1026', 'no'),
(42, '12101150801027', 'semcom@1027', 'no'),
(43, '12101150801028', 'semcom@1028', 'no'),
(44, '12101150801029', 'semcom@1029', 'no'),
(45, '12101150801030', 'semcom@1030', 'no'),
(46, '12101150801031', 'semcom@1031', 'no'),
(47, '12101150801032', 'semcom@1032', 'no'),
(48, '12101150801033', 'semcom@1033', 'no'),
(49, '12101150801034', 'semcom@1034', 'no'),
(50, '12101150801035', 'semcom@1035', 'no'),
(51, '12101150801036', 'semcom@1036', 'yes'),
(52, '12101150801037', 'semcom@1037', 'no'),
(53, '12101150801039', 'semcom@1039', 'no'),
(54, '12101150801040', 'semcom@1040', 'yes'),
(55, '12101150801041', 'semcom@1041', 'no'),
(56, '12101150801042', '123', 'yes'),
(57, '12101150801043', 'semcom@1043', 'no'),
(58, '12101150801044', 'semcom@1044', 'no'),
(59, '12101150801045', 'semcom@1045', 'no'),
(60, '12101150801046', 'semcom@1046', 'no'),
(61, '12101150801047', 'semcom@1047', 'no'),
(62, '12101150801048', 'semcom@1048', 'no'),
(63, '12101150801049', 'semcom@1049', 'no'),
(64, '12101150801050', 'semcom@1050', 'no'),
(65, '12101150801051', 'semcom@1051', 'no'),
(66, '12101150801052', 'semcom@1052', 'no'),
(67, '12101150801053', 'semcom@1053', 'no'),
(68, '12101150801054', 'semcom@1054', 'no'),
(69, '12101150801055', 'semcom@1055', 'no'),
(70, '12101150801056', 'semcom@1056', 'no'),
(71, '12101150801057', 'semcom@1057', 'no'),
(72, '12101150801058', 'semcom@1058', 'no'),
(73, '12101150801059', 'semcom@1059', 'no'),
(74, '12101150801060', 'semcom@1060', 'no'),
(75, '12101150801061', 'semcom@1061', 'no'),
(76, '12101150801062', 'semcom@1062', 'no'),
(77, '12101150801063', 'semcom@1063', 'no'),
(78, '12101150801064', 'semcom@1064', 'no'),
(79, '12101150801065', 'semcom@1065', 'no'),
(80, '12101150801066', 'semcom@1066', 'no'),
(81, '12101150801067', 'semcom@1067', 'no'),
(82, '12101150801068', 'semcom@1068', 'no'),
(83, '12101150801069', 'semcom@1069', 'no'),
(84, '12101150801070', 'semcom@1070', 'no'),
(85, '12101150801071', 'semcom@1071', 'no'),
(86, '12101150801072', 'semcom@1072', 'no'),
(87, '12101150801073', 'semcom@1073', 'no'),
(88, '12101150801075', 'semcom@1075', 'no'),
(89, '12101150801076', 'semcom@1076', 'no'),
(90, '12101150801077', 'semcom@1077', 'no'),
(91, '12101150801078', 'semcom@1078', 'no'),
(92, '12101150801079', 'semcom@1079', 'no'),
(93, '12101150801080', 'semcom@1080', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `stud_other_details`
--

DROP TABLE IF EXISTS `stud_other_details`;
CREATE TABLE IF NOT EXISTS `stud_other_details` (
  `other_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dob` date NOT NULL,
  `blood_grp` varchar(5) NOT NULL,
  `stud_height` varchar(3) NOT NULL,
  `stud_weight` varchar(3) NOT NULL,
  `stud_hobbies` varchar(50) NOT NULL,
  `stud_category` varchar(15) NOT NULL,
  `stud_religion` varchar(15) NOT NULL,
  `eng_know` varchar(20) NOT NULL,
  `hindi_know` varchar(20) NOT NULL,
  `guj_know` varchar(20) NOT NULL,
  `other_know` varchar(20) NOT NULL,
  PRIMARY KEY (`other_id`),
  KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_other_details`
--

INSERT INTO `stud_other_details` (`other_id`, `enroll_no`, `dob`, `blood_grp`, `stud_height`, `stud_weight`, `stud_hobbies`, `stud_category`, `stud_religion`, `eng_know`, `hindi_know`, `guj_know`, `other_know`) VALUES
(1, '12101150801011', '2004-02-24', 'O-', '145', '45', 'Playing', 'general', 'Hinduism', 'Read,Write', 'Read,Write,Speak', 'Read,Write,Speak', 'NA'),
(2, '12101150801038', '2024-03-15', 'A-', '171', '67', 'Coding', 'general', 'Hinduism', 'Read,Speak', 'Write', 'Read,Speak', 'Marathi'),
(3, '12101150801074', '2004-08-12', 'AB+', '176', '61', 'Coding', 'obc', 'Islam', 'Read,Write', 'Read,Speak', 'Speak', 'French,Russian,Urdu,'),
(4, '12101150801017', '2024-04-01', 'O+', '145', '50', 'Cycling', 'obc', 'Hinduism', 'Read,Write', 'Read,Speak', 'Speak', 'Marathi'),
(5, '12101150801006', '2024-07-03', 'B-', '165', '75', 'Badminton', 'general', 'Hinduism', 'Read,Speak', 'Read,Write', 'Read,Write,Speak', 'Marathi'),
(6, '12101150801036', '2024-06-10', 'A+', '165', '85', 'Coding', 'st', 'Jainism', 'Read,Write', 'Read,Write,Speak', 'Read,Write,Speak', 'NA'),
(7, '12101150801040', '2024-06-03', 'A+', '165', '85', 'Stocks', 'general', 'Hinduism', 'Read,Write', 'Read,Write', 'Read,Write', 'Kathiyawadi'),
(8, '12101150801042', '2024-06-01', 'A+', '145', '69', 'Sleeping', 'general', 'Hinduism', 'Speak', 'Read,Write', 'Read,Write,Speak', 'NA'),
(9, '12101150801001', '2024-05-01', 'O-', '100', '25', 'Singing', 'st', 'Jainism', 'Speak', 'Write', 'Read', 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `stud_parents_details`
--

DROP TABLE IF EXISTS `stud_parents_details`;
CREATE TABLE IF NOT EXISTS `stud_parents_details` (
  `p_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) NOT NULL,
  `fathers_name` varchar(35) NOT NULL,
  `lang_father` varchar(35) NOT NULL,
  `fathers_mob` varchar(13) NOT NULL,
  `father_wp` varchar(5) NOT NULL,
  `fathers_email` varchar(25) NOT NULL,
  `fathers_occup` varchar(25) NOT NULL,
  `fathers_co` varchar(35) NOT NULL,
  `fathers_desig` varchar(25) NOT NULL,
  `fathers_annual_income` varchar(10) NOT NULL,
  `mothers_name` varchar(35) NOT NULL,
  `lang_mother` varchar(35) NOT NULL,
  `mothers_mob` varchar(13) NOT NULL,
  `mother_wp` varchar(5) NOT NULL,
  `mothers_email` varchar(25) NOT NULL,
  `mothers_occup` varchar(25) NOT NULL,
  `mothers_co` varchar(35) NOT NULL,
  `mothers_desig` varchar(25) NOT NULL,
  `mothers_annual_income` varchar(10) NOT NULL,
  `emergency_mob` varchar(13) NOT NULL,
  `emergency_name` varchar(25) NOT NULL,
  `emergency_relationship` varchar(25) NOT NULL,
  `emergency_add` varchar(35) NOT NULL,
  `emergency_city` varchar(15) NOT NULL,
  `emergency_pincode` varchar(7) NOT NULL,
  PRIMARY KEY (`p_id`),
  KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_parents_details`
--

INSERT INTO `stud_parents_details` (`p_id`, `enroll_no`, `fathers_name`, `lang_father`, `fathers_mob`, `father_wp`, `fathers_email`, `fathers_occup`, `fathers_co`, `fathers_desig`, `fathers_annual_income`, `mothers_name`, `lang_mother`, `mothers_mob`, `mother_wp`, `mothers_email`, `mothers_occup`, `mothers_co`, `mothers_desig`, `mothers_annual_income`, `emergency_mob`, `emergency_name`, `emergency_relationship`, `emergency_add`, `emergency_city`, `emergency_pincode`) VALUES
(1, '12101150801011', 'Jayeshkumar', 'Gujarati', '9426560054', 'yes', 'jayesh@gmail.com', 'Businessman', 'Shreenathji Trading CO.', 'NA', '2000000', 'Bhaminiben', 'Gujarati', '9685741023', 'no', 'bhamin@gmail.com', 'Homemaker', 'NA', 'NA', '0', '6352947011', 'Tanvi', 'Sister', 'Ahmedabad', 'Ahmedabad', '390001'),
(2, '12101150801038', 'Miten', 'English,Gujarati', '1210115080', 'yes', 'j@gmail.com', 'adbhsl', 'sabs', 'fbjak', '215646', 'abhsf', 'Gujarati,Hindi', '1210115080', 'no', 'vhdshlJ@gmail.com', 'sdbjakl', 'djajbs', 'basjn', '2165451', '2156489781', 'xyz', 'xyz', 'avhsdj', 'dsbhav', '962551'),
(3, '12101150801074', 'drgreghergtrgerdyhredyh', 'Gujarati', '3253425435', 'no', 'dryrdy@asdb.com', 'yjrtujrt', 'eryeryreyrsdf', 'dghndthgdr', '24123423', 'hsrthrt', '', '9054920165', 'no', 'hdrhrdh@ugd.in', 'Beating', 'eryeryreyrsdf', 'Homeminnisrter', '123456789', '3242342343', 'gfhdthdrg', 'ehgergrege', 'egdrghrgsrgse', 'hjfytfrhdthdr', '321321'),
(4, '12101150801017', 'Samir', 'English,Gujarati,Hindi', '3242342343', 'yes', 'sa@ugd.in', 'Business', 'Finger', 'Owner', '100000000', 'Sejal', 'English,Gujarati,Hindi', '2589631478', 'no', 'se@yahoo.com', 'Homemaker', 'NA', 'NA', '0', '2589631478', 'Deepak', 'Bestfriend', 'Ravi Kiran', 'VVNagar', '321321'),
(5, '12101150801006', 'Jitendra Dusane', 'Gujarati,Hindi', '9874563212', 'yes', 'jr@yahoo.com', 'Employed', 'IRCTC', 'Manager', '200000', 'Gayatri', 'Hindi', '7896541235', 'yes', 'gaya@gmail.com', 'Homemaker', 'NA', 'NA', ' NA', '8965471230', 'Deep', 'Bestfriend', 'Ravi Kiran', 'VVNagar', '321321'),
(6, '12101150801036', 'Shrey Shah', 'English,Hindi', '8956413313', 'yes', 'sh@yahoo.com', 'Business', 'Shail', 'Owner', '200000', 'Shilpa', 'English,Gujarati,Hindi', '8956412348', 'yes', 'shilpa@gmail.com', 'NA', 'NA', 'NA', ' NA', '4567891234', 'Deepa', 'Bestfriend', 'Ravi Kiran', 'VVNagar', '321321'),
(7, '12101150801040', ' Dinesh gor', 'English,Gujarati,Hindi', '9785131513', 'yes', 'din@outlook.com', 'Stock Broker', 'NA', 'NA', '250000', 'NilaBen', 'English,Gujarati', '9874563210', 'no', 'nila@gmail.com', 'NA', 'NA', 'Principal', ' 1200000', '2589631478', 'Dasrg', 'Friend', 'Ravi Kiran', 'VVNagar', '321321'),
(8, '12101150801042', 'Utkarsh Rajput', 'English,Gujarati', '9874656313', 'yes', 'ut@gmail.com', 'Business', 'Enter Enterprises', 'Owner', '100000000', 'Katrina', 'English,Gujarati,Hindi', '6547892313', 'yes', 'kat@yahoo.com', 'NA', 'NA', 'NA', 'NA', '2589631478', 'Vicky', 'Friend', 'Ravi Kiran', 'VVNagar', '321321'),
(9, '12101150801001', 'Aman Talpade', 'Hindi', '8796541354', 'yes', 'talpadeaman@yahoo.com', 'Homemaker', 'NA', 'NA', '0', 'Mamta Talpade', 'English', '6969691212', 'yes', 'talpdamum@gmail.com', 'CA', 'Laxmi Chit Fund', ' Director', ' 100000', '3253425435', 'Deepa', 'Friend', 'anand', 'Kolkata', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `stud_personal_details`
--

DROP TABLE IF EXISTS `stud_personal_details`;
CREATE TABLE IF NOT EXISTS `stud_personal_details` (
  `stud_id` int NOT NULL AUTO_INCREMENT,
  `adm_status` varchar(20) NOT NULL,
  `adm_date` date NOT NULL,
  `spid` varchar(15) NOT NULL,
  `enroll_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stud_course` varchar(10) NOT NULL,
  `stud_sem` varchar(5) NOT NULL DEFAULT '-',
  `stud_div` varchar(5) NOT NULL DEFAULT '-',
  `roll_no` varchar(10) NOT NULL,
  `f_name` varchar(25) NOT NULL,
  `m_name` varchar(25) NOT NULL,
  `l_name` varchar(25) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `mob_no` varchar(13) NOT NULL,
  `email_id` varchar(25) NOT NULL,
  `aadhar_no` varchar(15) NOT NULL,
  `abc_id` varchar(15) NOT NULL,
  `pro_pic` varchar(35) NOT NULL,
  `security_que` varchar(70) NOT NULL,
  `security_ans` varchar(50) NOT NULL,
  PRIMARY KEY (`stud_id`),
  UNIQUE KEY `enroll_no` (`enroll_no`),
  UNIQUE KEY `enroll_no_2` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_personal_details`
--

INSERT INTO `stud_personal_details` (`stud_id`, `adm_status`, `adm_date`, `spid`, `enroll_no`, `stud_course`, `stud_sem`, `stud_div`, `roll_no`, `f_name`, `m_name`, `l_name`, `gender`, `mob_no`, `email_id`, `aadhar_no`, `abc_id`, `pro_pic`, `security_que`, `security_ans`) VALUES
(9, 'regular', '2024-06-01', '2021001438', '12101150801038', 'BCA', '1', 'A', '38', 'Kunj', 'Miten', 'Patel', 'male', '1210115080', 'kunj@gmail.com', '12101150801038', '12101150801038', '12101150801038.jpg', '', ''),
(10, 'prov_admission', '2024-06-04', '2021001407', '12101150801074', 'BBA-ITM', '1', 'A', '74', 'Utkarsh', 'M', 'Rajput', 'male', '9054912345', 'ut@gmail.com', '921886122012', '64669694569', '12101150801074.jpg', '', ''),
(12, 'regular', '2024-06-05', '368196896', '12101150801011', 'BCA', '1', 'A', '12', 'Darsh', 'Jayeshkumar', 'Parikh', 'male', '9662799457', 'iamdarsh244@gmail.com', '9632587410', '12317916', '12101150801011.jpg', '', ''),
(14, 'regular', '2024-06-05', '2021001408', '12101150801017', 'BCA', '1', 'A', '17', 'Diya', 'Samir', 'Patel', 'female', '3516315315', 'diya@gmail.com', '921886112345', '64669654321', '12101150801017.jpeg', '', ''),
(15, 'regular', '2024-06-01', '2021001406', '12101150801006', 'BCA', '-', '-', '06', 'Aman', 'J', 'Dusane', 'male', '8523697410', 'aman@gmail.com', '921886165412', '64669696325', '12101150801006.jpeg', '', ''),
(16, 'regular', '2024-06-12', '2021001436', '12101150801036', 'BCA', '-', '-', '36', 'Krushal', 'Z', 'Gohel', 'male', '7894563112', 'krusha@yahoo.com', '921886154789', '64669696547', '12101150801036.jpeg', '', ''),
(17, 'regular', '2024-06-04', '2021001440', '12101150801040', 'BCA', '-', '-', '40', 'Kushal', 'D', 'Gor', 'male', '9874563215', 'kusha@yahoo.com', '921886154758', '64669691234', '12101150801040.jpeg', '', ''),
(19, 'regular', '2024-06-13', '2021001442', '12101150801042', 'BBA', '-', '-', '42', 'Manan', 'H', 'Patel', 'male', '9874587963', 'manan@yahoo.com', '921886154758', '64669691234', '12101150801042.jpeg', 'frnd_name', 'gor'),
(20, 'regular', '2024-06-01', '2021001401', '12101150801001', 'BCA', '-', '-', '01', 'Deepa', 'P', 'Talpade', 'female', '8974563221', 'deepa@gmail.com', '589632147589', '64669698965', '12101150801001.jpeg', 'pet_name', 'mouse');

-- --------------------------------------------------------

--
-- Table structure for table `stud_result`
--

DROP TABLE IF EXISTS `stud_result`;
CREATE TABLE IF NOT EXISTS `stud_result` (
  `result_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) NOT NULL,
  `course` varchar(25) NOT NULL,
  `semester` varchar(5) NOT NULL,
  `sgpa` varchar(6) NOT NULL,
  `cgpa` varchar(6) NOT NULL,
  `result_img` varchar(50) NOT NULL,
  `add_request` varchar(10) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`result_id`),
  KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_result`
--

INSERT INTO `stud_result` (`result_id`, `enroll_no`, `course`, `semester`, `sgpa`, `cgpa`, `result_img`, `add_request`) VALUES
(1, '12101150801074', 'BCA', '1', '9.71', '9.71', '12101150801074_1.jpg', 'accepted'),
(4, '12101150801038', 'BCA', '1', '5.5', '5.5', '12101150801038_1.jpg', 'pending'),
(5, '12101150801017', 'BCA', '1', '9.54', '9.54', '12101150801017_1.jpeg', 'pending'),
(6, '12101150801006', 'BCA', '1', '6.5', '6.5', '12101150801006_1.jpg', 'pending'),
(7, '12101150801040', 'BCA', '1', '6.5', '6.5', '12101150801040_1.jpg', 'pending');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `staff_class_assign`
--
ALTER TABLE `staff_class_assign`
  ADD CONSTRAINT `fk_child_parent` FOREIGN KEY (`course`,`semester`,`division`) REFERENCES `course_class` (`course_name`, `class_semester`, `class_div`),
  ADD CONSTRAINT `staff_foreign` FOREIGN KEY (`staff_email`) REFERENCES `staff_dtl` (`clg_email`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `stud_academic_details`
--
ALTER TABLE `stud_academic_details`
  ADD CONSTRAINT `stud_academic_details_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `stud_address`
--
ALTER TABLE `stud_address`
  ADD CONSTRAINT `stud_address_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `stud_counsel`
--
ALTER TABLE `stud_counsel`
  ADD CONSTRAINT `stud_counsel_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `stud_other_details`
--
ALTER TABLE `stud_other_details`
  ADD CONSTRAINT `stud_other_details_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `stud_parents_details`
--
ALTER TABLE `stud_parents_details`
  ADD CONSTRAINT `stud_parents_details_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `stud_personal_details`
--
ALTER TABLE `stud_personal_details`
  ADD CONSTRAINT `stud_personal_details_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `stud_result`
--
ALTER TABLE `stud_result`
  ADD CONSTRAINT `stud_result_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
