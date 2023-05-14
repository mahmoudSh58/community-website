<!-- TODO: ADD HORZ seperator line like one in join requests between questions ans space between choices and statement -->
<!-- TODO: ADD timer to quiz then restart with new random probs -->
<!-- TODO: replace footer and header with footer and header function  -->
<!-- TODO: replace all this radio form type with functoins takes question and choices and prints the html form  -->

<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();

if (isset($_COOKIE['username'])) {
	$_SESSION['error'] = 1;
	$_SESSION['message'] = "Can't Signup while loged in ";
	header('Location: ../index.php');
	exit;
} else if (!isset($_SESSION['is_signup_filled']) or !$_SESSION['is_signup_filled'] or !isset($_SESSION['signup_data'])) {
	$_SESSION['error'] = 2;
	$_SESSION['message2'] = "Please complete Application page first";
	unset($_SESSION['signup_data']);
	header('Location: ./signup.php');
	exit;
}

// all good
$application_data = $_SESSION['signup_data'];
if ($application_data[12] == "no skill") { //index 12 == $experience
	//if he has no skill no quiz is needed submit all signup data 
	// and skip save quiz  ans section in signup_submit_db.php -> if 'no skill' 
	header('Location: ../php_request/signup_submit_db.php');
	exit;
}

require_once  '../php_request/quiz_generate.php';
$questions = get_probs_id($application_data[12]); //[ id => statement , ...] size = 4 


$q_keys_db =  array_keys($questions);

//parse all choosen  4 questions choices in 2d array of size [4][4] -> 4 questions each has 4 choicese
$all_probs_choices = [];
$questions_statement = [];
$i = 0;

foreach ($questions as $q) { //each element is a dom object that has one Question
	
	$dom = new DOMDocument();
	@$is_loaded = $dom->loadHTML($q); //suppress warning via '@'
	$dom_p_elems  = $dom->getElementsByTagName('p'); // statment without choices
	$dom_li_elems = $dom->getElementsByTagName('li'); //choices each on is an element
	$dom_code_elems = $dom->getElementsByTagName('code'); //choices each on is an element
	

	$questions_statement[$q_keys_db[$i]] = $dom_p_elems -> item(0) -> nodeValue;
	@$questions_statement[$q_keys_db[$i]] .= "<br>" . $dom_code_elems -> item(0) -> nodeValue;//supress some times question has no codes

 
	foreach ($dom_li_elems as $li_elem) //fill each question with its parsed  choices 
		$all_probs_choices[$q_keys_db[$i]][] = $li_elem->nodeValue;  // 2D array of question ids and choices

	$i++;
}

unset($i);
$_SESSION['choosed_questions_id_ordered'] = $q_keys_db;
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
	<link rel="stylesheet" href="../css/signup.css" />
	<link rel="stylesheet" href="../js/highlight_js/styles/default.min.css">

	<script src="../js/icon.js"></script>

	<title>Signup Quiz</title>
</head>

<body>
	<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="../index.php">
				<img src="../image/eksu black.svg" width="70" height="50" alt="" />
				<span class="icon-text"> EKSU-PSC</span>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="../index.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link px-lg-3" href="event.php">Events</a>
					</li>
					<li class="nav-item mt-2 m-lg-0">
						<button class="btn btn-success ms-lg-3 login">
							Login
						</button>
						<button class="btn btn-warning me-lg-3 signup disabled">
							Signup
						</button>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- //inline wont work for some reason but its better to be default -->
	<div class="form">
		<form method="post" action="../php_request/signup_submit_db.php">
			<div class="form row m-2">
				<h3 class="h3 text-center mb-4" style="font-family : monospace;">Signup Quiz<h3>
			</div>
			<div class="form row m-2">
				<h6> <strong> <br>Question 1:</strong> </h6>
				<?php echo "<pre><code class='language-cpp langugae-plaintext'>{$questions_statement[$q_keys_db[0]]}</code></pre>" ?>
				</label>
				<div class="form-check form-check-inline" id="Q1">
					<input class="form-check-input" type="radio" id="inlineCheckbox11" name="Q1" value="a" required>
					<label class="form-check-label" for="inlineCheckbox11">
						<?php echo $all_probs_choices[$q_keys_db[0]][0]; ?>
					</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" id="inlineCheckbox12" name="Q1" value="b">
					<label class="form-check-label" for="inlineCheckbox12">
						<?php echo $all_probs_choices[$q_keys_db[0]][1]; ?>
					</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" id="inlineCheckbox13" name="Q1" value="c">
					<label class="form-check-label" for="inlineCheckbox13">
						<?php echo $all_probs_choices[$q_keys_db[0]][2]; ?>
					</label>
				</div>
			</div>
			<div class="form row m-2">
				<label for="Q2">
					<h6> <strong> <br>Question 2:</strong> </h6>
					<?php echo "<pre><code class='language-cpp langugae-plaintext'>{$questions_statement[$q_keys_db[1]]}</code></pre>" ?>
				</label>
				<div class="form-check form-check-inline" id="Q2">
					<input class="form-check-input" type="radio" id="inlineCheckbox21" name="Q2" value="a" required>
					<label class="form-check-label" for="inlineCheckbox21">
						<?php echo $all_probs_choices[$q_keys_db[1]][0]; ?>
					</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" id="inlineCheckbox22" name="Q2" value="b">
					<label class="form-check-label" for="inlineCheckbox22">
						<?php echo $all_probs_choices[$q_keys_db[1]][1]; ?>
					</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" id="inlineCheckbox23" name="Q2" value="c">
					<label class="form-check-label" for="inlineCheckbox23">
						<?php echo $all_probs_choices[$q_keys_db[1]][2]; ?>
					</label>
				</div>
			</div>
			<div class="form row m-2">
				<label for="Q3">
					<h6> <strong> <br>Question 3:</strong> </h6>
					<?php echo "<pre><code class='language-cpp langugae-plaintext'>{$questions_statement[$q_keys_db[2]]}</code></pre>" ?>
				</label>
				<div class="form-check form-check-inline" id="Q3">
					<input class="form-check-input" type="radio" id="inlineCheckbox31" name="Q3" value="a" required>
					<label class="form-check-label" for="inlineCheckbox31">
						<?php echo $all_probs_choices[$q_keys_db[2]][0]; ?>
					</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" id="inlineCheckbox32" name="Q3" value="b" required>
					<label class="form-check-label" for="inlineCheckbox32">
						<?php echo $all_probs_choices[$q_keys_db[2]][1]; ?>
					</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" id="inlineCheckbox33" name="Q3" value="c">
					<label class="form-check-label" for="inlineCheckbox33">
						<?php echo $all_probs_choices[$q_keys_db[2]][2]; ?>
					</label>
				</div>
			</div>
			<div class="form row m-2">
				<label for="Q4">
					<h6> <strong> <br>Question 4:</strong> </h6>
					<?php echo "<pre><code class='language-cpp langugae-plaintext'>{$questions_statement[$q_keys_db[3]]}</code></pre>" ?>
				</label>
				<div class="form-radio form-radio-inline" id="Q4">
					<input class="form-check-input" type="radio" id="inlineCheckbox1" name="Q4" value="a" required>
					<label class="form-check-label" for="inlineCheckbox1">
						<?php echo $all_probs_choices[$q_keys_db[3]][0]; ?>
					</label>
				</div>
				<div class="form-radio form-radio-inline">
					<input class="form-check-input" type="radio" id="inlineCheckbox2" name="Q4" value="b">
					<label class="form-check-label" for="inlineCheckbox2">
						<?php echo $all_probs_choices[$q_keys_db[3]][1]; ?>
					</label>
				</div>
				<div class="form-radio form-radio-inline">
					<input class="form-check-input" type="radio" id="inlineCheckbox3" name="Q4" value="c">
					<label class="form-check-label" for="inlineCheckbox3">
						<?php echo $all_probs_choices[$q_keys_db[3]][2]; ?>
					</label>
				</div>
			</div>


			<div class="form row m-2">
				<div class="btn-group  mx-auto  d-flex justify-content-center " style=" width : 350px; " id="bottom_buttons">
					<a class="btn btn-primary  rounded-pill mx-1" style=" width : 100px;" href="./signup.php">
						< Previous </a>
							<button class="btn btn-primary  rounded-pill mx-1" type="submit">Apply</button>
							<button class="btn btn-secondary  rounded-pill mx-1 disabled" style=" width : 100px;">
								Next ></button>
				</div>
			</div>
		</form>
	</div>

	<div class="footer">
		<footer class="bg-dark text-center text-white">
			<!-- Grid container -->
			<div class="container p-4 pb-0">
				<!-- Section: Social media -->
				<section class="mb-4">
					<!-- Facebook -->
					<a class="btn btn-outline-light btn-floating m-1" target="_blank" href="https://www.facebook.com/groups/918934416132082" role="button"><i class="fab fa-facebook-f"></i></a>

					<!-- Twitter -->
					<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>

					<!-- Google -->
					<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>

					<!-- Instagram -->
					<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>

					<!-- Linkedin -->
					<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>

					<!-- Github -->
					<a class="btn btn-outline-light btn-floating m-1" target="_blank" href="https://github.com/mahmoudSh58/community-website/tree/master" role="button"><i class="fab fa-github"></i></a>
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
	<script src="../js/highlight_js/highlight.min.js"></script>
	<script>
		hljs.highlightAll();
	</script>

	<?php
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
	$_SESSION['message']= ''
	?>
</body>

</html>