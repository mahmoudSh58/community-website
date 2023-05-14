-- Database: `community_website_db`
-- phpMyAdmin  version 5.2.1
-- https://www.phpmyadmin.net/
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
	

-- TODO : add added_by   to problems table 
-- TODO : add user_name  to user table (login by it  not very imp todo)
-- TODO : add user_name  to user_ans atble same as prev todo
-- TODO : add source_link colm in DB event table


-- Table structure for table `user`
CREATE TABLE  `user` (
	`id_user` varchar(100) PRIMARY KEY ,
	`role` varchar(100)  DEFAULT 'member', -- member  , HR   , head , vice , instructor 
	`privilege` varchar(100) NOT NULL DEFAULT 'member', -- owner > admin > member
	`first_name` varchar(100) NOT NULL,
	`second_name` varchar(100) NOT NULL,
	`last_name` varchar(100) NOT NULL,
	`email` varchar(200) NOT NULL,
	`password` varchar(200) NOT NULL,
	`governorate` varchar(200) NOT NULL,
	`city` varchar(200) NOT NULL,
	`college` varchar(200) NOT NULL,
	`level` varchar(200) NOT NULL,
	`birthday` year(4) NOT NULL,
	`gender` varchar(10) NOT NULL,
	`experience` varchar(50) NOT NULL,
	`state`  int(11) NOT NULL DEFAULT 0, -- 1accepted ,  0pending , -1blocked 
	`blocked_by` varchar(100) ,  
	`accept_by` varchar(100) , 
	`time` timestamp NOT NULL DEFAULT current_timestamp()
	
	
)  ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;


-- Table structure for table `event`
CREATE TABLE `event` (
	`id_event` int(11) PRIMARY KEY  AUTO_INCREMENT,
	`event_type` varchar(50) NOT NULL, -- 2contests , 3courses ,  1conferences
	`event_name` varchar(400) NOT NULL, 
	`from_date` date NOT NULL,
	`to_date` date NOT NULL,
	`start_date` datetime NOT NULL,
	`end_date` datetime NOT NULL,
	`time_create` timestamp NOT NULL DEFAULT current_timestamp(),
	`summary` text NOT NULL,
	`description` text NOT NULL,
	`num_lecture` int(11) , -- not needed for contests 
	`content` text , -- not needed for contest
	`qualification` text  , -- if course only 
	`experience` text  , -- if contest  = Beginner , Intermediate(middle) , Expert
	`made_by` varchar(100) , 
	`edit_by` varchar(100) , 
	`img_url` varchar(400) NOT NULL DEFAULT '../image/events/default.jpg'
	
	
)  ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;



-- Table structure for table `practice`
CREATE TABLE  `practice` (
	`id_event` int(11) NOT NULL , 
	`id_user` varchar(100) NOT NULL, 
	`time` timestamp NOT NULL DEFAULT current_timestamp(),

	PRIMARY KEY (id_user , id_event)
)  ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;



-- Table structure for table `problems`
CREATE  TABLE  `problems` (
 `prob_id` INT(11) PRIMARY KEY  AUTO_INCREMENT , 
 `type` VARCHAR(50)  NOT NULL  , -- general cs , algorithm , data strucure , oop , other
 `difficulty` INT(11) NOT NULL , -- 1 , 2 , 3
 `statement` TEXT NOT NULL , -- the statement  + mcq 
 `ans` varchar(11) NOT NULL  -- ans a) .. b).. c).. 
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;



-- Table structure for table `user_ans`
CREATE TABLE `user_ans` (
	`ans_id` INT(11) PRIMARY KEY AUTO_INCREMENT ,
	`id_user` varchar(100) NOT NULL, 
	`prob_id` INT(11), 
	`ans` varchar(11) NOT NULL  ,
 	`correct_ans` varchar(11) NOT NULL  -- ans a , b , c
	
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;


COMMIT;