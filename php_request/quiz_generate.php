<?php
//no need to start session here (for now)

function get_probs_id($member_exp) {  //total of 4 questions
	// ids from 1 to 10 EASY
	// i

	$conn = mysqli_connect('localhost', 'root','', 'community_website_db');
	$result = null;

	if (mysqli_connect_errno()) {//TODO : improve this to redirect and clean
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		exit;
  	}

	if ($member_exp == 'beginner'){
		//3 easy 1 medium to pass ->(solve 3 out of 4) | ( 1easy and 1medium)
		// UNION removes duplicated rows   RAND() not very efficient with big tables


		$beginnerquery = <<<heredoc
		(SELECT prob_id , statement FROM problems WHERE difficulty = 1 ORDER BY RAND() LIMIT 3)
		UNION
		(SELECT prob_id , statement FROM problems WHERE difficulty = 2 ORDER BY RAND() LIMIT 1);
		heredoc;

		$result = mysqli_query($conn , $beginnerquery);
		
	} //beginner
	
	else if ($member_exp == 'middle'){
		//2easy 1medium 1hard to pass -> (solve 3 out of 4) | (1hard and 1medium) 
		
		$mediumquery = <<<heredoc
		(SELECT prob_id , statement FROM problems WHERE difficulty = 1 ORDER BY RAND() LIMIT 2)
		UNION
		(SELECT prob_id , statement FROM problems WHERE difficulty = 2 ORDER BY RAND() LIMIT 1)
		UNION
		(SELECT prob_id , statement FROM problems WHERE difficulty = 3 ORDER BY RAND() LIMIT 1);
		heredoc;
	
		$result = mysqli_query($conn , $mediumquery);
		
	} //middle (intermediate)
	
	
	else if ($member_exp == 'expert'){
		//1easy 1medium 2hard  to pass -> (solve 3 out of 4) | (2 hard )
		$hardquery = <<<heredoc
		(SELECT prob_id , statement FROM problems WHERE difficulty = 1 ORDER BY RAND() LIMIT 1)
		UNION
		(SELECT prob_id , statement FROM problems WHERE difficulty = 2 ORDER BY RAND() LIMIT 1)
		UNION
		(SELECT prob_id , statement FROM problems WHERE difficulty = 3 ORDER BY RAND() LIMIT 2);
		heredoc;
	
		$result = mysqli_query($conn , $hardquery);
		
	} //expert

	
	if (!$result) { //TODO : improve this to redirect and clean properly
		echo "Query failed: " . mysqli_error($conn);
		exit;
	}
	
	$prob_set = []; //convert from mysql result obj to simple assoc array( id=>statement , ....)
	while ( $row = mysqli_fetch_assoc($result))
		$prob_set[$row['prob_id']] = $row['statement'];


	//clean and close connection and return
	mysqli_free_result($result);
	mysqli_close($conn);
	return $prob_set ; 
}