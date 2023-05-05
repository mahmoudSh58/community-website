-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2023 at 06:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- Dumping data for table `user`

INSERT INTO `user` (`id_user`, `role`, `privilege`, `first_name`, `second_name`, `last_name`, `email`, `password`, `governorate`, `city`, `college`, `level`, `birthday`, `gender`, `experience`, `state`, `blocked_by`, `accept_by`, `time`) VALUES
('645404bac1e07', 'head', 'owner', 'mohamed', 'mohamed', 'saleh', 'alrisha77777@gmail.com', '$2y$10$3lKP./bldfmwFQfGzIhE4ObmrhQPxyIwYFdJFfvj9LgpywdTFZkV.', 'kafrelsheikh', 'balteem', 'Faculty of Engineering', '3', '2001', 'male', 'middle', 1, NULL, NULL, '2023-05-04 19:17:14'),
('645404bac1e88', 'member', 'member', 'sameer', 'saber', 'elbanna', 'sameer@gmail.com', '5445fdsd5', 'damietta', 'faqous', 'faculty of engineering', '2', '2003', 'male', 'no skills', -1, NULL, NULL, '2023-05-04 20:47:22'),
('6454070febaa4', 'instructor', 'admin', 'ahmed', 'mohamed', 'salem', 'ahmed@gmail.com', '$2y$10$pqgWX/T0TUP07Yg4OXXvtencuqdCPhhbEy.1xoFLovhmVzOZTwn1q', 'kafrelsheikh', 'dsouq', 'Faculty of Engineering', '2', '2002', 'male', 'No skill', 1, NULL, NULL, '2023-05-04 19:27:11'),
('6454079ac4851', 'HR', 'admin', 'salem', 'mostafa', 'salem', 'salem@gmail.com', '$2y$10$PZDEwtIpGm0OQqZrvarFceKcreSPsiSlobBBWJmV9VA6qs7b.XyQS', 'cairo', 'aboud', 'Faculty of Computer and Information', '1', '2004', 'male', 'No skill', 1, NULL, NULL, '2023-05-04 19:29:30'),
('645409ea3f469', 'member', 'member', 'noor', 'mohamed', 'eisa', 'noor11@gmail.com', '$2y$10$uPXO9bQranS1Bh0hohgI2eUXElejYVJMbT4oQlk02zfoOApSNl8WC', 'alexandria', 'burj alarab', 'Faculty of Engineering', '2', '2002', 'male', 'beginner', 1, NULL, NULL, '2023-05-04 19:39:22'),
('64540aa8153bc', 'instructor', 'admin', 'noora', 'mohamed', 'elsayed', 'noora44@gmail.com', '$2y$10$DX7vxfyXx8NDI3jmQdTZU.9BbiCjEdF7aEVcT1XXt8qTZcNB3jns6', 'kafrelsheikh', 'alhamol', 'faculity of commerce', '2', '2003', 'female', 'No skill', 1, NULL, NULL, '2023-05-04 19:42:32'),
('64540b74563cf', 'member', 'member', 'shimaa', 'naser', 'saleh', 'shimaa44@gmail.com', '$2y$10$oKfuLvL3Rcyk12gr7ABS5.MrqsS.jn/Uysl61aVzBym.eutpC/OOO', 'beheira', 'markaz badr', 'Faculty of Computer and Information', '2', '2002', 'female', 'beginner', 1, NULL, NULL, '2023-05-04 19:45:56'),
('64540c1acc65e', 'member', 'member', 'magdy', 'mohamed', 'elsyed', 'magdy239@gmail.com', '$2y$10$8d2WabJqb8mh6zL7BWw/meHApvreGGjKJfbPqxM6Zr81Vxhix9.3G', 'al-gharbiyeh', 'mansoura', 'Faculty of Engineering', '3', '2001', 'male', 'middle', 1, NULL, NULL, '2023-05-04 19:48:42'),
('64540c7db9a88', 'member', 'member', 'karem', 'ahmed', 'halawa', 'karem24@gmail.com', '$2y$10$xy3BuZs3hSNBdGk0rBdLUu914fmSp9y06D/ElnMPkxyLmgjPkZpSS', 'kafrelsheikh', 'baltem', 'faculity of commerce', '4', '2001', 'male', 'beginner', 1, NULL, NULL, '2023-05-04 19:50:21'),
('64540d7c0659e', 'member', 'member', 'mahmoud', 'elsayed', 'elsahmy', 'mahmo43@gmail.com', '$2y$10$p7lG8w51YZkBI/QQ3.ABu.5QN4LLFtSWMzxOg2iA9cWuDeOurTrAu', 'al-gharbiyeh', 'almahlla', 'Faculty of Engineering', '0', '2004', 'male', 'No skill', 0, NULL, NULL, '2023-05-04 19:54:36'),
('64540e2f37d07', 'member', 'member', 'sameh', 'abdelsalam', 'eisa', 'sameh4@gmail.com', '$2y$10$xBuy0qtV6UTPhS0U80eTwO/5iau4htf8A62Tp0gCzzqozPSfGxSxq', 'damietta', 'faqoos', 'Faculty of Engineering', '2', '2002', 'male', 'beginner', 1, NULL, NULL, '2023-05-04 19:57:35'),
('64540e846ccdc', 'member', 'member', 'amera', 'ahmed', 'elbaanna', 'amera@gmail.com', '$2y$10$ijFKJj4MiGqfj5QGJsahb.BxxVYOVsTNbFmCP7qW1Y.MPM43nY4/S', 'kafrelsheikh', 'baltem', 'Faculty of Computer and Information', '2', '2002', 'female', 'beginner', 1, NULL, NULL, '2023-05-04 19:59:00'),
('64540ec2cb327', 'member', 'member', 'wafaa', 'mohamed', 'saleh', 'wafaa44@gmail.com', '$2y$10$/LzymIqgB1cUX.FHSKHoeOD1KNHKYiNLVtFSE0BSEFyT3cN4p7M9y', 'kafrelsheikh', 'baltem', 'Faculty of Engineering', '3', '2001', 'female', 'middle', -1, NULL, NULL, '2023-05-04 20:00:02'),
('64540ff05db31', 'member', 'member', 'omer', 'salem', 'salem', 'omer@gmail.com', '$2y$10$RoY4e3/lAlmpiI8B2HujVeYEmBB0t3/epgc22V4H1vDNfSo3PiFDS', 'kafrelsheikh', 'dsouq', 'Faculty of Engineering', '3', '2001', 'male', 'middle', 1, NULL, NULL, '2023-05-04 20:05:04'),
('64541a58df4f9', 'member', 'member', 'moneer', 'mohamed', 'salem', 'moneer@gmail.com', '$2y$10$H99px1FIBkFlZTps86X3u.vQsg4r45WcljHT14K7MDEP/THuybeLu', 'kafrelsheikh', 'sakha', 'Faculty of Engineering', '3', '2001', 'male', 'middle', 0, NULL, NULL, '2023-05-04 20:49:28'),
('64541b2f220f0', 'member', 'member', 'asmaa', 'mostafa', 'gaad', 'asmaa@gmail.com', '$2y$10$klhallz7H92dNsT0IhuuIuDwOiCK2Pd326CwBpF1WrpiKhA4SUdjK', 'beheira', 'rashed', 'Faculty of Computer and Information', '2', '2003', 'female', 'beginner', 1, NULL, NULL, '2023-05-04 20:53:03'),
('64541b97bc483', 'member', 'member', 'hamed', 'mohamed', 'hamed', 'hamed@gmail.com', '$2y$10$YMSjeB8vfItK4Syeczl1lOZB0rR/rKPkaSCS6QeLNtu4z0lNqLNqe', 'beheira', 'abo humos', 'Faculty of Engineering', '0', '2004', 'male', 'No skill', 0, NULL, NULL, '2023-05-04 20:54:47'),
('64541bed6a61c', 'member', 'member', 'adam', 'waled', 'ahmed', 'adam34@gmail.com', '$2y$10$PaX470c/yCLm4lRl8aBhp..HjM62tP0ZiHO84Vomv3kWdekzNgk0y', 'beheira', 'kom hamada', 'Faculty of Engineering', '1', '2003', 'male', 'beginner', 1, NULL, NULL, '2023-05-04 20:56:13'),
('64541c3c08313', 'member', 'member', 'salma', 'ahmed', 'esmaeil', 'salma@gmail.com', '$2y$10$pQL8KL/Tr/DQBZNCmqLEN.tPw6.ZL8vxnjW18ADzqbhryrH6bgBDi', 'damietta', 'damietta', 'Faculty of Engineering', '3', '2001', 'female', 'middle', 1, NULL, NULL, '2023-05-04 20:57:32'),
('645456f6e7ceb', 'member', 'member', 'elias', 'ahmed', 'saleh', 'elias123@gmail.com', '$2y$10$thYbU19l9hiyXOKhfEHMh.8HdrOti3naw5mT5z8hSCRVSU4oiK6R6', 'kafrelsheikh', 'burj alburulus', 'Faculty of Engineering', '2', '2002', 'male', 'middle', 0, NULL, NULL, '2023-05-05 01:08:06');

