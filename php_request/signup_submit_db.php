<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();



if ($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET))  //no skill and refreshed signup page with already filled data
	if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'page/signup.php') !== false ){
		$_user_id = save_new_user_app();
		header('Location: ../index.php');
		exit;
	}


if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST)) {
	$_SESSION['error'] = 0;
	$_SESSION['message']= '';
	
	if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'page/signup_quiz.php') !== false ){
		$_user_id = save_new_user_app();
		//make sure he is not no skill
		if ($_SESSION['signup_data'][12] != 'no skill')
			save_new_user_quiz_ans($_user_id);

	}else if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'php_request/signup_data.php') !== false ){
		//if he is no skil
		$_user_id = save_new_user_app();
	}
	
	header('Location: ../index.php');
	exit;
}

//if accessed for anyother place
$_SESSION['error'] = 1;
$_SESSION['message'] = "Redirecting to Home Page";


function save_new_user_app()
{
	$conn = mysqli_connect('localhost', 'root', '', 'community_website_db');

	if (mysqli_connect_errno()) {
		echo "Failed connecting to MySQL" . mysqli_connect_error();
		exit;
	}

	if( !isset($_SESSION['signup_data']) ){
		$_SESSION['error'] = 2;
		$_SESSION['message2'] = "Lost User Signup Data Fill again";

		echo "<div class='alert alert-danger' role='alert' style='
					position: sticky;
					bottom: 15px;
	left: 25px;
	margin: -70px;
	width: 30%;
	display: flex;
	justify-content: center;
	'>
	" . $_SESSION['message2'] . "
	</div>
	<script>
	setTimeout(function() {
		var div = document.getElementsByClassName('alert')[0];
		document.body.removeChild(div);
	}, 5000);
	</script>
	";
	$_SESSION['error'] = 0;
	$_SESSION['message2']= '';
	header("Location: ../page/signup.php");
	exit;
}



	
	$user_application = $_SESSION['signup_data'];

	$insert_q = "INSERT INTO `user`(`id_user`, `first_name`, `second_name`, `last_name`, `email`, `password`, `governorate` , `city`, `college`, `level`, `birthday`, `gender`, `experience`) VALUES
					('" . implode("', '", $user_application)  . "')";

	mysqli_query($conn, $insert_q);

	// Set the cookie expiration time to 1 month from now
	$expire_time = time() + (30 * 24 * 60 * 60);
	setcookie('id', $user_application[0], $expire_time, '/');
	setcookie('username', $user_application[1], $expire_time, '/');
	
	$user_id = $user_application[0];


	mysqli_close($conn);
	
	if (isset($_SESSION['signup_data'][12]) && $_SESSION['signup_data'][12] == 'no skill') {
		$_SESSION['error'] = 0;
		$_SESSION['message']= '';
		$_SESSION['message2']= '';
		$_SESSION['is_signup_filled'] = false;
		unset($_SESSION['signup_data']);
		header('Location: ../index.php');
		exit;
	}

	return $user_id;
}

function save_new_user_quiz_ans($user_id)
{
	$conn = mysqli_connect('localhost', 'root', '', 'community_website_db');

	if (mysqli_connect_errno()) {
		echo "Failed connecting to MySQL " . mysqli_connect_error();
		exit;
	}

	$questions_id = [];
	foreach ($_SESSION['choosed_questions_id_ordered'] as $q_id)
		$questions_id[] = $q_id;

	$questions_user_ans = [];
	foreach ($_POST as $q_no => $ans)
		$questions_user_ans[] = $ans;

	for ($i = 0; $i < 4; $i++) {
		$query = "INSERT INTO `user_ans` (`id_user` , `prob_id` , `ans`) VALUES
					('$user_id' ,  '$questions_id[$i]' , '$questions_user_ans[$i]');";

		mysqli_query($conn, $query);
	}

	if (!isset($_SESSION['error']) or $_SESSION['error'] == 0) {
		echo "<div class='alert alert-success' role='alert' style='
			position: sticky;
			bottom: 15px;
			left: 25px;
			margin: -70px;
			width: 30%;
			display: flex;
			justify-content: center;
			'>
			" . "Signup Completed Successfully ... Please Wait your Approval" . "
			</div>
			<script>
		  setTimeout(function() {
				var div = document.getElementsByClassName('alert')[0];
				document.body.removeChild(div);
		  }, 5000);
		  </script>
		";
		$_SESSION['error'] = 0;
		$_SESSION['message']= '';
		$_SESSION['message2']= '';
	
	}

	//clean and redirect
	$_SESSION['is_signup_filled'] = false;
	unset($_SESSION['signup_data']);
	unset($_SESSION['choosed_questions_id_ordered']);
	mysqli_close($conn); 

	header('Location: ../index.php');
	exit;
}

if (isset($_SESSION['error']) && $_SESSION['error'] == 1) {
	echo "<div class='alert alert-danger' role='alert' style='
					position: sticky;
					bottom: 15px;
	left: 25px;
	margin: -70px;
	width: 30%;
	display: flex;
	justify-content: center;
	'>
	" . $_SESSION['message'] . "
	</div>
	<script>
	setTimeout(function() {
		var div = document.getElementsByClassName('alert')[0];
		document.body.removeChild(div);
	}, 5000);
	</script>
	";
}
$_SESSION['error'] = 0;
$_SESSION['message']= '';

