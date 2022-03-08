-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2022 at 06:02 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `facebook`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `acceptFriendRequest` (IN `friend_id` INT(11))  UPDATE friends f
SET f.IsAccepted = 1, f.DateAccepted = NOW()
WHERE f.FriendId = friend_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteFriendRequest` (IN `friend_id` INT(11))  DELETE FROM friends WHERE FriendId = friend_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteReply` (IN `reply_id` INT(11))  DELETE FROM replies
WHERE ReplyId = reply_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllPosts` ()  BEGIN
	SELECT * FROM view_posts;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSinglePost` (IN `post_id` INT(11))  BEGIN
	SELECT * FROM view_posts WHERE PostId = post_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSingleUser` (IN `id` INT)  BEGIN
	SELECT * FROM users u WHERE u.UserId = id
    LIMIT 0, 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUsers` ()  BEGIN
	SELECT * FROM users;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insComment` (IN `comment_body` VARCHAR(255), IN `user_id` INT(11), IN `post_id` INT(11))  INSERT comments (CommentBody, UserId, PostId)
VALUES (comment_body, user_id, post_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertFriend` (IN `sender_id` INT(11), IN `receiver_id` INT(11))  INSERT INTO  friends (SenderId, ReceiverId)
VALUES (sender_id, receiver_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPost` (IN `post_body` VARCHAR(255), IN `user_id` INT(11))  INSERT INTO posts (Body, UserId)
VALUES (post_body, user_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUser` (IN `first_name` VARCHAR(150), IN `last_name` VARCHAR(200), IN `email` VARCHAR(255), IN `password` VARCHAR(255))  INSERT INTO users (FirstName, LastName, Email, Password)
VALUES (first_name, last_name, email, password)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insReply` (IN `reply_body` VARCHAR(255), IN `user_id` INT(11), IN `comment_id` INT(11))  INSERT INTO replies (ReplyBody, UserId, CommentId)
VALUES (reply_body, user_id, comment_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateComment` (IN `comment_id` INT(11), IN `comment_body` VARCHAR(255))  UPDATE comments
SET CommentBody = comment_body
WHERE CommentId = comment_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePost` (IN `post_id` INT(11), IN `body` VARCHAR(255), IN `user_id` INT(11))  UPDATE posts
SET Body = body, UserId = user_id
WHERE PostId = post_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateReply` (IN `reply_body` VARCHAR(255), IN `reply_id` INT(11))  UPDATE replies
SET ReplyBody = reply_body
WHERE ReplyId = reply_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUser` (IN `first_name` VARCHAR(150), IN `last_name` VARCHAR(200), IN `email` VARCHAR(255), IN `is_admin` BIT(1), IN `user_id` INT(11))  BEGIN
    UPDATE users
    SET FirstName = first_name, LastName = last_name, Email = email, IsAdmin = is_admin
    WHERE UserId = user_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentId` int(11) NOT NULL,
  `CommentBody` varchar(255) NOT NULL,
  `DatePosted` date NOT NULL DEFAULT current_timestamp(),
  `PostId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `FriendId` int(11) NOT NULL,
  `SenderId` int(11) NOT NULL,
  `ReceiverId` int(11) NOT NULL,
  `DateAccepted` date DEFAULT NULL,
  `IsAccepted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostId` int(11) NOT NULL,
  `Body` varchar(255) NOT NULL,
  `DatePosted` date NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(200) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `IsAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_comments`
-- (See below for the actual view)
--
CREATE TABLE `view_comments` (
`CommentId` int(11)
,`CommentBody` varchar(255)
,`DatePosted` date
,`PostId` int(11)
,`UserId` int(11)
,`FirstName` varchar(150)
,`LastName` varchar(200)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_friends`
-- (See below for the actual view)
--
CREATE TABLE `view_friends` (
`FriendId` int(11)
,`SenderId` int(11)
,`SenderFirstName` varchar(150)
,`SenderLastName` varchar(200)
,`ReceiverId` int(11)
,`ReceiverFirstName` varchar(150)
,`ReceiverLastName` varchar(200)
,`IsAccepted` bit(1)
,`DateAccepted` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_posts`
-- (See below for the actual view)
--
CREATE TABLE `view_posts` (
`PostId` int(11)
,`Body` varchar(255)
,`DatePosted` date
,`UserId` int(11)
,`FirstName` varchar(150)
,`LastName` varchar(200)
);

-- --------------------------------------------------------

--
-- Structure for view `view_comments`
--
DROP TABLE IF EXISTS `view_comments`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_comments`  AS SELECT `c`.`CommentId` AS `CommentId`, `c`.`CommentBody` AS `CommentBody`, `c`.`DatePosted` AS `DatePosted`, `c`.`PostId` AS `PostId`, `u`.`UserId` AS `UserId`, `u`.`FirstName` AS `FirstName`, `u`.`LastName` AS `LastName` FROM (`comments` `c` join `users` `u` on(`c`.`UserId` = `u`.`UserId`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_friends`
--
DROP TABLE IF EXISTS `view_friends`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_friends`  AS SELECT `f`.`FriendId` AS `FriendId`, `f`.`SenderId` AS `SenderId`, `s`.`FirstName` AS `SenderFirstName`, `s`.`LastName` AS `SenderLastName`, `f`.`ReceiverId` AS `ReceiverId`, `r`.`FirstName` AS `ReceiverFirstName`, `r`.`LastName` AS `ReceiverLastName`, `f`.`IsAccepted` AS `IsAccepted`, `f`.`DateAccepted` AS `DateAccepted` FROM ((`friends` `f` join `users` `r` on(`f`.`ReceiverId` = `r`.`UserId`)) join `users` `s` on(`s`.`UserId` = `f`.`SenderId`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_posts`
--
DROP TABLE IF EXISTS `view_posts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_posts`  AS SELECT `p`.`PostId` AS `PostId`, `p`.`Body` AS `Body`, `p`.`DatePosted` AS `DatePosted`, `u`.`UserId` AS `UserId`, `u`.`FirstName` AS `FirstName`, `u`.`LastName` AS `LastName` FROM (`posts` `p` join `users` `u` on(`u`.`UserId` = `p`.`UserId`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentId`),
  ADD KEY `PostId` (`PostId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`FriendId`),
  ADD KEY `SenderId` (`SenderId`),
  ADD KEY `ReceiverId` (`ReceiverId`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `FriendId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`PostId`) REFERENCES `posts` (`PostId`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`SenderId`) REFERENCES `users` (`UserId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`ReceiverId`) REFERENCES `users` (`UserId`) ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
