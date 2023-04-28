<?php
session_start();
if (isset($_POST['email'])) {
    $con = mysqli_connect('localhost', 'root', '', 'community_website_db');
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    $select_q = "SELECT `id_user`,`first_name` , `email` , `password`,`block` FROM `user` WHERE `email` ='$email'";
    $data = mysqli_query($con, $select_q);
    $results = mysqli_fetch_assoc($data);


    if (empty($results)) {
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "Entered email are not exist.";
        header('location: ../index.php');
        exit;
    }
    else if ($results['block']) {
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "User is blocked.";
        header('location: ../index.php');
        exit;
    }
    else if ($results['email'] == $email && $results['password'] == $password) {
        $expire_time = time() + (30 * 24 * 60 * 60);
        setcookie('id', $results['id_user'], $expire_time, '/');
        setcookie('username', $results['first_name'], $expire_time, '/');
        header('location: ../index.php');
        exit;
    } else {
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "wrong password.";
        header('location: ../index.php');
        exit;
    }

} else {
    $_SESSION['error'] = 1;
    $_SESSION['message'] = "Empty data send.";
    header('location: ../index.php');
}
?>