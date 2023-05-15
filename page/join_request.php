<?php
#TODO : SEND Acceptance email if email verified (after making email verify feature in members page)

if (session_status() == PHP_SESSION_NONE)
	session_start();

if (isset($_SESSION['users_exp']))
	unset($_SESSION['users_exp']);

if (isset($_SESSION['users']))
	unset($_SESSION['users']);

$privilege = '';
$con = mysqli_connect('localhost', 'root', '', 'community_website_db');

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	$_SESSION['error'] = 1;
	$_SESSION['message'] = 'Couldn\'t Complete DB Filter Query: \n' . mysqli_connect_error();

	header('Location: ../index.php');
	exit;
}


if (isset($_COOKIE['id'])) {
	$id_user = $_COOKIE['id'];
	$select_q = "SELECT `privilege`,`state` FROM `user` WHERE `id_user` ='$id_user'";
	$data = mysqli_query($con, $select_q);
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

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/all.min.css" />
	<link rel="stylesheet" href="../css/home.css" />
	<link rel="stylesheet" href="../css/join_request.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.6/styles/default.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.6/highlight.min.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>

	<script src="../js/icon.js"></script>

	<title>join request</title>
</head>

<body>
	<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="../index.php">
				<img src="../image/eksu black.svg" width="70" height="50" alt="" />
				<span class="icon-text"> EKSU-PSC</span>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
				data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
				aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="../index.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link px-lg-3" href="event.php">Events</a>
					</li>
					<?php
					if (isset($_COOKIE['id'])) {
						echo '
                        <li class="nav-item">
                        <a class="nav-link px-lg-3 disabled" style="color: #9E9E9E;" href="#">Forum<sub>(soon)</sub></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-lg-3" href="member.php">Members</a>
                        </li>';
					}
					?>

					<?php
					if ($privilege == 'admin' || $privilege == 'owner') {
						echo '<li class="nav-item">
                    			<a class="nav-link active disabled" aria-current="page" href="#">Join-Request</a>
                			  </li>
            			';
					}
					?>

					<li class="nav-item mt-2 m-lg-0">
						<?php
						if (isset($_COOKIE['username'])) {

							echo '<span class="nav-item dropdown">';
							echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
							echo '<i style="color:white;padding-right: 5px; font-size: 1.3rem;" class="fa-regular fa-circle-user"></i>';
							echo $_COOKIE['username'];
							echo '</a>';
							echo '<ul class="dropdown-menu" 
                  style="background-color: #383e45;
                    width: 10px;
                    margin-top: -6px;"
                    aria-labelledby="navbarDropdown">';
							echo '
					
					<li>
					<a class="nav-link disabled p-0" style="color: #9E9E9E;" href="#">Profile<sub>(soon)</sub></a>
					</li>

					<hr class="my-2">

					<li>
                    <form action="php_request/logout.php" method="post" class="d-inline">
                    <button class="btn btn-link p-0" style="text-decoration: none;" type="submit">Logout</button>
                    </form>
                    </li>
                  </ul>
                </li>';
						} else {
							echo '<button class="btn btn-success ms-lg-3 login me-3">';
							echo 'Login';
							echo '</button>';
							echo '<button class="btn btn-warning me-lg-3 signup">';
							echo 'Signup';
							echo '</button>';
						}
						?>
					</li>
				</ul>
			</div>
		</div>
	</nav>


	<div class="form row m-2">
		<h3 class="h3 text-center mb-4" style="font-family : monospace;">Join Requests</h3>
	</div>

	<?php
	require_once '../php_request/quiz_generate.php';
	$select_q = "SELECT * FROM `user` WHERE `state` ='0'";

	$data = mysqli_query($con, $select_q);
	$results = mysqli_fetch_all($data, MYSQLI_ASSOC);
	mysqli_close($con);


	if (empty($results)) {
		echo "
            <p style='
            height: 75vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            color: #c3c3c3;
            margin: 0;
            '>NO REQUESTS YET</p>
            ";
	} else {

		$_SESSION['users'] = [];

		echo '
        <div class="cont m-3" style="min-height: 75vh;">
        <table class="table align-middle mb-0 bg-white m-0 text-center">
            <tbody>
                <hr class="m-0">
        ';
		$i = 0;
		foreach ($results as $result) {

			$_SESSION['users'][$i] = $result['id_user'];
			$_SESSION['users_exp'][$i] = $result['experience'];

			$age = date('Y') - intval($result['birthday']);

			echo "
            <tr>
                <th scope='row'>" . ucfirst($result['first_name']) . ' ' . ucfirst($result['second_name']) . ' ' . ucfirst($result['last_name']) . "</th>
                <td>" . ucwords($result['college']) . "</td>
				<td>" . ucwords($result['experience']) . "</td>
				<td>" . $age . " Y</td>
                <td><button type='button' class='btn btn-secondary info-user' id='$i'><i class='fa-solid fa-eye'></i></button></td>
            </tr>
            ";
			$i++;
		}
		echo '
		</tbody>
		</table>
		</div>
		';

		echo '<div class="overlay"></div>';
		$i = 0;
		foreach ($results as $result) { // for each uesr?
	
			echo "
			<form method='post' action='../php_request/join_request_db.php' class='overform_card user-$i'>";
			echo "
			<div class='d-flex' style='	
			justify-content: space-around;
			flex-wrap: wrap;
			align-items: center;
			'>
			<button type='submit' style='width:200px' class='btn btn-success mb-2' name='accept' value='$i'>Accept</button>
			<button type='submit' style='width:200px'  class='btn btn-danger mb-2' name='reject' value='$i'>Reject</button>";
			echo "</div> ";


			if ($_SESSION['users_exp'][$i] == 'no skill') {
				echo "
				<p style='
				height: 60vh;
				display: flex;
				justify-content: center;
				align-items: center;
				font-size: 1.5rem;
				color: #c3c3c3;
				margin: 0;
				'>No Quiz Submitted (No Skill)</p>
				";
				echo "<div class='mb-3 btn xmark'><i class='fa-solid fa-xmark'></i></div>
				</form>";

				$i++;
				continue;
			}

			// ----------------------------------------------------------------------
			list(
				$questions_statement,
				$all_probs_choices,
				$correct_ans,
				$user_choices,
				$q_difficulty,
				$q_type,
				$total_mark,
				$hard_solved,
				$mid_solved,
				$easy_solve,
				$q_ids_db
			) = get_old_ans($_SESSION['users'][$i]);
			// ----------------------------------------------------------------------
	
			$q_no = count($q_ids_db);
			$total_mark = 0;
			$diff_arr = [null, 0, 0, 0]; //1 easy 2mid 3hard
	
			for ($j = 0; $j < $q_no; $j++) {
				$q = $j + 1;


				$is_cheked_labelA = "class='form-check-label custom-bg-color rounded d-inline align-items-center m-2' style='padding: 1px 10px; border-radius: 20px; background-color: transparent !important;'";
				$is_cheked_labelB = "class='form-check-label custom-bg-color rounded d-inline align-items-center m-2' style='padding: 1px 10px; border-radius: 20px; background-color: transparent !important;'";
				$is_cheked_labelC = "class='form-check-label custom-bg-color rounded d-inline align-items-center m-2' style='padding: 1px 10px; border-radius: 20px; background-color: transparent !important;'";
				$is_checkedA = "style='background-color : transparent !important;color: black; opacity: 1;'";
				$is_checkedB = "style='background-color : transparent !important;color: black; opacity: 1;'";
				$is_checkedC = "style='background-color : transparent !important;color: black; opacity: 1;'";


				// style="background-color : transparent !important;"
				// style="background-color : red !important;"
				// style="background-color : blue !important;"
				// class="form-check-label custom-bg-color rounded d-inline align-items-center m-2" style="padding: 1px 10px; border-radius: 20px; background-color: red !important;"
				// class="form-check-label custom-bg-color rounded d-inline align-items-center m-2" style="padding: 1px 10px; border-radius: 20px; background-color: blue !important;"
				// class="form-check-label custom-bg-color rounded d-inline align-items-center m-2" style="padding: 1px 10px; border-radius: 20px; background-color: transparent !important;"
	
				if ($user_choices[$j] == $correct_ans[$j]) {
					$total_mark++;
					$diff_arr[$q_difficulty[$j]]++;

					if ($user_choices[$j] == 'a') {
						$is_checkedA = "style='background-color : green !important;color: black; opacity: 1;'";
						$is_cheked_labelA = "class='form-check-label custom-bg-color rounded d-inline align-items-center m-2' style='padding: 1px 10px; border-radius: 20px; background-color: green !important;color: black; opacity: 1;'";
					} else if ($user_choices[$j] == 'b') {
						$is_checkedB = "style='background-color : green !important;color: black; opacity: 1;'";
						$is_cheked_labelB = "class='form-check-label custom-bg-color rounded d-inline align-items-center m-2' style='padding: 1px 10px; border-radius: 20px; background-color: green !important;color: black; opacity: 1;'";
					} else if ($user_choices[$j] == 'c') {
						$is_checkedC = "style='background-color :  green !important;color: black; opacity: 1;'";
						$is_cheked_labelC = "class='form-check-label custom-bg-color rounded d-inline align-items-center m-2' style='padding: 1px 10px; border-radius: 20px; background-color: green !important;color: black; opacity: 1;'";
					}
				} else {
					if ($user_choices[$j] == 'a') {
						$is_checkedA = "style='background-color : red !important;color: black; opacity: 1;'";
						$is_cheked_labelA = "class='form-check-label custom-bg-color rounded d-inline align-items-center m-2' style='padding: 1px 10px; border-radius: 20px; background-color: red !important;color: black; opacity: 1;'";
					} else if ($user_choices[$j] == 'b') {
						$is_checkedB = "style='background-color : red  !important;color: black; opacity: 1;'";
						$is_cheked_labelB = "class='form-check-label custom-bg-color rounded d-inline align-items-center m-2' style='padding: 1px 10px; border-radius: 20px; background-color: red !important;color: black; opacity: 1;'";
					} else if ($user_choices[$j] == 'c') {
						$is_checkedC = "style='background-color : red !important;color: black; opacity: 1;'";
						$is_cheked_labelC = "class='form-check-label custom-bg-color rounded d-inline align-items-center m-2' style='padding: 1px 10px; border-radius: 20px; background-color: red !important;color: black; opacity: 1;'";
					}
				}


				echo <<<QUESTION
							<hr class="border-primary my-4">
							<div class="form row m-2">
							<h6> <strong> Question  {$q}  :</strong> </h6>
							<pre><code class='language-cpp langugae-plaintext'>{$questions_statement[$q_ids_db[$j]]}</code></pre>
							</label>
							<br><br>
							<div class="form-check form-check-inline" id="Q{$q}">
							<input class="form-check-input bg-primary" type="radio" id="inlineCheckbox11" name="Q{$q}"  {$is_checkedA} color: black; opacity: 1; disabled>
							<label {$is_cheked_labelA} for="inlineCheckbox11" ">
							a) {$all_probs_choices[$q_ids_db[$j]][0]}
									</label>
								</div>
								<div class="form-check form-check-inline">
								<input class="form-check-input bg-primary" type="radio" id="inlineCheckbox12" name="Q{$q}" {$is_checkedB} disabled>
								<label {$is_cheked_labelB} for="inlineCheckbox12">
										b) {$all_probs_choices[$q_ids_db[$j]][1]}
										</label>
										</div>
										<div class="form-check form-check-inline">
										<input class="form-check-input bg-primary" type="radio" id="inlineCheckbox13" name="Q{$q}" {$is_checkedC} disabled>
										<label {$is_cheked_labelC} for="inlineCheckbox13">
										c) {$all_probs_choices[$q_ids_db[$j]][2]}
										</label>
										</div>
										<div class="answer-box ml-3 d-inline-flex align-items-center justify-content-center px-2" style="margin-top: 10px; background-color: rgba(0, 128, 0, 0.2); border: 1px solid #6ae38e; border-radius: 10px; width: auto;">
										<span class="font-weight-bold mr-2 text-success">Correct answer:</span>
										<span class="text-success" style="padding: 0 0.5rem;">{$correct_ans[$j]}</span>
							</div>
							</div>
							
				QUESTION;
			}

			echo "<hr class=\"border-primary my-4 \">";
			echo "
			<div class='text-center bg-white text-black rounded py-2 mb-4' style='font-weight: bold; width: 110px; margin: 0 auto; border: 2px solid black;'>
 				 Mark: $total_mark / $q_no 
			</div>
			<div class='text-center rounded py-2 mb-4' >
 				 ( hard: {$diff_arr[3]} , medium: {$diff_arr[2]} , easy: {$diff_arr[1]} )
			</div>
			";
			echo "<div class='mb-3 btn xmark'><i class='fa-solid fa-xmark'></i></div>
					</form>";
			$i++;
		}
	}
	?>



	<div class="footer">
		<footer class="bg-dark text-center text-white">
			<!-- Grid container -->
			<div class="container p-4 pb-0">
				<!-- Section: Social media -->
				<section class="mb-4">
					<!-- Facebook -->
					<a class="btn btn-outline-light btn-floating m-1"
						href="https://www.facebook.com/groups/918934416132082" role="button"><i
							class="fab fa-facebook-f"></i></a>

					<!-- Twitter -->
					<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
							class="fab fa-twitter"></i></a>

					<!-- Google -->
					<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
							class="fab fa-google"></i></a>

					<!-- Instagram -->
					<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
							class="fab fa-instagram"></i></a>

					<!-- Linkedin -->
					<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
							class="fab fa-linkedin-in"></i></a>

					<!-- Github -->
					<a class="btn btn-outline-light btn-floating m-1"
						href="https://github.com/mahmoudSh58/community-website" role="button"><i
							class="fab fa-github"></i></a>
				</section>
				<!-- Section: Social media -->
			</div>
			<!-- Grid container -->

			<!-- Copyright -->
			<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
				© 2023 Copyright: MMO TEAM
			</div>
			<!-- Copyright -->
		</footer>
	</div>

	<div class="up">
		<a href="#">
			<i class="fa-solid fa-arrow-up"></i>
		</a>
	</div>

	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/all.min.js"></script>
	<script src="../js/join_request.js"></script>

	<?php
	if (isset($_SESSION['error']) && $_SESSION['error'] != 0) {
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
	$_SESSION['message'] = '';
	?>

</body>

</html>