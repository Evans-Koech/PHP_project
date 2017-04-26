-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 15, 2017 at 03:14 PM
-- Server version: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `labooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `booklist`
--

CREATE TABLE `booklist` (
  `ID` int(11) NOT NULL,
  `BookTitle` varchar(255) NOT NULL,
  `Author` varchar(70) DEFAULT NULL,
  `ISBN` varchar(21) DEFAULT NULL,
  `Publisher` varchar(70) DEFAULT NULL,
  `Stock` int(11) NOT NULL DEFAULT '0',
  `ClassYear` int(11) NOT NULL DEFAULT '0',
  `Subject` int(11) NOT NULL DEFAULT '0',
  `UnitCost` double NOT NULL DEFAULT '0',
  `SellingPrice` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `classyears`
--

CREATE TABLE `classyears` (
  `ID` int(11) NOT NULL,
  `ClassYear` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classyears`
--

INSERT INTO `classyears` (`ID`, `ClassYear`) VALUES
(1, 'Baby Class'),
(2, 'Nursery'),
(3, 'Pre-Unit'),
(4, 'Class 1'),
(5, 'Class 2'),
(6, 'Class 3'),
(7, 'Class 4'),
(8, 'Class 5'),
(9, 'Class 6'),
(10, 'Class 7'),
(11, 'Class 8'),
(12, 'Form 1');

-- --------------------------------------------------------

--
-- Table structure for table `genledger`
--

CREATE TABLE `genledger` (
  `ID` int(11) NOT NULL,
  `TransactionType` int(11) NOT NULL,
  `Account` int(11) NOT NULL,
  `ItemName` int(11) NOT NULL,
  `Quantity` double NOT NULL,
  `AmounPaid` double NOT NULL,
  `TransactionDate` date NOT NULL,
  `DateRecCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ItemDescription` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `itemlist`
--

CREATE TABLE `itemlist` (
  `ID` int(11) NOT NULL,
  `ItemType` int(11) NOT NULL DEFAULT '0',
  `ItemName` varchar(70) NOT NULL,
  `ItemBrand` varchar(70) DEFAULT NULL,
  `ItemSize` double NOT NULL,
  `Unit` int(11) NOT NULL,
  `Stock` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lastnums`
--

CREATE TABLE `lastnums` (
  `TableName` char(25) NOT NULL DEFAULT '',
  `FieldName` char(25) DEFAULT NULL,
  `LastNum` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `InventoryType` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT '0',
  `OrderNum` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`InventoryType`, `ItemID`, `Quantity`, `OrderNum`) VALUES
(1, 5, 1, 0),
(1, 6, 1, 0),
(1, 7, 1, 0),
(1, 8, 1, 0),
(1, 9, 1, 0),
(1, 10, 1, 0),
(1, 11, 1, 0),
(1, 12, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `otheritems`
--

CREATE TABLE `otheritems` (
  `ID` int(11) NOT NULL,
  `ItemType` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `receiptitems`
--

CREATE TABLE `receiptitems` (
  `ID` int(11) NOT NULL,
  `InventoryType` int(11) NOT NULL DEFAULT '0',
  `ItemID` int(11) NOT NULL,
  `Quantity` double NOT NULL,
  `Amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `ID` int(11) NOT NULL,
  `ReceiptDate` date NOT NULL,
  `TotalAmount` double NOT NULL,
  `NumOfItems` int(11) NOT NULL,
  `ReceiptStatus` int(11) NOT NULL DEFAULT '0',
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `ID` int(11) NOT NULL,
  `ReportTitle` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`ID`, `ReportTitle`) VALUES
(1, 'Sales Report'),
(2, 'Inventory Levels Report'),
(3, 'Reorder Levels Report'),
(4, 'Best Seller Report'),
(5, 'Best Seller by Class Report'),
(6, 'Profit and Loss Report'),
(7, 'Sales by Time of Day Report'),
(8, 'Longest Shelf Life Report'),
(9, 'Shortest Shelf Life Report'),
(10, 'est Report 1'),
(11, 'est Report 2');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `ID` int(11) NOT NULL,
  `Subject` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`ID`, `Subject`) VALUES
(1, 'Mathematics'),
(2, 'English'),
(3, 'Kiswahili'),
(4, 'Physics'),
(5, 'Biology');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `ID` int(11) NOT NULL,
  `Unit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`ID`, `Unit`) VALUES
(1, 'Pages'),
(2, 'Dozen'),
(3, 'pieces');

-- --------------------------------------------------------

--
-- Table structure for table `userauth`
--

CREATE TABLE `userauth` (
  `userid` mediumint(8) UNSIGNED NOT NULL,
  `username` varchar(24) NOT NULL,
  `password` varchar(48) NOT NULL,
  `email` varchar(100) NOT NULL,
  `userlevel` tinyint(2) NOT NULL DEFAULT '0',
  `activationHash` varchar(100) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `sessionid` varchar(32) DEFAULT NULL,
  `lastActive` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userauth`
--

INSERT INTO `userauth` (`userid`, `username`, `password`, `email`, `userlevel`, `activationHash`, `active`, `sessionid`, `lastActive`, `name`) VALUES
(1, 'admin', '0d934760f5e82450939215b15a76e9fc04143bbe2b59df04', 'admin@example.com', 1, '', 1, '', '2017-01-15 10:04:16', 'Site Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booklist`
--
ALTER TABLE `booklist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `classyears`
--
ALTER TABLE `classyears`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `genledger`
--
ALTER TABLE `genledger`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `itemlist`
--
ALTER TABLE `itemlist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `lastnums`
--
ALTER TABLE `lastnums`
  ADD PRIMARY KEY (`TableName`);

--
-- Indexes for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD UNIQUE KEY `PrimaryKey` (`InventoryType`,`ItemID`);

--
-- Indexes for table `otheritems`
--
ALTER TABLE `otheritems`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `receiptitems`
--
ALTER TABLE `receiptitems`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `userauth`
--
ALTER TABLE `userauth`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `activationHash` (`activationHash`),
  ADD KEY `active` (`active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booklist`
--
ALTER TABLE `booklist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `classyears`
--
ALTER TABLE `classyears`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `genledger`
--
ALTER TABLE `genledger`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `itemlist`
--
ALTER TABLE `itemlist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `otheritems`
--
ALTER TABLE `otheritems`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `receiptitems`
--
ALTER TABLE `receiptitems`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `userauth`
--
ALTER TABLE `userauth`
  MODIFY `userid` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
