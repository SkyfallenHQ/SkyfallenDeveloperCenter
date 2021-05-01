-- Skyfallen Developer Center
-- (C) 2021 Skyfallen
-- SQL Database Structure Installation Script
-- --------------------------------------------------------
--
-- Database: `sdc`
--

-- --------------------------------------------------------

--
-- Table structure for table `appmeta`
--

CREATE TABLE `appmeta` (
                           `appid` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                           `metaname` varchar(300) COLLATE utf8_turkish_ci NOT NULL,
                           `metaval` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
                        `ownerorg` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                        `appid` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                        `appname` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                        `appdescription` text COLLATE utf8_turkish_ci NOT NULL,
                        `appstatus` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
                        `appcreation` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
                        `identifier` varchar(300) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appservices`
--

CREATE TABLE `appservices` (
                               `appid` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                               `service` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                               `serviceid` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                               `servicesecret` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                               `provisionid` varchar(255) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organisationmembers`
--

CREATE TABLE `organisationmembers` (
                                       `userid` int(11) NOT NULL,
                                       `orgid` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                                       `perms` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                                       `adderid` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                                       `adddate` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organisations`
--

CREATE TABLE `organisations` (
                                 `ownerid` int(11) NOT NULL,
                                 `orgid` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                                 `orgname` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                                 `orgdescription` text COLLATE utf8_turkish_ci,
                                 `orgcreation` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
                                 `orgstatus` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
                                 `orgtype` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
                                 `identifier` varchar(200) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orgmeta`
--

CREATE TABLE `orgmeta` (
                           `orgid` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
                           `metaname` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
                           `metaval` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servicemeta`
--

CREATE TABLE `servicemeta` (
                               `provisionid` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                               `metaname` varchar(300) COLLATE utf8_turkish_ci NOT NULL,
                               `metaval` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
                            `setting` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
                            `value` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usermeta`
--

CREATE TABLE `usermeta` (
                            `userid` int(11) NOT NULL,
                            `metaname` varchar(300) COLLATE utf8_turkish_ci NOT NULL,
                            `metaval` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `id` int(11) NOT NULL,
                         `username` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
                         `email` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
                         `name` varchar(500) COLLATE utf8_turkish_ci DEFAULT NULL,
                         `surname` varchar(500) COLLATE utf8_turkish_ci DEFAULT NULL,
                         `createdate` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
                         `accountstatus` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
                         `bdate` varchar(20) COLLATE utf8_turkish_ci DEFAULT NULL,
                         `phone` varchar(20) COLLATE utf8_turkish_ci DEFAULT NULL,
                         `job` varchar(40) COLLATE utf8_turkish_ci DEFAULT NULL,
                         `country` varchar(40) COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applogs`
--

CREATE TABLE `applogservice` (
                         `logid` VARCHAR(255) NOT NULL AUTO_INCREMENT , 
                         `svcid` VARCHAR(500) NOT NULL ,
                         `time` VARCHAR(250) NOT NULL ,
                         `logtype` VARCHAR(500) NOT NULL ,
                         `logdata` TEXT NOT NULL , 
                         UNIQUE (`logid`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
    ADD UNIQUE KEY `appid` (`appid`),
    ADD UNIQUE KEY `identifier` (`identifier`);

--
-- Indexes for table `appservices`
--
ALTER TABLE `appservices`
    ADD UNIQUE KEY `provisionid` (`provisionid`);

--
-- Indexes for table `organisations`
--
ALTER TABLE `organisations`
    ADD UNIQUE KEY `orgid` (`orgid`),
    ADD UNIQUE KEY `identifier` (`identifier`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
    ADD UNIQUE KEY `setting` (`setting`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD UNIQUE KEY `id` (`id`),
    ADD UNIQUE KEY `username` (`username`),
    CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
