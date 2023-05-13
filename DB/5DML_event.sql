-- phpMyAdmin version 5.2.1
-- https://www.phpmyadmin.net/
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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

-- INSERT INTO `event` (
--     `event_type`,
--     `event_name`,
--     `from_date`,
--     `to_date`,
--     `start_date`,
--     `end_date`,
--     `summary`,
--     `description`,
--     `num_lecture`,
--     `content`,
--     `qualification`,
-- 	 `experience`,
--     `made_by`,
--     `img_url`
-- )
-- VALUES (
--     'conference',
--     'Artificial Intelligence Conference',
--     '2023-09-15',
--     '2023-09-17',
--     '2023-09-20',
--     '2023-09-21',
--     'Join us for the latest advancements in artificial intelligence and machine learning technologies.',
--     'The Artificial Intelligence Conference brings together experts in the field to discuss the latest research, techniques, and applications of AI and machine learning.',
--     NULL,
--     NULL,
--     NULL,
--     '645404bac1e07',
--     '../image/events/default.jpg'
-- ),
-- (
--     'contest',
--     'Code Jam - Intermediate Level',
--     '2023-07-01',
--     '2023-07-03',
--     '2023-07-05',
--     '2023-07-06',
--     'Put your programming skills to the test in our Code Jam contest - intermediate level.',
--     'Compete against other programmers to solve challenging algorithmic problems and win prizes!',
-- 	 NULL,
--     NULL,
--     NULL,
--     'Middle',
--     '645404bac1e07',
--     '../image/events/default.jpg'
-- ),
-- (
--     'course',
--     'Web Development Bootcamp',
--     '2023-06-15',
--     '2023-06-30',
--     '2023-07-01',
--     '2023-08-31',
--     'Learn how to build dynamic web applications from scratch in our comprehensive web development bootcamp.',
--     'Our web development bootcamp covers everything from HTML and CSS to advanced JavaScript frameworks like React and Angular.',
--     20,
--     'HTML, CSS, JavaScript, React, Angular, Node.js, Express.js, databases, server-side scripting',
--     'Basic CS Knowledge',
--     NULL,
--     '6454079ac4851',
--     '../image/events/default.jpg'
-- ),
-- (
--     'contest',
--     'HackerRank Challenge - Advanced Level',
--     '2023-10-01',
--     '2023-10-03',
--     '2023-10-05',
--     '2023-10-06',
--     'Test your programming skills in our advanced-level HackerRank challenge.',
--     'Solve complex algorithmic problems and compete against other programmers for the top spot on the leaderboard.',
--     NULL,
--     'Dynamic programming, graph algorithms, divide-and-conquer, string algorithms, data structures, artificial intelligence',
--     NULL,
--     'Expert',
--     '6454079ac4851',
--     '../image/events/default.jpg'
-- ),
-- (
--     'course',
--     'Data Science Masterclass',
--     '2023-11-01',
--     '2023-11-30',
--     '2023-12-01',
--     '2024-02-28',
--     'Become a master of data science with our comprehensive masterclass.',
--     'Our data science masterclass covers everything from statistics and data analysis to machine learning and deep learning.',
--     30,
--     'Statistics, data analysis, machine learning, deep learning, Python, data visualization, databases',
--     'OOP , Programming 101 , linear algebra',
--     NULL,
--     '6454079ac4851645404bac1e07',
--     '../image/events/default.jpg'
-- );
INSERT INTO `event` (
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
    `experience`,
    `made_by`,
    `img_url`
)
VALUES (
    'conference',
    'Data Science Summit',
    '2023-11-15',
    '2023-11-17',
    '2023-11-20',
    '2023-11-21',
    'Join us for the latest trends and innovations in data science and analytics.',
    'The Data Science Summit brings together experts in the field to discuss the latest research, techniques, and applications of data science and analytics.',
    NULL,
    'Data visualization, machine learning, deep learning, natural language processing, big data, cloud computing',
    NULL,
    NULL,
    '645404bac1e07',
    '../image/events/default.jpg'
),
(
    'contest',
    'Codeforces Round - Advanced Level',
    '2023-09-01',
    '2023-09-03',
    '2023-09-05',
    '2023-09-06',
    'Put your programming skills to the test in our Codeforces contest - advanced level.',
    'Compete against other programmers to solve challenging algorithmic problems and win prizes!',
    NULL,
    NULL,
    NULL,
    'Expert',
    '645404bac1e07',
    '../image/events/default.jpg'
),
(
    'course',
    'Java Programming Masterclass',
    '2022-07-15',
    '2022-07-30',
    '2022-08-01',
    '2022-09-30',
    'Become a master of Java programming with our comprehensive masterclass.',
    'Our Java programming masterclass covers everything from syntax and basic concepts to advanced topics like multithreading and GUI development.',
    20,
    'Java syntax, object-oriented programming, data structures, algorithms, multithreading, GUI development',
    'CS 101',
    NULL,
    '645404bac1e07',
    '../image/events/default.jpg'
),
(
    'contest',
    'LeetCode Challenge - Easy Level',
    '2023-12-01',
    '2023-12-03',
    '2023-12-05',
    '2023-12-06',
    'Test your programming skills in our easy-level LeetCode challenge.',
    'Solve algorithmic problems and compete against other programmers for the top spot on the leaderboard.',
    NULL,
    NULL,
    NULL,
    'Beginner',
    '6454079ac4851',
    '../image/events/default.jpg'
),
(
    'course',
    'Python for Data Science',
    '2022-10-01',
    '2022-10-31',
    '2022-11-01',
    '2022-12-31',
    'Learn Python programming and data science skills in our comprehensive course.',
    'Our Python for Data Science course covers everything from Python basics to advanced data analysis techniques using libraries like Pandas and Numpy.',
    30,
    'Python syntax, data structures, algorithms, Pandas, Numpy, data visualization, machine learning',
    'Python 101 , linear algebra ',
    NULL,
    '6454079ac4851',
    '../image/events/default.jpg'
);

INSERT INTO `event` (
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
    `experience`,
    `made_by`,
    `img_url`
)
VALUES (
    'conference',
    'Artificial Intelligence Summit',
    '2023-05-01',
    '2023-05-03',
    '2023-05-05',
    '2023-05-07',
    'Join us for the latest trends and innovations in artificial intelligence.',
    'Join us for the latest trends and innovations in artificial intelligence.',
    NULL,
    'The Artificial Intelligence Summit brings together experts in the field to discuss the latest research, techniques, and applications of AI.',
    NULL,
    NULL,
    '6454079ac4851',
    '../image/events/default.jpg'
),
(
    'conference',
    'Web Development Workshop',
    '2023-06-01',
    '2023-06-03',
    '2023-06-05',
    '2023-06-07',
    'Learn the latest web development techniques and tools in our hands-on workshop.',
    'Our web development workshop covers everything from HTML and CSS basics to advanced topics like responsive design and JavaScript frameworks.',
    NULL,
    'HTML, CSS, JavaScript, jQuery, Bootstrap, React',
    NULL,
    NULL,
    '6454079ac4851',
    '../image/events/default.jpg'
),
(
    'contest',
    'Blockchain Hackathon',
    '2023-07-01',
    '2023-07-03',
    '2023-07-05',
    '2023-07-07',
    'Join our blockchain hackathon and build innovative decentralized applications.',
    'Compete against other developers to create the best blockchain-based solutions using your skills and creativity.',
    NULL,
    NULL,
    NULL,
    'Expert',
    '6454079ac4851',
    '../image/events/default.jpg'
),
(
    'course',
    'iOS Development Course',
    '2023-08-01',
    '2023-08-31',
    '2023-09-01',
    '2023-10-31',
    'Learn how to develop iOS apps from scratch in our comprehensive course.',
    'Our iOS development course covers everything from Swift basics to advanced topics like Core Data and UIKit.',
    20,
    'Swift, Xcode, UIKit, Core Data, Firebase, App Store submission',
    'CS 101 , Programming 101',
    NULL,
    '6454079ac4851',
    '../image/events/default.jpg'
);

COMMIT;
