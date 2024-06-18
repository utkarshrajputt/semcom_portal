<<<<<<< HEAD
=======
-- Create the user 'semcom' with the password 'semcom'
CREATE USER 'semcom'@'%' IDENTIFIED BY 'semcom';

-- Grant all privileges to the user 'semcom' on all databases and tables
GRANT ALL PRIVILEGES ON *.* TO 'semcom'@'%';

-- Apply the changes
FLUSH PRIVILEGES;
>>>>>>> c35c06075302edaa2ef1b6ee90d7779c757458f5
Drop database if exists 'semcom_db';
CREATE DATABASE semcom_db;
USE semcom_db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `semcom_db`
--

-- Drop tables if they exist
DROP TABLE IF EXISTS `admin_login`;
DROP TABLE IF EXISTS `staff_login`;
DROP TABLE IF EXISTS `stud_academic_details`;
DROP TABLE IF EXISTS `stud_address`;
DROP TABLE IF EXISTS `stud_login`;
DROP TABLE IF EXISTS `stud_other_details`;
DROP TABLE IF EXISTS `stud_parents_details`;
DROP TABLE IF EXISTS `stud_personal_details`;

-- Create tables
CREATE TABLE `admin_login` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `admin_email` varchar(25) NOT NULL,
  `password` varchar(15) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `staff_login` (
  `staff_id` int NOT NULL AUTO_INCREMENT,
  `staff_email` varchar(25) NOT NULL,
  `password` varchar(15) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `stud_academic_details` (
  `academic_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) NOT NULL,
  `ssc_board` varchar(60) NOT NULL,
  `ssc_month_year` varchar(16) NOT NULL,
  `ssc_percentage` varchar(5) NOT NULL,
  `ssc_school` varchar(50) NOT NULL,
  `ssc_medium` varchar(10) NOT NULL,
  `hsc_board` varchar(60) NOT NULL,
  `hsc_month_year` varchar(16) NOT NULL,
  `hsc_percentage` varchar(5) NOT NULL,
  `hsc_school` varchar(50) NOT NULL,
  `hsc_medium` varchar(10) NOT NULL,
  `stud_achieve` varchar(50) NOT NULL,
  PRIMARY KEY (`academic_id`),
  KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `stud_address` (
  `add_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `stud_login` (
  `stud_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `complete_register` varchar(3) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`stud_id`),
  UNIQUE KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `stud_other_details` (
  `other_id` int NOT NULL AUTO_INCREMENT,
  `enroll_no` varchar(15) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `stud_parents_details` (
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `stud_personal_details` (
  `stud_id` int NOT NULL AUTO_INCREMENT,
  `adm_status` varchar(20) NOT NULL,
  `adm_date` date NOT NULL,
  `spid` varchar(15) NOT NULL,
  `enroll_no` varchar(15) NOT NULL,
 `stud_course` varchar(10) NOT NULL,
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
  UNIQUE KEY `enroll_no` (`enroll_no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Insert data into tables
INSERT INTO `stud_academic_details` (`academic_id`, `enroll_no`, `ssc_board`, `ssc_month_year`, `ssc_percentage`, `ssc_school`, `ssc_medium`, `hsc_board`, `hsc_month_year`, `hsc_percentage`, `hsc_school`, `hsc_medium`, `stud_achieve`) VALUES
(1, '12101150801011', 'GSEB', '2018-03', '82.33', 'Shantiniketan', 'Gujarati', 'GSEB', '2020-03', '78', 'Narayan Vidhyalaya', 'Gujarati', 'Essay Competition Winner at School'),
(2, '12101150801038', 'CBSE', '2018-12', '99', 'SHan', 'Guj', 'CBSE', '2020-03', '100', 'Shanti', 'Guj', 'CEO');

INSERT INTO `stud_address` (`add_id`, `enroll_no`, `resident_type`, `permanent_add`, `permanent_add2`, `permanent_city`, `permanent_pincode`, `present_add`, `present_add2`, `present_city`, `present_pincode`) VALUES
(9, '12101150801011', 'localite', '20-a Housing Society', 'Kalol', 'Kalol', '389330', '20-a Housing Society', 'Kalol', 'Kalol', '389330'),
(10, '12101150801038', 'localite', 'fbhli', ';jgasdkk;', 'sjhblaf', '325896', 'sbd;jai', 'ssb;da', 'dbfhjav', '123456');

INSERT INTO `stud_login` (`stud_id`, `enroll_no`, `password`, `complete_register`) VALUES
(1, '12101150801011', '12345', 'yes'),
(2, '12101150801038', '12345', 'yes');

INSERT INTO `stud_other_details` (`other_id`, `enroll_no`, `dob`, `blood_grp`, `stud_height`, `stud_weight`, `stud_hobbies`, `stud_category`, `stud_religion`, `eng_know`, `hindi_know`, `guj_know`, `other_know`) VALUES
(1, '12101150801011', '2004-02-24', 'B+', '145', '45', 'Playing', 'general', 'Hinduism', 'Read,Write', 'Read,Write,Speak', 'Read,Write,Speak', 'NA'),
(2, '12101150801038', '2024-03-15', 'A-', '171', '67', 'Coding', 'general', 'Hinduism', 'Read,Speak', 'Write', 'Read,Speak', 'Marathi');

INSERT INTO `stud_parents_details` (`p_id`, `enroll_no`, `fathers_name`, `lang_father`, `fathers_mob`, `father_wp`, `fathers_email`, `fathers_occup`, `fathers_co`, `fathers_desig`, `fathers_annual_income`, `mothers_name`, `lang_mother`, `mothers_mob`, `mother_wp`, `mothers_email`, `mothers_occup`, `mothers_co`, `mothers_desig`, `mothers_annual_income`, `emergency_mob`, `emergency_name`, `emergency_relationship`, `emergency_add`, `emergency_city`, `emergency_pincode`) VALUES
(1, '12101150801011', 'Jayeshkumar', 'Gujarati', '9426560053', 'yes', 'jayesh@gmail.com', 'Businessman', 'Shreenathji Trading CO.', 'NA', '2000000', 'Bhaminiben', 'Gujarati', '9685741023', 'no', 'bhamin@gmail.com', 'Homemaker', 'NA', 'NA', '0', '6352947011', 'Tanvi', 'Sister', 'Ahmedabad', 'Ahmedabad', '390001'),
(2, '12101150801038', 'Miten', 'English,Gujarati', '1210115080', 'yes', 'j@gmail.com', 'adbhsl', 'sabs', 'fbjak', '215646', 'abhsf', 'Gujarati,Hindi', '1210115080', 'no', 'vhdshlJ@gmail.com', 'sdbjakl', 'djajbs', 'basjn', '2165451', '2156489781', 'xyz', 'xyz', 'avhsdj', 'dsbhav', '962551');

INSERT INTO `stud_personal_details` (`stud_id`, `adm_status`, `adm_date`, `spid`, `enroll_no`, `stud_course`, `roll_no`, `f_name`, `m_name`, `l_name`, `gender`, `mob_no`, `email_id`, `aadhar_no`, `abc_id`, `pro_pic`) VALUES
(8, 'regular', '2024-06-01', '2021001374', '12101150801011', 'BBA-ITM', '11', 'Darsh', 'Jayeshkumar', 'Parikh', 'male', '9662799456', 'iamdarsh@gmail.com', '9685741452', '654789321', '12101150801011.jpg'),
(9, 'regular', '2024-06-01', '12101150801038', '12101150801038', 'BCOM', '38', 'Kunj', 'Miten', 'Patel', 'male', '1210115080', 'kunj@gmail.com', '12101150801038', '12101150801038', '12101150801038.jpg'),
(10, 'prov_admission', '2024-06-04', '2021001407', '12101150801074', 'BCA', '74', 'Utkarsh', 'M', 'Rajput', 'male', '9054920165', 'ut@gmail.com', '921886122012', '64669694569', '12101150801074.jpg');

-- Add foreign key constraints
ALTER TABLE `stud_academic_details`
  ADD CONSTRAINT `stud_academic_details_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `stud_address`
  ADD CONSTRAINT `stud_address_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `stud_other_details`
  ADD CONSTRAINT `stud_other_details_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `stud_parents_details`
  ADD CONSTRAINT `stud_parents_details_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `stud_personal_details`
  ADD CONSTRAINT `stud_personal_details_ibfk_1` FOREIGN KEY (`enroll_no`) REFERENCES `stud_login` (`enroll_no`) ON DELETE RESTRICT ON UPDATE RESTRICT;

COMMIT;
