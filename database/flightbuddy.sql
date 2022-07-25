-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2021 at 10:44 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flightbuddy`
--

-- --------------------------------------------------------

--
-- Table structure for table `airplane`
--

CREATE TABLE `airplane` (
  `id` int(11) NOT NULL,
  `years_of_service` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `airplane`
--

INSERT INTO `airplane` (`id`, `years_of_service`, `model`, `company`) VALUES
(1, 20, 'Airbus A380', 'Plane Makers'),
(2, 5, 'Boeing 747-8', 'Plane Makers'),
(3, 10, 'Boeing 747-8', 'Plane Makers'),
(4, 2, 'ATR', 'Airplaners'),
(5, 25, 'Boeing 747-8', 'Airplaners'),
(6, 6, 'Boeing 747-8', 'Airplaners'),
(7, 2, 'ATR', 'Airplaners'),
(8, 2, 'ATR', 'Airplaners'),
(9, 3, 'ATR', 'Airplaners'),
(10, 5, 'Boeing 747-8', 'Airplaners');

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

CREATE TABLE `airport` (
  `name` varchar(3) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `province_state` varchar(255) DEFAULT NULL,
  `city_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `airport`
--

INSERT INTO `airport` (`name`, `country`, `province_state`, `city_name`) VALUES
('EWR', 'USA', 'New York', 'New York City'),
('SAN', 'USA', 'California', 'San Diego'),
('SEA', 'USA', 'Washington State', 'Seattle'),
('SJC', 'USA', 'California', 'San Jose'),
('YYC', 'Canada', 'Alberta', 'Calgary'),
('YYZ', 'Canada', 'Ontario', 'Toronto');

-- --------------------------------------------------------

--
-- Table structure for table `air_route`
--

CREATE TABLE `air_route` (
  `id` int(11) NOT NULL,
  `arrival_airport` varchar(3) NOT NULL,
  `departure_airport` varchar(3) NOT NULL,
  `flight_time` int(11) NOT NULL,
  `distance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `air_route`
--

INSERT INTO `air_route` (`id`, `arrival_airport`, `departure_airport`, `flight_time`, `distance`) VALUES
(1, 'YYC', 'YYZ', 300, 3406),
(2, 'YYZ', 'YYC', 330, 3500),
(3, 'YYC', 'SEA', 180, 1127),
(4, 'SEA', 'YYC', 200, 1500),
(5, 'EWR', 'YYZ', 320, 2200),
(6, 'EWR', 'YYZ', 340, 2400),
(7, 'EWR', 'YYZ', 300, 2000),
(8, 'SJC', 'SAN', 150, 1300);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `country` varchar(255) NOT NULL,
  `province_state` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`country`, `province_state`, `name`) VALUES
('Canada', 'Alberta', 'Calgary'),
('Canada', 'Ontario', 'Toronto'),
('USA', 'California', 'San Diego'),
('USA', 'California', 'San Jose'),
('USA', 'New York', 'New York City'),
('USA', 'Washington State', 'Seattle');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `username` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`username`, `display_name`, `status`) VALUES
('user3', 'Markus Wallburg', 'non-member'),
('user4', 'Edith Jones', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `client_query`
--

CREATE TABLE `client_query` (
  `id` int(11) NOT NULL,
  `date` varchar(8) NOT NULL,
  `time` varchar(5) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `isWantingHotel` int(11) DEFAULT NULL,
  `distance` decimal(10,0) DEFAULT NULL,
  `departure_airport` varchar(3) NOT NULL,
  `arrival_airport` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `client_query`
--

INSERT INTO `client_query` (`id`, `date`, `time`, `price`, `isWantingHotel`, `distance`, `departure_airport`, `arrival_airport`) VALUES
(1, '01/01/20', '11:00', '100', 0, '5000', 'YYC', 'YYZ');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `CEO` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`name`, `phone`, `CEO`) VALUES
('Airplaners', 'XXX-XXX-XXXX', 'Jack Frost'),
('Plane Makers', 'XXX-XXX-XXXX', 'Plane-Man');

-- --------------------------------------------------------

--
-- Table structure for table `connection`
--

CREATE TABLE `connection` (
  `id` int(11) NOT NULL,
  `date` varchar(10) NOT NULL,
  `time` varchar(5) NOT NULL,
  `available_seats` int(11) NOT NULL,
  `route_id` int(11) DEFAULT NULL,
  `airplane_id` int(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `connection`
--

INSERT INTO `connection` (`id`, `date`, `time`, `available_seats`, `route_id`, `airplane_id`, `price`) VALUES
(2, '2021-04-16', '06:00', 200, 2, 10, '200'),
(3, '2021-04-17', '05:00', 150, 3, 9, '1020'),
(4, '2021-04-18', '07:00', 200, 4, 8, '181'),
(5, '2021-04-20', '08:00', 300, 5, 4, '318'),
(6, '2021-04-20', '14:00', 200, 6, 5, '427'),
(7, '2021-04-20', '12:00', 200, 7, 3, '8218'),
(8, '2021-04-22', '17:00', 250, 5, 3, '721'),
(45, '2021-04-23', '11:00', 42, 1, 2, '812'),
(100, '2021-04-24', '5:00', 140, 2, 2, '73'),
(102, '2021-04-25', '6:00', 140, 4, 5, '782'),
(103, '2021-04-26', '7:00', 1, 6, 2, '378'),
(200, '2021-04-27', '8:00', 5, 8, 2, '221'),
(2001, '2021-04-28', '9:00', 45, 1, 2, '500'),
(2002, '2021-04-28', '10:00', 45, 1, 3, '400'),
(2003, '2021-04-28', '11:00', 45, 1, 4, '300'),
(5000, '2021-04-28', '12:00', 45, 1, 2, '200'),
(5001, '2021-04-28', '13:00', 45, 1, 1, '100'),
(5002, '2021-04-28', '14:00', 45, 1, 5, '50'),
(5003, '2021-04-28', '11:00', 45, 1, 2, '25');

-- --------------------------------------------------------

--
-- Table structure for table `flight_manager`
--

CREATE TABLE `flight_manager` (
  `username` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `flight_manager`
--

INSERT INTO `flight_manager` (`username`, `company`) VALUES
('user1', 'Airplaner'),
('user2', 'Plane Makers'),
('kevin', 'KEVINFLIES');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `address` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `num_of_beds` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `airport` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`address`, `name`, `num_of_beds`, `price`, `airport`) VALUES
('\"11th Street\"', '\"AlRadah Hotel\"', 2, '150', 'YYC'),
('\"12th Street\"', '\"ElHajj Hotel\"', 4, '500', 'YYC'),
('100th Street', 'NY Hotel', 4, '10', 'EWR');

-- --------------------------------------------------------

--
-- Table structure for table `manages`
--

CREATE TABLE `manages` (
  `connection_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `manages`
--

INSERT INTO `manages` (`connection_id`, `username`) VALUES
(2, 'kevin'),
(3, 'User1'),
(4, 'User1'),
(5, 'kevin'),
(6, 'User1'),
(7, 'kevin'),
(8, 'User1');

-- --------------------------------------------------------

--
-- Table structure for table `plane_type`
--

CREATE TABLE `plane_type` (
  `model` varchar(255) NOT NULL,
  `num_of_seats` int(11) NOT NULL,
  `designer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `plane_type`
--

INSERT INTO `plane_type` (`model`, `num_of_seats`, `designer`) VALUES
('Airbus A380', 116, 'Designer Man'),
('ATR', 60, 'Designer man3'),
('Boeing 747-8', 410, 'Designer man2');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `seat_num` int(11) NOT NULL,
  `seat_type` varchar(255) DEFAULT NULL,
  `client_username` varchar(255) DEFAULT NULL,
  `connection_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`seat_num`, `seat_type`, `client_username`, `connection_id`) VALUES
(1, 'business', 'User4', 5),
(13, 'economy', 'User3', 1),
(20, 'economy', 'User3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `first_name`, `last_name`) VALUES
('demo', '$2y$10$uHZI/ZqvJBlhXgTGrYbtxuImdxn2I0hlM2RT4oCyFRQp41UGRWgQa', 'DEMOgmail.com', 'de', 'mo'),
('kevin', '$2y$10$9LdbIHfq7G/h9d6NBI8s2O9HnaIOckE8/tXSDMO1hEK/vZJYQ3V8K', 'kevin@gmail.com', 'Kevin', 'Zhang'),
('newaccount', '$2y$10$xVioBKbx9zHKqBXwWlKV6.jT.63f3lHeNlNJYFsscIecdthNezUqi', 'newaccount@gmail.com', 'New', 'Account'),
('newuser', '$2y$10$63ausv8/30qwCRk2IUNlNORjRe2AZ3W5rA/GusRI4b/IK3BpvaETm', 'newuser@gmail.com', 'NEW', 'USER'),
('notman', '$2y$10$BvAncKVQp9QAfoAXsO00M.3ZGsTHjq5.ADMIfWnpqaq9njdDts2kS', 'notman@gmail.com', 'Not ', 'Man'),
('reguser', '$2y$10$xj4NO2c7UyTfDJtPw87vluMM.a5AULxpQVHgvEiKfzu4W/qQpqEry', 'reguser@gmail.com', 'REG', 'USER'),
('tester', '$2y$10$4/zDQZ1tguWKEjDpMvj2Ruov20yW/H0E6JtdhI.F8uvGs2OdzUZb.', 'TESTERER@gmail.com', 'test', 'er'),
('testUser2', '$2y$10$8/7HMv2PF1wEA6FS1Rk.ZOYgQM8k7fa6Gf2Re0hY5ytpjckHkQ16.', 'kevin@gmail.com', 'Kevin', 'Harry'),
('testUser3', '$2y$10$SKEN0nSbcaLcBZXB35ML/uAKR8HYQuklNq36oy9qaZy8uou595kK6', 'testUser3@gmail.com', '', ''),
('user1', '$2y$10$vc0u4BtPakZWILAgLuZqMOPZMBjylJnVVldYq.LrNK9L7xLG0KaZy', 'newemail@gmail.com', 'newFirstName', 'newLastName'),
('user2', '$2y$10$6xkL/nega/KRmYNkooNUuuw3cGgatqTz14K.q/A2byb9prvBgScaq', 'user2@gmail.com', 'User', 'Two'),
('user3', '$2y$10$6xkL/nega/KRmYNkooNUuuw3cGgatqTz14K.q/A2byb9prvBgScaq', 'user3@gmail.com', 'User', 'Three'),
('user4', '$2y$10$6xkL/nega/KRmYNkooNUuuw3cGgatqTz14K.q/A2byb9prvBgScaq', 'user4@gmail.com', 'User', 'Four');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airplane`
--
ALTER TABLE `airplane`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `air_route`
--
ALTER TABLE `air_route`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`country`,`province_state`,`name`);

--
-- Indexes for table `client_query`
--
ALTER TABLE `client_query`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `connection`
--
ALTER TABLE `connection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`address`);

--
-- Indexes for table `manages`
--
ALTER TABLE `manages`
  ADD PRIMARY KEY (`connection_id`,`username`);

--
-- Indexes for table `plane_type`
--
ALTER TABLE `plane_type`
  ADD PRIMARY KEY (`model`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`seat_num`,`connection_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
