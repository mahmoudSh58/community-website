<?php
if (session_status() == PHP_SESSION_NONE) 
	session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$_SESSION['is_signup_filled'] = false;
	validate_signup_app();
}else
$_SESSION['is_signup_filled'] = false;


function validate_signup_app()
{
	if (isset($_POST['email'])) {
		$con = mysqli_connect('localhost', 'root', '' , 'community_website_db');

		if (mysqli_connect_errno()) {//TODO : improve this to redirect and clean properly
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit;
	  	}

		$first_name = htmlspecialchars(strtolower(trim($_POST['first_name'])));

		$second_name = htmlspecialchars(strtolower(trim($_POST['second_name'])));

		$last_name = htmlspecialchars(strtolower(trim($_POST['last_name'])));

		$email = htmlspecialchars(strtolower(trim($_POST['email'])));

		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$governorate = htmlspecialchars(strtolower(trim($_POST['governorate'])));

		$city = htmlspecialchars(strtolower(trim($_POST['city'])));

		$gender = htmlspecialchars(strtolower(trim($_POST['gender'])));

		$college = htmlspecialchars($_POST['college']);
		if ($college == 'other') {
			$college = htmlspecialchars(strtolower(trim($_POST['college_name'])));
		}

		$level = htmlspecialchars($_POST['level']);

		$birthday = htmlspecialchars($_POST['birthday']);

		$experience = htmlspecialchars(strtolower($_POST['experience']));


		$check_email_q = "SELECT `id_user`, `email` FROM `user` WHERE `email`='$email' ";
		$data = mysqli_query($con, $check_email_q);
		$results = mysqli_fetch_all($data);

		if (!empty($results)) {
			$_SESSION['error'] = 1;
			$_SESSION['message'] = "Entered email exists.";

			if (isset($_SESSION['is_signup_filled']))
				$_SESSION['is_signup_filled'] = false;

			if (isset($_SESSION['signup_data']))
				unset($_SESSION['signup_data']);

			header('location: ../page/signup.php');
			exit;
		}

		$id = null;
		while (1) {
			$id = uniqid();
			$check_id_q = "SELECT `id_user`, `email` FROM `user` WHERE `id_user`='$id' ";
			$data = mysqli_query($con, $check_id_q);
			$results = mysqli_fetch_assoc($data);
			if (empty($results)){
				break;
			}
		}
		
		$_SESSION['signup_data'] = [
			$id,  $first_name, $second_name,
			$last_name, $email, $password,
			$governorate, $city, $college,
			$level, $birthday, $gender,
			$experience
		];
		$_SESSION['is_signup_filled'] = true;
		mysqli_close($con);

	
		if ( $experience == 'no skill') //done no need to do quiz or click next
			header('location: ./signup_submit_db.php');

		else //done now go click next to go to quiz
			header('Location: ../page/signup.php#signup_btn-group');

		exit;

	} else {

		$_SESSION['error'] = 1;
		$_SESSION['message'] = "Empty data send (Email Field).";
		$_SESSION['is_signup_filled'] = false;

		if (isset($_SESSION['signup_data']))
			unset($_SESSION['signup_data']);

		header('location: ../page/signup.php');
		exit;
	}
}

// function show_next_button($show = false)
// {
// 	if ($show)
// 		echo '<a class="btn btn-primary  rounded-pill mx-1" style=" width : 100px;" href="./signup_quiz.php">Next ></a>';
// 	else
// 		echo '<a class="btn btn-primary  rounded-pill mx-1" style=" width : 100px; display : none;" href="./signup_quiz.php">Next ></a>';
// }
