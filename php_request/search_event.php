<?php

// TODO more work on trivial char and words  
// TODO more work on trivial char and words  
// TODO user choose Result limit
// TODO if number names to actual numbr  (search both)-> one to 1..
// TODO its better : seprate words from number like level1 -> level 1

if (session_status() === PHP_SESSION_NONE)
	session_start();
//reset search and search only on || login || logout || when user uses them
if (isset($_SESSION['search_events_res']))
	unset($_SESSION['search_events_res']);



if ($_SERVER['REQUEST_METHOD'] === 'GET' and (mb_strlen($_GET['to_search']) > 1 or (is_numeric($_GET['to_search']) ) ) and $_GET['to_search'] != null) {
	$_SESSION['search_events_res'] = -1; //search returns zero events
	$_SESSION['search_events_res'] = search_events_main($_GET['to_search']);
	$_SESSION['last_search'] = $_GET['to_search'];
	header("Location: ../page/event.php");
	exit;
} else if( $_GET['to_search'] == null){
	unset($_SESSION['search_events_res']); 
	header('Location: ../page/event.php');
	exit;
	
}else{
	
	$_SESSION['error'] = 1;
	$_SESSION['message'] = 'Invalid search Request';
	
	unset($_SESSION['search_events_res']); 
	header('Location: ../page/event.php');
	exit;

}


function discard_html_white_chars( mysqli $conn , string $before_discard): string
{

	//take out all white chars and and excessive spaces between words
	$before_discard = preg_replace("/(\s+)+/", ' ', $before_discard); //forward slash '\' is just delemiter choose # ,~ , white space or any not letter 

	//deal with html special chars
	$before_discard = htmlspecialchars($before_discard);
	$before_discard = preg_replace("/(&lt;)+|(&gt;)+|(&amp;)+|(&quot;)+|(&#039;)+/", ' ', $before_discard);

	$before_discard = trim($before_discard);

	//comma and full stop to empy str
	$after_discard = preg_replace("/,+|\.+/" , '' , $before_discard);


	$after_discard = mysqli_real_escape_string($conn , $after_discard);

	return $after_discard;
}

function discard_trivial_words( mysqli $conn , string $to_clean_trivial , int $word_len_limit = 29): array | int//returns arr not str
{

	$trivial_words = ["in", 'is' , "a", "the", "of", "or", "I", "you", "he", "me", "us", "they", "she", "to", "but", "that", "this", "those", "then"];

	//cvt to arr
	$all_query_words = explode(" ", $to_clean_trivial);
	$query_imp_words = [];

	//tot. no. of words 
	foreach ($all_query_words as $word) {

		if (in_array($word, $trivial_words))
			continue;

		//assure max word length(longest non technical word is 29 chars) (if used it only user can make total 3 words search query and ~10 char will remain to maxlength)
		// also escape to prevent sql injection
		substr($word, 0, $word_len_limit);
		$word = mysqli_real_escape_string($conn , $word);
		$query_imp_words[] = $word;
	}

	if ( count($query_imp_words) < 1  or  empty($query_imp_words)  ){
		$_SESSION['error'] = 1;
		$_SESSION['message'] = "Invalid search Request : No sefull Keywords " ;
		
		mysqli_close($conn);
		unset($_SESSION['search_events_res']);
		return -1;
	}

	return $query_imp_words;
}

function search_events_main(string $to_search, int $limit_res = 4 , float $relevance_threshhold = 24 ): array | int//relevance in our MySQL is between 0-1
{
	$final_found_events = [];
	$conn = mysqli_connect('localhost' , 'root' , '' , 'community_website_db');

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		$_SESSION['error'] = 1;
		$_SESSION['message'] = 'Couldn\'t Complete DB Search Query: \n' .  mysqli_connect_error();

		unset($_SESSION['search_events_res']);
		header('Location: ../page/event.php');
		exit;
	}


	//ensure limit is 100 char 
	$to_search = substr(trim($to_search), 0, 100);


	//needed later 
	$to_search_keywords = $to_search;


	// clean any html special char / white char / comma / fullstops + escape(avoid sql inject)
	$to_search_esc = discard_html_white_chars($conn , $to_search);


	//take out un-important words (returns array of important words) + escape to aviod sql inject
	$to_search_keywords = discard_trivial_words($conn , $to_search_keywords);
	if($to_search_keywords == -1)
		return -1;


	//eval to wights => event_name > event_type > summary > experience > content > start_date > from_date >  description
	// global $weights;
	$weights =
		[
			'event_name_full' => 15,
			'event_name_sub'  => 8,
			'summary_full'    => 9,
			'event_type'      => 8,
			'experience_full' => 8,
			'full_st_date'    => 7,
			'full_from_date'  => 7,
			'content' 			=> 6,
			'experience'      => 5,
			'summary' 			=> 5,
			'from_date'       => 3,
			'start_date' 		=> 3,
		];


	//sub queries (relevance expressions):
	$eventName_squery = [];
	$eventType_squery = [];
	$summary_squery   = [];
	$fromDate_squery  = [];
	$startDate_squery = [];
	$exp_squery       = [];
	$content_squery   = [];


	// start filling sub queries with  to_search user Query full match
	$eventName_squery [] = "if (`event_name` LIKE '%" . $to_search_esc . "%' , {$weights['event_name_full']} , 0)"; //if found i.e.(perfect full match) => return score form wieghts to be added if not found return 0 to be added
	$eventType_squery [] = "if (`summary` LIKE '%"    . $to_search_esc . "%' , {$weights['summary_full']} , 0)";
	$eventType_squery [] = "if (`summary` LIKE '%"    . $to_search_esc . "%' , {$weights['experience_full']} , 0)";
	$eventType_squery [] = "if (`summary` LIKE '%"    . $to_search_esc . "%' , {$weights['full_st_date']} , 0)";
	$eventType_squery [] = "if (`summary` LIKE '%"    . $to_search_esc . "%' , {$weights['full_from_date']} , 0)";

	//fill  keywords match 
	$keyword = '';
		// patern matches = one extra or less char to keyword | two adjacent chars swapped |  extra one letter inserted after any of first 4 chars
	$pattern = '[[:<:]]('.substr_replace($keyword, '[[:alpha:]]?', 1, 0).'|'
								.substr_replace($keyword, '[[:alpha:]]?', 0, 1).'|'
								.substr_replace($keyword, '', 1, 1).'|'
								.substr_replace($keyword, '[[:alpha:]]?', 2, 0).'|'
								.substr_replace($keyword, '[[:alpha:]]?', 1, 1).'|'
								.substr_replace($keyword, '[[:alpha:]]?', 0, 2).'|'
								.substr_replace($keyword, $keyword[1].$keyword[0], 0, 1).'|'
								.substr_replace($keyword, $keyword[1].$keyword[0], 1, 1).'|'
								.substr_replace($keyword, $keyword[3].$keyword[2].$keyword[1].$keyword[0], 0, 2).')[[:>:]]';

	foreach ( $to_search_keywords  as $keyword){
		$keyword = substr($keyword , 0 -1);
		$eventName_squery [] = "if (`event_name` LIKE '%" . $keyword . "_%' , {$weights['event_name_sub']} , 0)"; 
		$eventType_squery [] = "if (`event_type` LIKE '%" . $keyword . "_%' , {$weights['event_type']} , 0)";  
		$summary_squery   [] = "if (`summary` LIKE '%"    . $keyword . "_%' , {$weights['summary']} , 0)"; 
		$fromDate_squery  [] = "if (`from_date` LIKE '%"  . $keyword .  "_%' , {$weights['from_date']} , 0)";
		$startDate_squery [] = "if (`start_date` LIKE '%" . $keyword .  "_%' , {$weights['start_date']} , 0)" ;
		$exp_squery       [] = "if (`experience` LIKE '%" . $keyword .  "_%' , {$weights['experience']} , 0)" ;
		$content_squery   [] = "if (`content` LIKE '%"    . $keyword .  "_%' , {$weights['content']} , 0)" ;
	}

//in case any is empty make expression = 0  (summation needs int val not null or other vals)
  if (empty($eventName_squery))
		$eventName_squery[] = 0;
  if (empty($eventType_squery))
		$eventType_squery[] = 0;
  if (empty($summary_squery))
		$summary_squery[] = 0;
  if (empty($fromDate_squery))
		$fromDate_squery[] = 0;
  if (empty($startDate_squery))
		$startDate_squery[] = 0;
  if (empty($exp_squery))
		$exp_squery[] = 0;
  if (empty($content_squery))
		$content_squery[] = 0;
  


  //main sql search query
  $main_search_query =
  "SELECT * , ( (" . implode(" + " , $eventName_squery ) . ") +
  				    (" . implode(" + " , $eventType_squery)  . ") +
  				    (" . implode(" + " , $summary_squery )   . ") +
  				    (" . implode(" + " , $fromDate_squery )  . ") +
  				    (" . implode(" + " , $startDate_squery ) . ") +
  				    (" . implode(" + " , $exp_squery )       . ") +
  				    (" . implode(" + " , $content_squery )   . ") )
  AS relevance FROM `event` HAVING relevance > $relevance_threshhold  ORDER BY relevance DESC , `event`.`to_date` DESC LIMIT $limit_res";

  	// Execute DB Search Query
	$db_search_res = mysqli_query( $conn , $main_search_query );

	//save  search final result in appropraite container
	$final_found_events = mysqli_fetch_all( $db_search_res , MYSQLI_ASSOC);

	mysqli_close($conn);
	return $final_found_events;
}
