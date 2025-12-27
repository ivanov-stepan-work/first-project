-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: 10.0.0.56:3306
-- Generation Time: Nov 06, 2024 at 04:48 AM
-- Server version: 10.6.19-MariaDB-cll-lve-log
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `j91963602`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id_department` int(11) NOT NULL,
  `name` varchar(65) NOT NULL,
  `head_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id_department`, `name`, `head_id`) VALUES
(47, 'Кафедра математики и информатики', 807);

-- --------------------------------------------------------

--
-- Table structure for table `department_teachers`
--

CREATE TABLE `department_teachers` (
  `department_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id_group` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `dep_id` int(65) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id_group`, `name`, `dep_id`) VALUES
(21, 'БК-342.2', 53);

-- --------------------------------------------------------

--
-- Table structure for table `number_of_students`
--

CREATE TABLE `number_of_students` (
  `teacher_id` int(11) NOT NULL,
  `numbers_of` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `objects`
--

CREATE TABLE `objects` (
  `id_object` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `objects`
--

INSERT INTO `objects` (`id_object`, `name`) VALUES
(47, 'Биология'),
(55, 'География'),
(59, 'Естествознание'),
(52, 'Иностранный язык'),
(44, 'Информатика'),
(53, 'История'),
(48, 'Литература'),
(54, 'Математика'),
(57, 'ОБЖ'),
(49, 'Обществознание'),
(61, 'Обществознание (вкл. экономику и право)'),
(50, 'Основы безопасности жизнедеятельности'),
(58, 'Родная литература'),
(51, 'Русский язык'),
(45, 'Физика'),
(46, 'Физическая культура'),
(56, 'Химия');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id_project` int(11) NOT NULL,
  `object_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `topic` text DEFAULT NULL,
  `grade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `name`) VALUES
(1, 'Admin'),
(2, 'Head_of_department'),
(4, 'Methodologist'),
(5, 'Student'),
(3, 'Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE `roles_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles_users`
--

INSERT INTO `roles_users` (`role_id`, `user_id`) VALUES
(1, 88),
(2, 347),
(3, 348);

-- --------------------------------------------------------

--
-- Table structure for table `student_groups`
--

CREATE TABLE `student_groups` (
  `student_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;



--
-- Table structure for table `teachers_objects`
--

CREATE TABLE `teachers_objects` (
  `teacher_id` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `middlename` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `login`, `password`, `lastname`, `firstname`, `middlename`) VALUES
(88, 'Администратор', '12345678', NULL, NULL, NULL),
(347, 'АнтоновИК', '12345678', 'Антонов', 'Илья', 'Константинович'),
(348, 'БароваАС', 'mdVgJ4fR', 'Барова', 'Алена', 'Сергеевна');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id_department`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `head_id` (`head_id`),
  ADD KEY `1_idx` (`head_id`);

--
-- Indexes for table `department_teachers`
--
ALTER TABLE `department_teachers`
  ADD UNIQUE KEY `teacher_id` (`teacher_id`),
  ADD KEY `1_idx` (`department_id`),
  ADD KEY `1_idx1` (`teacher_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id_group`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `groups_ibfk_1` (`dep_id`);

--
-- Indexes for table `number_of_students`
--
ALTER TABLE `number_of_students`
  ADD UNIQUE KEY `teacher_id` (`teacher_id`),
  ADD KEY `1_idx` (`teacher_id`);

--
-- Indexes for table `objects`
--
ALTER TABLE `objects`
  ADD PRIMARY KEY (`id_object`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id_project`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `1_idx` (`object_id`),
  ADD KEY `1_idx1` (`teacher_id`),
  ADD KEY `1_idx2` (`student_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD UNIQUE KEY `role_id` (`role_id`,`user_id`),
  ADD KEY `roles_users_ibfk_2` (`user_id`);

--
-- Indexes for table `student_groups`
--
ALTER TABLE `student_groups`
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `1_idx` (`student_id`),
  ADD KEY `1_idx1` (`group_id`);

--
-- Indexes for table `teachers_objects`
--
ALTER TABLE `teachers_objects`
  ADD KEY `FTOTU` (`teacher_id`),
  ADD KEY `FTOTO` (`object_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id_department` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `objects`
--
ALTER TABLE `objects`
  MODIFY `id_object` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=917;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `FIDFU` FOREIGN KEY (`head_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `department_teachers`
--
ALTER TABLE `department_teachers`
  ADD CONSTRAINT `FIDTFD` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id_department`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FIDTFU` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departments` (`id_department`);

--
-- Constraints for table `number_of_students`
--
ALTER TABLE `number_of_students`
  ADD CONSTRAINT `FINOSFU` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `FIPFO` FOREIGN KEY (`object_id`) REFERENCES `objects` (`id_object`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FIPFU` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FIPFU1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id_role`) ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_groups`
--
ALTER TABLE `student_groups`
  ADD CONSTRAINT `FISGFG` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id_group`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FISGFU` FOREIGN KEY (`student_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers_objects`
--
ALTER TABLE `teachers_objects`
  ADD CONSTRAINT `FTOTO` FOREIGN KEY (`object_id`) REFERENCES `objects` (`id_object`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FTOTU` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
