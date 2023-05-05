-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Host: 127.0.0.1
-- Generation Time: May 02, 2023 at 05:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4
-- FILL event table
SET
	SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
	time_zone = "+00:00";

-- FILL event table
INSERT INTO
	`event` (
		`event_type`,
		`event_name`,
		`from_date`,
		`to_date`,
		`start_date`,
		`end_date`,
		`summary`,
		`description`,
		`num_lecture`,
		`content`,
		`qualification`,
		`made_by`,
		`img_url`
	)
VALUES
	(
		'course',
		'Problem Solving - level 0',
		'2023-04-01',
		'2023-04-11',
		'2023-04-16',
		'2023-05-16',
		'Programming principles and concepts in computer science will be explained to beginners.',
		'Programming principles and concepts in computer science will be explained to beginners.',
		4,
		'Binary system - Basics of computer architecture - How to compile code? - What is IDE & vritual judge?',
		'Don\'t need',
		'645404bac1e07',
		'../image/events/pslv0.png'
	),
	(
		'course',
		'Problem Solving - level 1',
		'2023-05-26',
		'2023-06-16',
		'2023-06-21',
		'2023-08-21',
		'Ready to start your real programming  & problem solving journey? Our level 1  C++ course is the next  after CS basics - unleash your full coding potential!',
		'Ready to start your real programming  & problem solving journey? Our level 1  C++ course is the next  after CS basics - unleash your full coding potential!',
		8,
		'Datatyps - Variables- Operations - Conditions - Loops - Arrays - Strings - Functions - Recursion - Bitmasking ',
		'Succeed in (Problen Solving-level 0)',
		'645404bac1e07',
		'../image/events/pslv1.png'
	),
	(
		'course',
		'Problem Solving - level 2',
		'2023-10-01',
		'2023-10-11',
		'2023-10-16',
		'2023-12-16',
		'Time to level up your problem-solving skills . Our course at level 2 will help you master complex algorithms, data structures, and advanced programming techniques - become a true coding ninja!',
		'Time to level up your problem-solving skills . Our course at level 2 will help you master complex algorithms, data structures, and advanced programming techniques - become a true coding ninja!',
		8,
		'STL - Search algorithms - sort algorithms - Gready & two Pointer - Match ',
		'Succeed in (Problen Solving-level 1)',
		'645404bac1e07',
		'../image/events/pslv2.png'
	);

INSERT INTO
	`event` (
		`event_type`,
		`event_name`,
		`from_date`,
		`to_date`,
		`start_date`,
		`end_date`,
		`summary`,
		`description`,
		`Experience`,
		`made_by`,
		`img_url`
	)
VALUES
	(
		'contest',
		'Community Contest - Easy ',
		'2023-08-21',
		'2023-08-25',
		'2023-08-26',
		'2023-08-26',
		'Test your programming skills in a friendly
		and supportive environment with our level 1 programming - ps contest - First solve the problem.Then,
		Write the code !',
		' Test your programming skills in a friendly
		and supportive environment with our level 1 programming - ps contest - First solve the problem.Then,
		Write the code !',
		'Beginner',
		'6454079ac4851',
		'../image/events/contest.jpg'
	);

-- ----------------------------------------------------
INSERT INTO
	`event` (
		`event_type`,
		`event_name`,
		`from_date`,
		`to_date`,
		`start_date`,
		`end_date`,
		`summary`,
		`description`,
		`content`,
		`made_by`,
		`img_url`
	)
VALUES
	(
		'conference',
		'Developer Tech Week',
		'2023-07-07',
		'2023-07-10',
		'2023-07-11',
		'2023-07-17',
		'7 days of innovation, learning, and networking at Developer Tech Week - join us to connect with experts, explore new tech, and take your skills to the next level!',
		'7 days of innovation, learning, and networking at Developer Tech Week - join us to connect with experts, explore new tech, and take your skills to the next level!',
		'Day 1 - Keynote speeches and opening ceremony<br>Day 2 - Workshops and hands-on training sessions<br>Day 3 - Panel discussions and Q&A sessions with industry experts<br>Day 4 - Hackathon or coding competition<br>Day 5 - Product demos and exhibits from leading tech companies<br>Day 6 - Career fair and networking events with recruiters and hiring managers<br>Day 7 - Closing ceremony and wrap-up sessions, featuring guest speakers and special announcements<br>',
		'6454079ac4851',
		'../image/events/conference1.png'
	);

COMMIT;
