-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 22, 2024 at 08:32 PM
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
-- Database: `semcom_alumini`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `result_status` varchar(10) NOT NULL,
  `sgpa` varchar(6) NOT NULL,
  `cgpa` varchar(6) NOT NULL,
  `result_img` varchar(50) NOT NULL,
  `add_request` varchar(10) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`result_id`),
  KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

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
