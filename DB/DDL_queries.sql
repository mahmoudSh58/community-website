-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Host: 127.0.0.1
-- Generation Time: May 02, 2023 at 05:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
	



-- Database: `community_website_db`

-- Table structure for table `user`


CREATE TABLE `user` (
	`id_user` varchar(100) PRIMARY KEY NOT NULL,
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
	`state`  int(11) NOT NULL DEFAULT 0, -- 1 > accepted , 0 >  pending , -1 > blocked 
	`blocked_by` varchar(100) ,  -- add on delete statement
	`accept_by` varchar(100) NOT NULL, -- add on delete statement
	`time` timestamp NOT NULL DEFAULT current_timestamp(),
	FOREIGN KEY (accept_by)  REFERENCES user(id_user),
	FOREIGN KEY (blocked_by) REFERENCES user(id_user)
	
)  ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- Table structure for table `event`
CREATE TABLE `event` (
	`id_event` int(11) PRIMARY KEY  AUTO_INCREMENT,
	`event_type` varchar(50) NOT NULL, -- 2contest , 3course ,  1confrence
	`event_name` varchar(400) NOT NULL, 
	`from_date` date NOT NULL,
	`to_date` date NOT NULL,
	`start_date` datetime NOT NULL,
	`time_create` timestamp NOT NULL DEFAULT current_timestamp(),
	`summary` text NOT NULL,
	`description` text NOT NULL,
	`end_date` datetime NOT NULL,
	`num_lecture` int(11) , -- not needed for contests
	`content` text , -- not needed for conference
	`qualification` text  , -- if course only
	`experience` text  , -- if contest
	`made_by` varchar(100) NOT NULL, -- add on delete statement
	`edit_by` varchar(100) , -- add on update statement 
	`img_url` varchar(400) NOT NULL DEFAULT '../image/events/default.jpg',
	
	FOREIGN KEY (made_by) REFERENCES user(id_user),
	FOREIGN KEY (edit_by) REFERENCES user(id_user)
)  ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;


-- Table structure for table `practice`

CREATE TABLE `practice` (
	`id_event` int(11) NOT NULL , -- add on delete statement
	`id_user` varchar(100) NOT NULL, -- add on delete statement
	`time` timestamp NOT NULL DEFAULT current_timestamp(),

	FOREIGN KEY (id_event) REFERENCES event(id_event),
	FOREIGN KEY (id_user) REFERENCES user(id_user),
	PRIMARY KEY (id_user , id_event)
)  ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;



-- Table structure for table `problems`

CREATE  TABLE `problems` (
 `prob_id` INT(11) PRIMARY KEY  AUTO_INCREMENT , 
 `type` VARCHAR(50)  NOT NULL  , -- general cs , algorithm , data strucure , oop , other
 `difficulty` INT(11) NOT NULL , -- 1 , 2 , 3
 `statement` TEXT NOT NULL , -- the statement  + mcq 
 `ans` INT(11) NOT NULL  -- ans 1) .. 2).. 3)..
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- Table structure for table `user_ans`


CREATE  TABLE `user_ans` (
	`ans_id` INT(11) PRIMARY KEY AUTO_INCREMENT ,
	`id_user` varchar(100) NOT NULL, 
	`prob_id` INT(11) NOT NULL, 
	`ans` INT(11) NOT NULL  ,
	FOREIGN KEY (id_user) REFERENCES user(id_user) ,
	FOREIGN KEY (prob_id) REFERENCES problems(prob_id) 
	
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;


COMMIT;

