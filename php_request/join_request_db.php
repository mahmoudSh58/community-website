<?php
#TODO : SEND Acceptance email if email verified (after making email verify feature in members page)

if (session_status() == PHP_SESSION_NONE)
	session_start();

$privilege = '';
$conn = mysqli_connect('localhost', 'root', '', 'community_website_db');

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	$_SESSION['error'] = 1;
	$_SESSION['message'] = 'Couldn\'t Complete DB Filter Query: \n' . mysqli_connect_error();

	header('Location: ../page/join_request.php');
	exit;
}

if (isset($_COOKIE['id'])) {
	$id_user = $_COOKIE['id'];
	$select_q = "SELECT `privilege`,`state` FROM `user` WHERE `id_user` ='$id_user'";
	$data = mysqli_query($conn, $select_q);
	$results = mysqli_fetch_assoc($data);

	if (empty($results)) {
		$_SESSION['error'] = 1;
		$_SESSION['message'] = "User is deleted.";
		header('location: ../php_request/logout.php');
		exit;
	}
	if ($results['state'] != 1) {
		$_SESSION['error'] = 1;
		if ($results['state'] == -1)
			$_SESSION['message'] = "User is blocked.";
		else
			$_SESSION['message'] = "User is pending Approval...";
		header('location: ../php_request/logout.php');
		exit;
	}

	$privilege = $results['privilege'];

	if ($privilege != 'admin' && $privilege != 'owner') {
		$_SESSION['error'] = 1;
		$_SESSION['message'] = "Only Admins Page";
		header('location: ../index.php');
		exit;
	}

	$check_id = $_SESSION['users'];
	if ( isset($_POST['accept'])  ) {
		$update_query = "UPDATE `user` SET `state` = 1  , `accept_by` =  '$id_user' WHERE `id_user` = '{$check_id[$_POST['accept']]}'";		
		mysqli_query($conn , $update_query);
		
		unset($_POST['accept']);
	}elseif ( isset($_POST['reject']) ){

		$delete_query_sub = "DELETE FROM `user_ans` WHERE `id_user` = '{$check_id[$_POST['reject']]}'";		
		mysqli_query($conn , $delete_query_sub);
		$delete_query = "DELETE FROM `user` WHERE `id_user` = '{$check_id[$_POST['reject']]}'";		
		mysqli_query($conn , $delete_query);

		 unset($_POST['rejcet']);
	}

	mysqli_close($conn);
	unset($check_id);
	header('Location: ../page/join_request.php');
	exit;
}
?>