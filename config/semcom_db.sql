-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 20, 2024 at 10:32 AM
-- Server version: 8.0.37
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
  `result_request` char(3) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`class_id`),
  UNIQUE KEY `unique_row` (`course_name`,`class_semester`,`class_div`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course_class`
--

INSERT INTO `course_class` (`class_id`, `course_name`, `class_semester`, `class_div`, `class_enroll_start`, `class_enroll_end`, `result_request`) VALUES
(9, 'BCA', '1', '-', '100000001', '100000002', 'no');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `exp` varchar(5) NOT NULL,
  `skills` varchar(100) NOT NULL,
  `qualifications` varchar(100) NOT NULL,
  `clg_email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `staff_img` varchar(50) NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `clg_email` (`clg_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff_dtl`
--

INSERT INTO `staff_dtl` (`staff_id`, `prefix`, `full_name`, `gender`, `dob`, `doj`, `mob_no`, `hi_qualification`, `exp`, `skills`, `qualifications`, `clg_email`, `password`, `staff_img`) VALUES
(1, 'Mrs.', 'Ami trivedi', 'Female', '1998-06-03', '2016-06-03', '9685741203', 'Graduate', '5 yrs', 'Teaching', 'MCA', 'ami@semcom.edu.in', '12345678', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_academic_details`
--

INSERT INTO `stud_academic_details` (`academic_id`, `enroll_no`, `ssc_board`, `ssc_month_year`, `ssc_percentage`, `ssc_school`, `ssc_medium`, `hsc_board`, `hsc_month_year`, `hsc_percentage`, `hsc_school`, `hsc_medium`, `stud_achieve`) VALUES
(1, '12101150801011', 'GSEB', '2018-03', '82.33', 'Shantiniketan', 'Gujarati', 'GSEB', '2020-03', '78', 'Narayan Vidhyalaya', 'Gujarati', 'Essay Competition Winner at School'),
(2, '12101150801038', 'CBSE', '2018-12', '99', 'SHan', 'Guj', 'CBSE', '2020-03', '100', 'Shanti', 'Guj', 'CEO'),
(3, '12101150801074', 'ICSE', '2024-01', '33.33', 'IB Patel', 'Charotari', 'NIOS', '2024-02', '33.34', 'Desi Public School', 'Nigerian', 'Principal Peon');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_achieve`
--

INSERT INTO `stud_achieve` (`ach_id`, `enroll_no`, `semester`, `event_date`, `event`, `description`) VALUES
(1, '12101150801074', '4', '2024-06-17', 'BBIC', 'won first prize and cash prize of 1Lakh.'),
(3, '12101150801074', '6', '2024-06-04', 'CVMU HACKATHON', 'won last prize and humiliation also.'),
(4, '12101150801011', '1', '2024-02-18', 'other', '2nd Prize'),
(5, '12101150801011', '2', '2024-05-28', 'Hindi Essay', '1st');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_address`
--

INSERT INTO `stud_address` (`add_id`, `enroll_no`, `resident_type`, `permanent_add`, `permanent_add2`, `permanent_city`, `permanent_pincode`, `present_add`, `present_add2`, `present_city`, `present_pincode`) VALUES
(9, '12101150801011', 'localite', '20-a Housing Society', 'Kalol', 'Kalol', '389330', '20-a Housing Society', 'Kalol', 'Kalol', '389330'),
(10, '12101150801038', 'localite', 'fbhli', ';jgasdkk;', 'sjhblaf', '325896', 'sbd;jai', 'ssb;da', 'dbfhjav', '123456'),
(11, '12101150801074', 'localite', 'ram street', 'gokul nagar', 'Kolkata', '321321', 'anand', 'Oppo. APIED', 'Kolkata', '523234');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_login`
--

INSERT INTO `stud_login` (`stud_id`, `enroll_no`, `password`, `complete_register`) VALUES
(1, '12101150801011', '12345', 'yes'),
(2, '12101150801038', '12345', 'yes'),
(3, '12101150801074', '123', 'yes');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_other_details`
--

INSERT INTO `stud_other_details` (`other_id`, `enroll_no`, `dob`, `blood_grp`, `stud_height`, `stud_weight`, `stud_hobbies`, `stud_category`, `stud_religion`, `eng_know`, `hindi_know`, `guj_know`, `other_know`) VALUES
(1, '12101150801011', '2004-02-24', 'B+', '145', '45', 'Playing', 'general', 'Hinduism', 'Read,Write', 'Read,Write,Speak', 'Read,Write,Speak', 'NA'),
(2, '12101150801038', '2024-03-15', 'A-', '171', '67', 'Coding', 'general', 'Hinduism', 'Read,Speak', 'Write', 'Read,Speak', 'Marathi'),
(3, '12101150801074', '2004-08-12', 'AB+', '176', '61', 'Coding', 'obc', 'Islam', 'Read,Write', 'Read,Speak', 'Speak', 'French,Russian,Urdu,');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_parents_details`
--

INSERT INTO `stud_parents_details` (`p_id`, `enroll_no`, `fathers_name`, `lang_father`, `fathers_mob`, `father_wp`, `fathers_email`, `fathers_occup`, `fathers_co`, `fathers_desig`, `fathers_annual_income`, `mothers_name`, `lang_mother`, `mothers_mob`, `mother_wp`, `mothers_email`, `mothers_occup`, `mothers_co`, `mothers_desig`, `mothers_annual_income`, `emergency_mob`, `emergency_name`, `emergency_relationship`, `emergency_add`, `emergency_city`, `emergency_pincode`) VALUES
(1, '12101150801011', 'Jayeshkumar', 'Gujarati', '9426560053', 'yes', 'jayesh@gmail.com', 'Businessman', 'Shreenathji Trading CO.', 'NA', '2000000', 'Bhaminiben', 'Gujarati', '9685741023', 'no', 'bhamin@gmail.com', 'Homemaker', 'NA', 'NA', '0', '6352947011', 'Tanvi', 'Sister', 'Ahmedabad', 'Ahmedabad', '390001'),
(2, '12101150801038', 'Miten', 'English,Gujarati', '1210115080', 'yes', 'j@gmail.com', 'adbhsl', 'sabs', 'fbjak', '215646', 'abhsf', 'Gujarati,Hindi', '1210115080', 'no', 'vhdshlJ@gmail.com', 'sdbjakl', 'djajbs', 'basjn', '2165451', '2156489781', 'xyz', 'xyz', 'avhsdj', 'dsbhav', '962551'),
(3, '12101150801074', 'drgreghergtrgerdyhredyh', 'Gujarati', '3253425435', 'no', 'dryrdy@asdb.com', 'yjrtujrt', 'eryeryreyrsdf', 'dghndthgdr', '24123423', 'hsrthrt', '', '9054920165', 'no', 'hdrhrdh@ugd.in', 'Beating', 'eryeryreyrsdf', 'Homeminnisrter', '123456789', '3242342343', 'gfhdthdrg', 'ehgergrege', 'egdrghrgsrgse', 'hjfytfrhdthdr', '321321');

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
  `stud_semester` char(1) NOT NULL,
  `stud_division` char(1) NOT NULL,
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
  PRIMARY KEY (`stud_id`),
  UNIQUE KEY `enroll_no` (`enroll_no`),
  UNIQUE KEY `enroll_no_2` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_personal_details`
--

INSERT INTO `stud_personal_details` (`stud_id`, `adm_status`, `adm_date`, `spid`, `enroll_no`, `stud_course`, `stud_semester`, `stud_division`, `roll_no`, `f_name`, `m_name`, `l_name`, `gender`, `mob_no`, `email_id`, `aadhar_no`, `abc_id`, `pro_pic`) VALUES
(9, 'regular', '2024-06-01', '12101150801038', '12101150801038', 'BCOM', '', '', '38', 'Kunj', 'Miten', 'Patel', 'male', '1210115080', 'kunj@gmail.com', '12101150801038', '12101150801038', '12101150801038.jpg'),
(10, 'prov_admission', '2024-06-04', '2021001407', '12101150801074', 'BCA', '', '', '74', 'Utkarsh', 'M', 'Rajput', 'male', '9054920165', 'ut@gmail.com', '921886122012', '64669694569', '12101150801074.jpg'),
(11, 'regular', '2024-06-19', '20240001107', '12101150801011', 'BCA', '1', 'A', '11', 'Darsh', 'Jayeshkumar', 'Parikh', 'male', '9662799456', 'iamdarsh244@gmail.com', '9632587410', '12317916', '12101150801011.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stud_result`
--

INSERT INTO `stud_result` (`result_id`, `enroll_no`, `course`, `semester`, `sgpa`, `cgpa`, `result_img`, `add_request`) VALUES
(1, '12101150801074', 'BCA', '1', '9.71', '9.71', '12101150801074_1.jpg', 'pending'),
(2, '12101150801011', 'BCA', '1', '9.00', '9.00', '12101150801011_1.jpg', 'pending');

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
