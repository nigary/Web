
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Database: `payments`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountingType`
--

CREATE TABLE `accountingType` (
  `accountingID` tinyint(4) NOT NULL,
  `accounting` varchar(20) NOT NULL,
  `accountCoefficient` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountingType`
--

INSERT INTO `accountingType` (`accountingID`, `accounting`, `accountCoefficient`) VALUES
(1, 'debit', -1),
(2, 'credit', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` tinyint(4) NOT NULL,
  `category` varchar(20) NOT NULL,
  `accountingID` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `category`, `accountingID`) VALUES
(1, 'Transportation', 2),
(2, 'Scholarship', 1),
(3, 'Restaurant', 2),
(4, 'Store', 2);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentID` tinyint(4) NOT NULL,
  `paymentMethod` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`paymentID`, `paymentMethod`) VALUES
(1, 'cash'),
(2, 'credit card'),
(3, 'check'),
(4, 'bank transfer');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionID` int(11) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `paymentID` tinyint(4) NOT NULL,
  `categoryID` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionID`, `amount`, `date`, `paymentID`, `categoryID`) VALUES
(1, 24, '2023-05-02', 2, 3),
(2, 150, '2023-04-26', 4, 2),
(3, 45, '2023-04-12', 3, 4),
(4, 78, '2023-04-08', 2, 4),
(5, 12, '2023-05-01', 1, 1),
(6, 36, '2023-03-22', 4, 3),
(7, 59, '2023-04-20', 1, 3),
(8, 250, '2023-04-24', 3, 2),
(9, 27, '2023-03-07', 2, 4),
(10, 178, '2023-04-17', 4, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountingType`
--
ALTER TABLE `accountingType`
  ADD PRIMARY KEY (`accountingID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`),
  ADD KEY `accountingID` (`accountingID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `paymentID` (`paymentID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`accountingID`) REFERENCES `accountingType` (`accountingID`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`paymentID`) REFERENCES `payments` (`paymentID`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryID`);
COMMIT;
