-- phpMyAdmin version 5.2.1
-- https://www.phpmyadmin.net/
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Dumping data for table `user_ans`

INSERT INTO `user_ans` (`ans_id`, `id_user`, `prob_id`, `ans`, `correct_ans`) VALUES
(5, '64541a58df4f9', 1, 'a', 'a'),
(7, '64541a58df4f9', 7, 'c', 'c'),
(8, '64541a58df4f9', 13, 'b', 'a'),
(9, '64541a58df4f9', 19, 'b', 'a'),
(10, '645456f6e7ceb', 3, 'c', 'c'),
(11, '645456f6e7ceb', 5, 'c', 'c'),
(12, '645456f6e7ceb', 16, 'b', 'b'),
(13, '645456f6e7ceb', 19, 'a', 'a');



COMMIT;