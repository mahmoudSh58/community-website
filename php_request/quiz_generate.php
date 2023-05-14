<?php
//no need to start session here (for now)

// TODO : try it after adding backticks to colm and table names in sql query

function get_probs_id($member_exp)
{  //total of 4 questions
	// ids from 1 to 10 EASY
	// i

	$conn = mysqli_connect('localhost', 'root', '', 'community_website_db');
	$result = null;

	if (mysqli_connect_errno()) { //TODO : improve this to redirect and clean
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		exit;
	}

	if ($member_exp == 'beginner') {
		//3 easy 1 medium to pass ->(solve 3 out of 4) | ( 1easy and 1medium)
		// UNION removes duplicated rows   RAND() not very efficient with big tables


		$beginnerquery = <<<heredoc
		(SELECT `prob_id`, `statement` FROM `problems` WHERE `difficulty` = 1 ORDER BY RAND() LIMIT 3)
		UNION
		(SELECT `prob_id`, `statement` FROM `problems` WHERE `difficulty` = 2 ORDER BY RAND() LIMIT 1);
		heredoc;

		$result = mysqli_query($conn, $beginnerquery);
	} //beginner

	else if ($member_exp == 'middle') {
		//2easy 1medium 1hard to pass -> (solve 3 out of 4) | (1hard and 1medium) 

		$mediumquery = <<<heredoc
		(SELECT `prob_id`, `statement` FROM `problems` WHERE `difficulty` = 1 ORDER BY RAND() LIMIT 2)
		UNION
		(SELECT `prob_id`, `statement` FROM `problems` WHERE `difficulty` = 2 ORDER BY RAND() LIMIT 1)
		UNION
		(SELECT `prob_id`, `statement` FROM `problems` WHERE `difficulty` = 3 ORDER BY RAND() LIMIT 1);
		heredoc;

		$result = mysqli_query($conn, $mediumquery);
	} //middle (intermediate)


	else if ($member_exp == 'expert') {
		//1easy 1medium 2hard  to pass -> (solve 3 out of 4) | (2 hard )
		$hardquery = <<<heredoc
		(SELECT `prob_id`, `statement` FROM `problems` WHERE `difficulty` = 1 ORDER BY RAND() LIMIT 1)
		UNION
		(SELECT `prob_id`, `statement` FROM `problems` WHERE `difficulty` = 2 ORDER BY RAND() LIMIT 1)
		UNION
		(SELECT `prob_id`, `statement` FROM `problems` WHERE `difficulty` = 3 ORDER BY RAND() LIMIT 2);
		heredoc;
		$result = mysqli_query($conn, $hardquery);
	} //expert


	if (!$result) { //TODO : improve this to redirect and clean properly
		echo "Query failed: " . mysqli_error($conn);
		exit;
	}

	$prob_set = []; //convert from mysql result obj to simple assoc array( id=>statement , ....)
	while ($row = mysqli_fetch_assoc($result))
		$prob_set[$row['prob_id']] = $row['statement'];


	//clean and close connection and return
	mysqli_free_result($result);
	mysqli_close($conn);
	return $prob_set;
}


//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//


function get_old_ans( string $user_id ) { //return array

	$conn = mysqli_connect('localhost', 'root', '', 'community_website_db');

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		$_SESSION['error'] = 1;
		$_SESSION['message'] = 'DB Error : couldn\'t get old user answers \n' . mysqli_connect_error();
		header('Location: ../page/join_request.php');
		exit;
	}
	$user_ans_query = "SELECT * FROM `user_ans` WHERE `id_user` = '$user_id'";
	$query_res      = mysqli_query($conn , $user_ans_query );
	$useri_ans_arr  = mysqli_fetch_all(  $query_res , MYSQLI_ASSOC);  //after q1 user ans ->    $questions[0]['ans']= a|b|c 

	//query user_ans by passed user_id  then by prob_id get problems all data from problems table
	$q_ids_db  = array_map( fn($ans) => $ans['prob_id'] , $useri_ans_arr);
	

	$probs_query        = "SELECT * FROM  `problems` WHERE `prob_id` IN (" . implode("," , $q_ids_db) . ") ORDER BY FIELD(`prob_id` ," . implode(",", $q_ids_db) . ")";
	$query_res          =  mysqli_query( $conn , $probs_query ); 
	$asked_problems_arr = mysqli_fetch_all( $query_res , MYSQLI_ASSOC);
	$statements_colm    = array_map( fn($q) => $q['statement'] , $asked_problems_arr);

	//parse all 
	$all_probs_choices   = [];
	$questions_statement = [];
	$correct_ans  = [] ;  // array_map(fn($correct_ans) => $ans['correct_ans'] , $useri_ans_arr);
	$user_choices = [] ;  //array_map(fn($choice) => $choice['ans'] , $useri_ans_arr  );
	$q_difficulty = [] ;  //array_map(fn($q) => $q['difficulty'] , $asked_problems_arr);
	$q_type       = [] ;  //array_map(fn($q) => $q['type'] , $asked_problems_arr);
	$total_mark   = 0;    // out of 4 (beside it how many hard / med / easy solved)
	$hard_solved  = 0; 	 //1easy 2mid 3hard (int)
	$mid_solved   = 0;
	$easy_solved  = 0;

	$k = 0;
	foreach ($useri_ans_arr as $q){
		$correct_ans [] = $q['correct_ans'];
		$user_choices[] = $q['ans'];
		$q_difficulty[] = $asked_problems_arr[$k]['difficulty'];
		$q_type      [] = $asked_problems_arr[$k]['type'];


		if ( $q['ans'] == $q['correct_ans']){ 
			$total_mark++; 
			$hard_solved += $q_difficulty[$k] == 3 ? 1 : 0; 
			$mid_solved  += $q_difficulty[$k] == 2 ? 1 : 0; 
			$easy_solved += $q_difficulty[$k] == 1 ? 1 : 0; 
		}
			
		$k++;
	}



	$j = 0;
	foreach ($statements_colm as $q) { //each element is a dom object that has one Question

		$dom = new DOMDocument();
		@$is_loaded = $dom->loadHTML($q); //suppress warning via '@'
		$dom_p_elems  = $dom->getElementsByTagName('p'); // statment without choices
		$dom_li_elems = $dom->getElementsByTagName('li'); //choices each on is an element
		$dom_code_elems = $dom->getElementsByTagName('code'); //choices each on is an element


		$questions_statement[$q_ids_db[$j]] = $dom_p_elems->item(0)->nodeValue;
		@$questions_statement[$q_ids_db[$j]] .= "<br>" . $dom_code_elems->item(0)->nodeValue; //supress some times question has no codes


		foreach ($dom_li_elems as $li_elem) //fill each question with its parsed  choices 
			$all_probs_choices[$q_ids_db[$j]][] = $li_elem->nodeValue;  // 2D array of question ids and choices

		$j++;
	}


	mysqli_close($conn);

	return [ 
			$questions_statement,
			$all_probs_choices,
			$correct_ans,
			$user_choices,
			$q_difficulty,
			$q_type,
			$total_mark,
			$hard_solved,
			$mid_solved,
			$easy_solved,
			$q_ids_db ];
}
