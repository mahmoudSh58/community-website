<?php
if (session_status() === PHP_SESSION_NONE)
	session_start();

// reset search and filter only on || login || logout || when user uses them
if (isset($_SESSION['filter_events_res']))
	unset($_SESSION['filter_events_res']);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$_SESSION['filter_events_res'] = -1; //filter returns zero events
	$_SESSION['filter_events_res'] = get_filtered_events($_GET['filter']);
	$_SESSION['last_filter'] = $_GET['filter'];

	header("Location: ../page/event.php");
	exit;
} else {
	$_SESSION['error'] = 1;
	$_SESSION['message'] = 'Invalid Filter Request';
	header('Location: ../page/event.php');
	exit;
}


function get_filtered_events($filter_on = null)
{

	$conn = mysqli_connect('localhost', 'root', '', 'community_website_db');

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		$_SESSION['error'] = 1;
		$_SESSION['message'] = 'Couldn\'t Complete DB Filter Query: \n' . mysqli_connect_error();

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
	//
	// "ended">Ended<

	$filter_db_res = [];
	$filter_slct_query = null;
	if ($filter_on == 'show_all' or $filter_on == null) {
		$filter_slct_query = "SELECT * FROM `event`";

	} else if ($filter_on == 'in_prac') { //special filter_on case1 acess 2 tables
		if (!isset($_COOKIE['id'])) {
			$_SESSION['error'] = 1;
			$_SESSION['message'] = 'You must login first to view Joined in Events';
			return -1;
		} else {
			$id_user = $_COOKIE['id']; // order : the ones you joined  last shows first
			$filter_sub_query = "SELECT `id_event` FROM `practice` WHERE `id_user` = '$id_user'  ORDER BY `time` DESC"; // then by event id get all those event data form event table each event is one element in final array
			$sub_query_res = mysqli_query($conn, $filter_sub_query);
			$sub_query_res = mysqli_fetch_all($sub_query_res);
			$final_res = [];

			$i = 0;
			foreach ($sub_query_res as $id_event) {
				$final_res[] = mysqli_query($conn, "SELECT * FROM `event` WHERE `id_event` = {$id_event[0]} ");
				$filter_db_res[] = mysqli_fetch_assoc($final_res[$i]); //fitler_db_res is  2D array [int index]=>[id_event , ...]
				$i++;
			}

			mysqli_close($conn);
			return $filter_db_res;


		}
	} else if ($filter_on == 'contest') {  // contests than is not ended or apply closed but about to start will get first
		$filter_slct_query = "SELECT * FROM `event` WHERE `event_type` = 'contest' ORDER BY CASE WHEN `to_date` < NOW() THEN 1 ELSE 0 END, `start_date` ASC ,  FIELD(`experience`, 'beginner', 'middle', 'Expert')";
	} else if ($filter_on == 'course') { 
		$filter_slct_query = "SELECT * FROM `event` WHERE `event_type` = 'course' -- ORDER BY `to_date` DESC";
	} else if ($filter_on == 'conference') { // conference that is about to start but not apply ended or its done come first
		$filter_slct_query = "SELECT * FROM `event` WHERE `event_type` = 'conference' ORDER BY CASE WHEN `to_date` < NOW() THEN 1 ELSE 0 END, `start_date` ASC";
	} else if ($filter_on == 'reg_ended') { // whose apply ended in near time  shows first the very old  events shows last 
		$filter_slct_query = "SELECT * FROM `event` WHERE `to_date` <  DATE(NOW()) AND `end_date` > DATE(NOW()) ORDER BY `to_date` DESC";
	} else if ($filter_on == 'can_join') { // the ones that you can join but registration will close soon shows first
		if (!isset($_COOKIE['id'])) {//special filter_on case 2
			$filter_slct_query = "SELECT * FROM `event` WHERE `to_date` > DATE(NOW()) ORDER BY  `to_date` ASC";
		} else {
			$id_user = $_COOKIE['id'];
			$filter_sub_query = "SELECT `id_event` FROM `practice` WHERE `id_user` = '$id_user'"; // then by event id get all those event data form event table each event is one element in final array
			$sub_query_res = mysqli_query($conn, $filter_sub_query);
			$sub_query_res = mysqli_fetch_all($sub_query_res);
			$final_res = [];

			
			if (!empty($sub_query_res)) {
				$event_id_include = implode(',', array_map(function ($item) {
					return $item[0];
				}, $sub_query_res));

				$final_res = mysqli_query($conn, "SELECT * FROM `event` WHERE `id_event` NOT IN ($event_id_include) AND `to_date` > DATE(NOW()) ORDER BY `to_date` ASC");
			}else {
				$final_res = mysqli_query($conn, "SELECT * FROM `event` WHERE `to_date` > DATE(NOW()) ORDER BY `to_date` ASC ");
			}
			$filter_db_res = mysqli_fetch_all($final_res, MYSQLI_ASSOC); //fitler_db_res is  2D array [int index]=>[id_event , ...]



			mysqli_close($conn);
			return $filter_db_res;
		}
	} else if ($filter_on == 'ended') { // select actual events that is totally ended  not only apply time finished
		// +1 min for end_date to  (in case of server latency )
		$filter_slct_query = "SELECT *, DATE_ADD(`end_date`, INTERVAL 1 MINUTE) AS `new_end_date` FROM `event` WHERE `end_date` < NOW() ORDER BY `end_date` DESC";
	}


	$filter_db_res = mysqli_query($conn, $filter_slct_query);
	$filter_db_res = mysqli_fetch_all($filter_db_res, MYSQLI_ASSOC);

	mysqli_close($conn);
	return $filter_db_res;
}