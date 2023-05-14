-- phpMyAdmin version 5.2.1
-- https://www.phpmyadmin.net/
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

START TRANSACTION;


-- table user

ALTER TABLE `user`
ADD FOREIGN KEY (`blocked_by`) REFERENCES `user`(`id_user`)ON DELETE SET NULL;
ALTER TABLE `user`
ADD FOREIGN KEY (`accept_by`) REFERENCES `user`(`id_user`)ON DELETE SET NULL;




-- table event

ALTER TABLE `event`
ADD FOREIGN KEY (`made_by`) REFERENCES `user`(`id_user`)ON DELETE SET NULL ;
ALTER TABLE `event`
ADD FOREIGN KEY (`edit_by`) REFERENCES `user`(`id_user`)ON DELETE SET NULL ;




-- table practice

ALTER TABLE `practice`
ADD FOREIGN KEY (`id_event`) REFERENCES `event`(`id_event`)ON UPDATE CASCADE;
ALTER TABLE `practice`
ADD FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`)ON DELETE CASCADE ON UPDATE CASCADE;




-- table user_ans

ALTER TABLE `user_ans`
ADD FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`)ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `user_ans`
ADD FOREIGN KEY (`prob_id`) REFERENCES `problems`(`prob_id`)ON DELETE SET NULL ;



COMMIT;