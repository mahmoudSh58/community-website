<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'community_website_db');

if (isset($_POST['id'])) {
    if (isset($_SESSION['users'])&& !empty($_SESSION['users'])) {
        $id_req = $_SESSION['users'][intval($_POST['id'])];

        $privilege = '';
        if (isset($_COOKIE['id'])) {
            $id_user = $_COOKIE['id'];
            $select_q = "SELECT `privilege`,`state` FROM `user` WHERE `id_user` ='$id_user'";
            $data = mysqli_query($con, $select_q);
            $results = mysqli_fetch_assoc($data);

            if (empty($results)) {
                $_SESSION['error'] = 1;
                $_SESSION['message'] = "User is deleted.";
                header('location: logout.php');
                exit;
            }
            if ($results['state'] != 1) {
                $_SESSION['error'] = 1;
                if ($results['state'] == -1)
                    $_SESSION['message'] = "User is blocked.";
                else
                    $_SESSION['message'] = "User in pending.";
                header('location: logout.php');
                exit;
            }
            $privilege = $results['privilege'];
        } else {
            $_SESSION['error'] = 1;
            $_SESSION['message'] = "Login first.";
            header('location: ../index.php');
            exit;
        }

        $select_q = "SELECT `privilege` FROM `user` WHERE `id_user` ='$id_req'";
        $data = mysqli_query($con, $select_q);
        $user_req = mysqli_fetch_assoc($data);

        if (empty($user_req)) {
            $_SESSION['error'] = 1;
            $_SESSION['message'] = "Try again.";
            header('location: ../page/member.php');
            exit;
        }

        if ($privilege == 'member') {
            $_SESSION['error'] = 1;
            $_SESSION['message'] = "You are not admin";
            header('location: ../page/member.php');
            exit;
        }

        if ($user_req['privilege'] == 'owner') {
            $_SESSION['error'] = 1;
            $_SESSION['message'] = "You Can't edit owner";
            header('location: ../page/member.php');
            exit;
        }

        if ($_POST['submit'] == 'block') {
            if ($user_req['privilege'] == 'member') {
                $update_q = "UPDATE `user` SET `state`= -1, `blocked_by`='$id_user'  WHERE `id_user`='$id_req'";
                mysqli_query($con, $update_q);
                header('location: ../page/member.php');
                exit;
            } else {
                $_SESSION['error'] = 1;
                $_SESSION['message'] = "You Can't block admin";
                header('location: ../page/member.php');
                exit;
            }
        } else if ($_POST['submit'] == 'unblock') {
            if ($user_req['privilege'] == 'member') {
                $update_q = "UPDATE `user` SET `state`=1,`blocked_by`= null WHERE `id_user`='$id_req'";
                mysqli_query($con, $update_q);
                header('location: ../page/member.php');
                exit;
            } else {
                $_SESSION['error'] = 1;
                $_SESSION['message'] = "You Can't unblock admin";
                header('location: ../page/member.php');
                exit;
            }
        } else if ($_POST['submit'] == 'admin') {
            if ($privilege == 'owner') {
                $update_q = "UPDATE `user` SET `privilege`='admin' , `role`='admin' WHERE `id_user`='$id_req'";
                mysqli_query($con, $update_q);
                header('location: ../page/member.php');
                exit;
            } else {
                $_SESSION['error'] = 1;
                $_SESSION['message'] = "You Can't unblock admin";
                header('location: ../page/member.php');
                exit;
            }
        }  else if ($_POST['submit'] == 'unadmin') {
            if ($privilege == 'owner') {
                $update_q = "UPDATE `user` SET `privilege`='member' , `role`='member' WHERE `id_user`='$id_req'";
                mysqli_query($con, $update_q);
                header('location: ../page/member.php');
                exit;
            } else {
                $_SESSION['error'] = 1;
                $_SESSION['message'] = "You Can't unblock admin";
                header('location: ../page/member.php');
                exit;
            }
        }


    } else {
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "Try again.";
        header('location: ../page/member.php');
        exit;
    }
} else {
    $_SESSION['error'] = 1;
    $_SESSION['message'] = "Try again.";
    header('location: ../page/member.php');
    exit;
}
?>