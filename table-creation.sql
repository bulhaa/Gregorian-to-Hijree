--
-- Table structure for table `hijree_years`
--

CREATE TABLE `hijree_years` (
  `year` int(11) NOT NULL,
  `year_start` date NOT NULL,
  `year_end` date NOT NULL,
  `days_in_month_1` int(11) NOT NULL,
  `days_in_month_2` int(11) NOT NULL,
  `days_in_month_3` int(11) NOT NULL,
  `days_in_month_4` int(11) NOT NULL,
  `days_in_month_5` int(11) NOT NULL,
  `days_in_month_6` int(11) NOT NULL,
  `days_in_month_7` int(11) NOT NULL,
  `days_in_month_8` int(11) NOT NULL,
  `days_in_month_9` int(11) NOT NULL,
  `days_in_month_10` int(11) NOT NULL,
  `days_in_month_11` int(11) NOT NULL,
  `days_in_month_12` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
