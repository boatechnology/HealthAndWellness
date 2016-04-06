CREATE DATABASE  IF NOT EXISTS `hw`;
USE `hw`;

-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `idactivities` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `points` int(11) DEFAULT NULL,
  `factor` varchar(45) DEFAULT NULL,
  `class` int(11) NOT NULL,
  `isvisible` int(11) DEFAULT '1',
  `onequantitylimit` int(11) DEFAULT '0',
  PRIMARY KEY (`idactivities`),
  KEY `activityclass_idx` (`class`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=latin1;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses` (
  `idstatus` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `isvisible` int(11) DEFAULT '1',
  PRIMARY KEY (`idstatus`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `idusers` int(11) NOT NULL AUTO_INCREMENT,
  `cn` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `hwnumber` int(11) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `sid` varchar(150) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `isadmin` int(11) DEFAULT NULL,
  `ispublic` int(11) DEFAULT '1',
  PRIMARY KEY (`idusers`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;

--
-- Table structure for table `activity_classes`
--

DROP TABLE IF EXISTS `activity_classes`;
CREATE TABLE `activity_classes` (
  `idactivity_classes` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `isvisible` int(11) DEFAULT '1',
  PRIMARY KEY (`idactivity_classes`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE `activity_log` (
  `idactivity_log` int(11) NOT NULL AUTO_INCREMENT,
  `idusers` int(11) NOT NULL,
  `idactivities` int(11) NOT NULL,
  `date` date NOT NULL,
  `comments` text,
  `points` int(11) DEFAULT NULL,
  `quantity` decimal(11,1) NOT NULL,
  `approval` int(11) DEFAULT '1',
  `activity_points` int(11) DEFAULT NULL,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idactivity_log`),
  KEY `activityuser_idx` (`idusers`),
  KEY `activitylog_idx` (`idactivities`),
  KEY `activitystatus_idx` (`approval`),
  KEY `activitydate_idx` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=59949 DEFAULT CHARSET=latin1;

--
-- Table structure for table `activity_statuses`
--

DROP TABLE IF EXISTS `activity_statuses`;
CREATE TABLE `activity_statuses` (
  `idactivity_statuses` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `isvisible` int(11) DEFAULT '1',
  PRIMARY KEY (`idactivity_statuses`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `idcontent` int(11) NOT NULL AUTO_INCREMENT,
  `html` text,
  `section` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idcontent`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Table structure for table `goals`
--

DROP TABLE IF EXISTS `goals`;
CREATE TABLE `goals` (
  `idgoals` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `description` text,
  `progress` text,
  `prove` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `public` int(11) DEFAULT NULL,
  `anonymous` int(11) DEFAULT NULL,
  `idusers` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `proof` text,
  `points` int(11) DEFAULT '0',
  `benefit` text,
  `tier1` text,
  `tier2` text,
  `tier3` text,
  `notes` text,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `filename` text,
  `t1points` int(11) DEFAULT '0',
  `t2points` int(11) DEFAULT '0',
  `t3points` int(11) DEFAULT '0',
  PRIMARY KEY (`idgoals`),
  KEY `idusers_idx` (`idusers`),
  KEY `enddate_idx` (`end_date`),
  KEY `goalpublic` (`public`),
  KEY `goalstatus_idx` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=416 DEFAULT CHARSET=latin1;


--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Routines for database
--

DELIMITER ;;
CREATE PROCEDURE `consistency`(IN goal INT)
BEGIN
declare done INT default FALSE;
declare my_idusers INT;
declare my_date DATE DEFAULT CURDATE();

declare curl CURSOR for select idusers from tmp group by idusers;

declare CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

drop temporary table if exists results;
create temporary table if not exists results (
 `idusers` INT NOT NULL,
 `hwnumber` varchar(25),
 `cn` varchar(25),
 `total_points` INT,
 `consistency_total` INT,
 `consistency_score` DECIMAL(20,5)
);

drop temporary table if exists tmp;
create temporary table tmp engine=memory select a.idusers, u1.hwnumber, u1.cn, sum(a.points) as points, month(a.date) as month
from users u1
left join activity_log a on a.idusers = u1.idusers
where u1.ispublic = 1
AND YEAR(a.date) = YEAR(my_date)
group by a.idusers, month(a.date)
union
SELECT u2.idusers, u2.hwnumber, u2.cn, sum(g.points), month(g.end_date) as month
from users u2
left join goals g on g.idusers=u2.idusers
where g.status = 3
AND u2.ispublic = 1
and YEAR(g.end_date) = YEAR(my_date)
group by g.idusers, month(g.end_date)
order by idusers, month;

drop temporary table if exists tmp2;
create temporary table tmp2 engine=memory select idusers, hwnumber, cn, sum(points) as points , month,
if(month = 1 && '2015' = YEAR(my_date), if(sum(points) > 250,1,0), if(sum(points) > goal,1,0)) as consistency
from tmp
group by idusers, month
order by idusers, month;

OPEN curl;

the_loop: LOOP
 fetch curl into my_idusers;
 if done then
   LEAVE the_loop;
 END IF;
 insert into results select idusers, hwnumber, cn, sum(points), sum(consistency), (sum(consistency)/month(SUBDATE(CURDATE(), INTERVAL 1 MONTH))) as consistency_total from tmp2 where idusers = my_idusers;
END LOOP the_loop;

select * from results
ORDER BY consistency_score desc, total_points desc;

close curl;
drop temporary table if exists tmp;
drop temporary table if exists tmp2;
drop temporary table if exists results;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE `monthly_total`(IN my_iduser INT)
BEGIN

drop temporary table if exists tmp;
create temporary table tmp engine=memory select a.idusers, u1.hwnumber, u1.cn, sum(a.points) as points, month(a.date) as month, u1.ispublic as public
from users u1
left join activity_log a on a.idusers = u1.idusers
AND YEAR(a.date) = YEAR(CURDATE())
group by a.idusers, month(a.date)
union
SELECT u2.idusers, u2.hwnumber, u2.cn, sum(g.points), month(g.end_date) as month, u2.ispublic as public
from users u2
left join goals g on g.idusers=u2.idusers
where g.status = 3
and YEAR(g.end_date) = YEAR(CURDATE())
group by g.idusers, month(g.end_date)
order by idusers, month;

IF my_iduser = NULL THEN SET my_iduser = '%'; END IF;
IF my_iduser = 0 THEN
 select idusers, hwnumber, cn, sum(points) as points, month, public
 from tmp
 group by idusers, month
 order by idusers, month;
else
 select idusers, hwnumber, cn, sum(points) as points, month, public
 from tmp
 WHERE idusers = my_iduser
 group by month
 order by idusers, month;
END IF;

drop temporary table if exists tmp;
END ;;
DELIMITER ;

