<?php
if (session_status() === PHP_SESSION_NONE)
	session_start();
//reset search and filter only on || login || logout || when user uses them
if (isset($_SESSION['filter_events_res']))
	unset($_SESSION['filter_events_res']);



if ($_SERVER['REQUEST_METHOD'] === 'GET' and $_SERVER) {
	$_SESSION['filter_events_res'] = -1; //filter returns zero events
	$_SESSION['filter_events_res'] = get_filtered_events($_GET['filter']);

	header("Location: ../page/event.php");
	exit;
} else {
	$_SESSION['error'] = 1;
	$_SESSION['message'] = 'Invalid Event Filter Request';
	header('Location: ../page/event.php');
	exit;
}


function get_filtered_events($filter_on = null)
{

	$conn = mysqli_connect('localhost', 'root', '', 'community_website_db');

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		$_SESSION['error'] = 1;
		$_SESSION['message'] = 'Couldn\'t Complete DB Filter Query';

		unset($_SESSION['filter_events_res']);
		header('Location: ../page/event.php');
		exit;
	}

	// "show_all">All Events<
	// "in_prac">Joined in<
	// "contest">Contests<
	// "course">Courses<
	// "conference">Conferences<
	// "can_join">Can Join<
	// "ended">Ended<
	$filter_db_res = [];
	$filter_slct_query = null;
	if ($filter_on == 'show_all' || $filter_on == null) {
		$filter_slct_query = "SELECT * FROM `event`";
	} else if ($filter_on == 'in_prac') { //special case acess 2 tables
		if (!isset($_COOKIE['id'])) {
			$_SESSION['error'] = 1;
			$_SESSION['message'] = 'You must login first to view Joined in Events';
			header('Location: ../page/event.php');
			exit;
		} else {
			$id_user = $_COOKIE['id'];
			$filter_sub_query = "SELECT `id_event` FROM `practice` WHERE `id_user` = $id_user ;"; // then by event id get all those event data form event table each event is one element in final array
			$sub_query_res = mysqli_query($conn, $filter_sub_query);
			$sub_query_res = mysqli_fetch_all($sub_query_res);
			$final_res = [];

			$i = 0;
			foreach ($sub_query_res as $id_event) {
				$final_res[] = mysqli_query($conn, "SELECT * FROM `event` WHERE `id_event` = {$id_event['id_event']} ;");
				$filter_db_res[] = mysqli_fetch_assoc($final_res[$i]); //fitler_db_res is  2D array [int index]=>[id_event , ...]
				$i++;
			}
		}
	} else if ($filter_on == 'contest') {
		$filter_slct_query = "SELECT * FROM `event` WHERE `event_type` = 'contest';";
	} else if ($filter_on == 'course') {
		$filter_slct_query = "SELECT * FROM `event` WHERE `event_type` = 'course';";
	} else if ($filter_on == 'conference') {
		$filter_slct_query = "SELECT * FROM `event` WHERE `event_type` = 'conference';";
	} else if ($filter_on == 'can_join') {
		$filter_slct_query = "SELECT * FROM `event` WHERE `to_date` > DATE(NOW());";
	} else if ($filter_on == 'ended') { // select actual events that is totally ended  not only apply time finished
		// +1 min for end_date to  (in case of server latency )
		$filter_slct_query = "SELECT *, DATE_ADD(`end_date`, INTERVAL 1 MINUTE) AS `new_end_date` FROM `event` WHERE `end_date` < NOW();"; 
	}


	if ($filter_on != "in_prac"){//handled  in_prac case return is ready
			$filter_db_res = mysqli_query($conn , $filter_slct_query);
			$filter_db_res =  mysqli_fetch_all($filter_db_res , MYSQLI_ASSOC); 
	}

	return $filter_db_res;
}
