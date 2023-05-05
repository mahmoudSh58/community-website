<?php
session_start();
if (isset($_POST['email'])) {
    $con = mysqli_connect('localhost', 'root', '', 'community_website_db');

    $first_name = htmlspecialchars(strtolower(trim($_POST['first_name'])));

    $second_name = htmlspecialchars(strtolower(trim($_POST['second_name'])));

    $last_name = htmlspecialchars(strtolower(trim($_POST['last_name'])));

    $email = htmlspecialchars(strtolower(trim($_POST['email'])));

    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $governorate = htmlspecialchars(strtolower(trim($_POST['governorate'])));

    $city = htmlspecialchars(strtolower(trim($_POST['city'])));

    $gender = htmlspecialchars(strtolower(trim($_POST['gender'])));

    $college = htmlspecialchars($_POST['college']);
    if ($college == 'other') {
        $college = htmlspecialchars(strtolower(trim($_POST['college_name'])));
    }

    $level = htmlspecialchars($_POST['level']);

    $birthday = htmlspecialchars($_POST['birthday']);

    $experience = htmlspecialchars($_POST['experience']);


    $check_email_q = "SELECT `id_user`, `email` FROM `user` WHERE `email`='$email' ";
    $data = mysqli_query($con, $check_email_q);
    $results = mysqli_fetch_all($data);
    if (!empty($results)) {
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "Entered email exists.";
        header('location: ../page/signup.php');
        exit;
    }

    $id = null;
    while (1) {
        $id = uniqid();
        $check_id_q = "SELECT `id_user`, `email` FROM `user` WHERE `id_user`='$id' ";
        $data = mysqli_query($con, $check_id_q);
        $results = mysqli_fetch_assoc($data);
        if (empty($results))
            break;
    }

    $insert_q = "INSERT INTO `user`(`id_user`, `first_name`, `second_name`, `last_name`, `email`, `password`, `governorate` , `city`, `college`, `level`, `birthday`, `gender`, `experience`) VALUES
                ('$id','$first_name','$second_name','$last_name','$email','$password','$governorate','$city','$college','$level','$birthday', '$gender' ,'$experience')";
    mysqli_query($con, $insert_q);


    // Set the cookie expiration time to 1 month from now
    $expire_time = time() + (30 * 24 * 60 * 60);
    setcookie('id', $id, $expire_time, '/');
    setcookie('username', $first_name, $expire_time, '/');
    header('location: ../index.php');
    exit;
} else {
    $_SESSION['error'] = 1;
    $_SESSION['message'] = "Empty data send.";
    header('location: ../page/signup.php');
    exit;
}
?>