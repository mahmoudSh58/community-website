<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();

//get page send request
$referer = '../index.php';
if(isset($_SERVER['HTTP_REFERER'])) $referer = $_SERVER['HTTP_REFERER'];
//////////////////////

if (isset($_POST['email'])) {

    $con = mysqli_connect('localhost', 'root', '', 'community_website_db');
    $email = htmlspecialchars(strtolower(trim($_POST['email'])));
    $password = $_POST['password'];

    $select_q = "SELECT `id_user`,`privilege`,`first_name` , `email` , `password`,`state` FROM `user` WHERE `email` ='$email'";
    $data = mysqli_query($con, $select_q);
    $results = mysqli_fetch_assoc($data);


    if (empty($results)) {
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "Entered email does not exist.";
        header("location: $referer");
        exit;
    }
    else if($results['state']!=1){
        $_SESSION['error'] = 1;
        if($results['state']==-1) $_SESSION['message'] = "User is blocked.";
        else $_SESSION['message'] = "User is pending Approval...";
        header("location: $referer");
        exit;
    }
    else if ($results['email'] == $email && password_verify($password , $results['password'])) {
        $expire_time = time() + (30 * 24 * 60 * 60);
        setcookie('id', $results['id_user'], $expire_time, '/');
        setcookie('username', $results['first_name'], $expire_time, '/');


		  //reset search and filter only on || login || logout || when user uses them
		   if( isset($_SESSION['search_events_res']))
		  		unset( $_SESSION['search_events_res']);
			if( isset($_SESSION['filter_events_res']))
				unset( $_SESSION['filter_events_res']);

        header("location: $referer");
        exit;
    } else {
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "wrong password.";
        header("location: $referer");
        exit;
    }

} else {
    $_SESSION['error'] = 1;
    $_SESSION['message'] = "Empty data was send.";
    header("location: $referer");
	 exit;
}
