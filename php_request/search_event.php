<?php
if (session_status() === PHP_SESSION_NONE)
	session_start();
//reset search and search only on || login || logout || when user uses them
if (isset($_SESSION['search_events_res']))
	unset($_SESSION['search_events_res']);



if ($_SERVER['REQUEST_METHOD'] === 'GET' and $_SERVER) {
	$_SESSION['search_events_res'] = -1; //search returns zero events
	$_SESSION['search_events_res'] = search_events($_GET['to_seach']);

	header("Location: ../page/event.php");
	exit;
} else {
	$_SESSION['error'] = 1;
	$_SESSION['message'] = 'Invalid Event search Request';
	header('Location: ../page/event.php');
	exit;
}


function search_events($to_search){
	$final_found_events = [];

	$conn = mysqli_connect('localhost', 'root', '', 'community_website_db');

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		$_SESSION['error'] = 1;
		$_SESSION['message'] = 'Couldn\'t Complete DB Search Query';

		unset($_SESSION['search_events_res']);
		header('Location: ../page/event.php');
		exit;
	}

	//take out all white chars



	//take out un important words



	//assure max query length

 
	


	//start search DB








	//save in appropraite container



	return $final_found_events;
}
