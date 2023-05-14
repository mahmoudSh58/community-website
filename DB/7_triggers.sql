-- phpMyAdmin  version 5.2.1
-- https://www.phpmyadmin.net/
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

START TRANSACTION;

--  handle event table if user deleted in user table

CREATE TRIGGER `set_madeBy_str_DELETED_if_ref_user_deleted`
BEFORE DELETE ON `user`
FOR EACH ROW
  UPDATE `event` SET `made_by` = 'USER_DELETED' WHERE `made_by` = OLD.`id_user`;



--  handle practice table if event deleted in event table

CREATE TRIGGER `set_idEvent_0_if_ref_event_deleted`
BEFORE DELETE ON `event`
FOR EACH ROW
  UPDATE `practice` SET `id_event` = 0 WHERE `id_event` = OLD.`id_event`;



--  handle practice table if user is deleted in user table

CREATE TRIGGER `set_practice_idUser_str_DELETED_if_ref_user_deleted`
BEFORE DELETE ON `user`
FOR EACH ROW
  UPDATE `practice` SET `id_user` = 'USER_DELETED' WHERE `id_user` = OLD.`id_user`;



--  handle user_ans table if user is deleted in user table

CREATE TRIGGER `set_userAns_idUser_str_DELETED_if_ref_user_deleted`
BEFORE DELETE ON `user`
FOR EACH ROW
  UPDATE `user_ans` SET `id_user` = 'USER_DELETED' WHERE `id_user` = OLD.`id_user`;



--  handle user_ans table if problem is deleted in problems table

CREATE TRIGGER `set_probId_-1_if_ref_problems_deleted`
BEFORE DELETE ON `problems`
FOR EACH ROW
  UPDATE `user_ans` SET `prob_id` = -1 WHERE `prob_id` = OLD.`prob_id`;


COMMIT;

