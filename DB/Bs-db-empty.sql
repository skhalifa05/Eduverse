-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2022 at 03:31 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_list`
--

CREATE TABLE `attendance_list` (
  `User_ID` int(11) NOT NULL,
  `Lecture_ID` int(11) NOT NULL,
  `State` varchar(100) NOT NULL,
  `Arrival_Time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `available_devices`
--

CREATE TABLE `available_devices` (
  `Device_ID` int(11) NOT NULL,
  `Device_Number` varchar(255) NOT NULL,
  `Device_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `center`
--

CREATE TABLE `center` (
  `Center_User_ID` int(11) NOT NULL,
  `F_Name` varchar(150) NOT NULL,
  `M_Name` varchar(150) NOT NULL,
  `L_Name` varchar(150) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` int(150) NOT NULL,
  `Type` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `Course_ID` int(11) NOT NULL,
  `Admin_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_time`
--

CREATE TABLE `course_time` (
  `Course_Time_ID` int(11) NOT NULL,
  `Course_ID` int(11) NOT NULL,
  `Day` varchar(5) NOT NULL,
  `Time` time NOT NULL,
  `Period` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `Admin_ID` int(11) NOT NULL,
  `F_Name` varchar(150) NOT NULL,
  `M_Name` varchar(150) NOT NULL,
  `L_Name` varchar(150) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `Phone` varchar(25) NOT NULL,
  `Subject` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_teaching_grades`
--

CREATE TABLE `doctor_teaching_grades` (
  `Doctor_ID` int(11) NOT NULL,
  `Grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_teaching_school`
--

CREATE TABLE `doctor_teaching_school` (
  `Doctor_ID` int(11) NOT NULL,
  `School_Name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `Lecture_ID` int(11) NOT NULL,
  `Course_Time_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Device_Reader` int(11) DEFAULT NULL,
  `State` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_ID` int(11) NOT NULL,
  `F_Name` varchar(50) NOT NULL,
  `M_Name` varchar(150) NOT NULL,
  `L_Name` varchar(50) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `Phone` varchar(25) NOT NULL,
  `School_Name` varchar(50) NOT NULL,
  `Grade` int(11) NOT NULL,
  `Age` int(11) NOT NULL,
  `Relation_Name` varchar(50) NOT NULL,
  `Parent_Name` varchar(150) NOT NULL,
  `Relation_Phone` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `time_table`
--

CREATE TABLE `time_table` (
  `User_ID` int(11) NOT NULL,
  `Course_Time_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_list`
--
ALTER TABLE `attendance_list`
  ADD PRIMARY KEY (`User_ID`,`Lecture_ID`),
  ADD KEY `Lecture_ID_Atendance_FK` (`Lecture_ID`);

--
-- Indexes for table `available_devices`
--
ALTER TABLE `available_devices`
  ADD PRIMARY KEY (`Device_ID`);

--
-- Indexes for table `center`
--
ALTER TABLE `center`
  ADD PRIMARY KEY (`Center_User_ID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`Course_ID`),
  ADD KEY `Doctor_ID_Course_FK` (`Admin_ID`);

--
-- Indexes for table `course_time`
--
ALTER TABLE `course_time`
  ADD PRIMARY KEY (`Course_Time_ID`),
  ADD KEY `Course_ID_FK` (`Course_ID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `doctor_teaching_grades`
--
ALTER TABLE `doctor_teaching_grades`
  ADD PRIMARY KEY (`Doctor_ID`,`Grade`);

--
-- Indexes for table `doctor_teaching_school`
--
ALTER TABLE `doctor_teaching_school`
  ADD PRIMARY KEY (`Doctor_ID`,`School_Name`);

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`Lecture_ID`),
  ADD KEY `Course_Time_ID_Lecture_FK` (`Course_Time_ID`),
  ADD KEY `Device_Reader_ID_FK` (`Device_Reader`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_ID`) USING BTREE;

--
-- Indexes for table `time_table`
--
ALTER TABLE `time_table`
  ADD PRIMARY KEY (`User_ID`,`Course_Time_ID`),
  ADD KEY `Time_Table_Course_ID_FK` (`Course_Time_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `available_devices`
--
ALTER TABLE `available_devices`
  MODIFY `Device_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `center`
--
ALTER TABLE `center`
  MODIFY `Center_User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `Course_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_time`
--
ALTER TABLE `course_time`
  MODIFY `Course_Time_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `Lecture_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Student_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20220014;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_list`
--
ALTER TABLE `attendance_list`
  ADD CONSTRAINT `Lecture_ID_Atendance_FK` FOREIGN KEY (`Lecture_ID`) REFERENCES `lectures` (`Lecture_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `User_ID_Attendance_FK` FOREIGN KEY (`User_ID`) REFERENCES `student` (`Student_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `Doctor_ID_Course_FK` FOREIGN KEY (`Admin_ID`) REFERENCES `doctor` (`Admin_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_time`
--
ALTER TABLE `course_time`
  ADD CONSTRAINT `Course_ID_FK` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`Course_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `doctor_teaching_grades`
--
ALTER TABLE `doctor_teaching_grades`
  ADD CONSTRAINT `Doctor_ID_Grade_FK` FOREIGN KEY (`Doctor_ID`) REFERENCES `doctor` (`Admin_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `doctor_teaching_school`
--
ALTER TABLE `doctor_teaching_school`
  ADD CONSTRAINT `Doctor_ID_Fk` FOREIGN KEY (`Doctor_ID`) REFERENCES `doctor` (`Admin_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lectures`
--
ALTER TABLE `lectures`
  ADD CONSTRAINT `Course_Time_ID_Lecture_FK` FOREIGN KEY (`Course_Time_ID`) REFERENCES `course_time` (`Course_Time_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Device_Reader_ID_FK` FOREIGN KEY (`Device_Reader`) REFERENCES `available_devices` (`Device_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `time_table`
--
ALTER TABLE `time_table`
  ADD CONSTRAINT `Time_Table_Course_ID_FK` FOREIGN KEY (`Course_Time_ID`) REFERENCES `course_time` (`Course_Time_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Time_Table_User_ID_FK` FOREIGN KEY (`User_ID`) REFERENCES `student` (`Student_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
