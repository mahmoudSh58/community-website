<?php

if (session_status() == PHP_SESSION_NONE)
	session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_SESSION['is_signup_filled']) and $_SESSION['is_signup_filled'] == true and isset($_SESSION['signup_data'][12]) and $_SESSION['signup_data'][12] == 'no skill') {
	//if same page refreshed(GET)  and he filled all data  send him to save to db page
	header("Location: ../php_request/signup_submit_db.php");
	exit;
}


if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'signup_quiz.php') !== false) { //if came from quiz page
	// unset($_SESSION['signup_data']);
	// unset($_SESSION['is_signup_filled']);
	$_SESSION['error'] = 2;
	$_SESSION['message2'] = 'Please Re-fill';
}

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'index.php') !== false) { //if came from index.php
	unset($_SESSION['signup_data']);
	$_SESSION['is_signup_filled'] = false;
}


if (isset($_COOKIE['username'])) {
	$_SESSION['error'] = 1;
	$_SESSION['message'] = "Can't Signup while loged in ";
	header('Location: ../index.php');
	exit;
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
	<link rel="stylesheet" href="../css/signup.css" />

	<title>Signup</title>
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
	<div class="form">
		<form class="needs-validation" novalidate method="post" action="../php_request/signup_data.php">
			<div class="form row m-2">
				<h3 class="h3 text-center mb-4" style="font-family : monospace;">Signup Application</h3>
			</div>
			<div class="form row m-2">
				<div class="col-md-4 mb-2">
					<label for="validationCustom01">First name</label>
					<input type="text" class="form-control r" id="validationCustom01" placeholder="First name" name="first_name" required>
					<div class="valid-feedback">
						Looks good!
					</div>
				</div>
				<div class="col-md-4 mb-2">
					<label for="validationCustom02">Middle name</label>
					<input type="text" class="form-control r" id="validationCustom02" placeholder="Middle name" name="second_name" required>
					<div class="valid-feedback">
						Looks good!
					</div>
				</div>
				<div class="col-md-4 mb-2">
					<label for="validationCustom03">Last name</label>
					<input type="text" class="form-control r" id="validationCustom03" placeholder="Last name" name="last_name" required>
					<div class="valid-feedback">
						Looks good!
					</div>
				</div>
			</div>

			<div class="form row m-2">
				<div class="col-md-6 mb-2">
					<label for="inputEmail1">Email</label>
					<input type="email" class="form-control" id="inputEmail1" placeholder="Email" name="email" required>
					<div class="invalid-feedback">
						Please provide a valid email.
					</div>
					<div class="valid-feedback">
						Looks good!
					</div>
				</div>
				<div class="col-md-6 mb-2">
					<label for="inputPassword1">Password</label>
					<div class="input-group">
						<input type="password" class="form-control" id="inputPassword1" placeholder="Password" name="password" minlength="6" required>
						<div class="input-group-append">
							<button class="btn btn-outline-secondary" type="button" id="togglePassword">
								<i class="fa fa-eye-slash " aria-hidden="true" id="eye_icon"></i>
							</button>
						</div>
					</div>
					<div class="invalid-feedback">
						Minimum 6 characters.
					</div>
				</div>
			</div>
			<div class="form row m-2">
				<div class="col-md-3 mb-2">
					<label for="validationCustom04">Governorate</label>
					<input type="text" class="form-control" id="validationCustom04" placeholder="Governorate" name="governorate" required>
					<div class="invalid-feedback">
						Please provide a valid Governorate.
					</div>
					<div class="valid-feedback">
						Looks good!
					</div>
				</div>
				<div class="col-md-3 mb-2">
					<label for="validationCustom05">City</label>
					<input type="text" class="form-control" id="validationCustom05" placeholder="City" name="city" required>
					<div class="invalid-feedback">
						Please provide a valid City.
					</div>
					<div class="valid-feedback">
						Looks good!
					</div>
				</div>

				<div class="col-md-6 mb-2">
					<label for="gender">Gender</label>
					<select class="form-select" id='gender' name='gender' required>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</div>

			</div>

			<div class="form row i-college m-2">
				<div class="col-md-6 mb-2">
					<label for="college">College</label>
					<select class="form-select" id='college' name='college' required>
						<option value="Faculty of Engineering">Faculty of Engineering</option>
						<option value="Faculty of Computer and Information">Faculty of Computer and Information</option>
						<option value="other">other</option>
					</select>
				</div>
			</div>

			<div class="form row m-2">
				<div class="col-md-6 mb-2">
					<label for="level"> Level (Now)</label>
					<select class="form-select" id='level' name="level" required>
						<option value="0">Prep (Faculty of Engineering)</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
				</div>
				<div class="col-md-6 mb-2">
					<label for="birthday">Year of Birthday</label>
					<select class="form-select" id='birthday' name="birthday" required>
					</select>
				</div>
			</div>

			<div class="form row m-2">
				<div class="col-md-6 mb-2">
					<label for="experience">Experience</label>
					<select class="form-select" id='experience' name="experience" required>
						<option value="No Skill">No Skill</option>
						<option value="beginner">beginner</option>
						<option value="middle">middle</option>
						<option value="expert">expert</option>
					</select>
				</div>
			</div>


			<div class="form-group">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
					<label class="form-check-label" for="invalidCheck">
						Agree to terms and conditions
					</label>
					<div class="invalid-feedback">
						You must agree before submitting.
					</div>
				</div>
			</div>

			<div class="form row m-2" id="signup_btn-group">
				<div class="btn-group  mx-auto  d-flex justify-content-center " style=" width : 350px; " id="bottom_buttons">
					<button class="btn btn-secondary  rounded-pill mx-1 disabled" style=" width : 100px;">
						< Previous</button>
							<button class="btn btn-primary  rounded-pill mx-1" type="submit">Save</button>

							<?php
							if (session_status() == PHP_SESSION_NONE)
								session_start();

							if (isset($_SESSION['is_signup_filled']) && $_SESSION['is_signup_filled'])
								echo '<a class="btn btn-primary  rounded-pill mx-1" style=" width : 100px;" href="./signup_quiz.php">Next ></a>';
							else
								echo '<a class="btn btn-primary  rounded-pill mx-1" style=" width : 100px; display : none;" href="./signup_quiz.php">Next ></a>';
							?>

							<a class="btn btn-primary  rounded-pill mx-1" id="next_btn_signup" style=" width : 100px; display : none;" href="./signup_quiz.php">Next ></a>
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
	<?php if (!(isset($_SESSION['is_signup_filled']) and $_SESSION['is_signup_filled'] == true and isset($_SESSION['signup_data']) and (!isset($_SESSION['error']) or $_SESSION['error'] == 0))) {
		echo "<script src='../js/signup.js'></script>";
	}
	?>
	<script src="../js/toggle_pass_signup.js"></script>

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
	if (isset($_SESSION['error']) && $_SESSION['error'] == 0 && $_SESSION['is_signup_filled'] != false) {
		echo "<div class='alert alert-success' role='alert' style='
			position: sticky;
			bottom: 15px;
			left: 25px;
			margin: -70px;
			width: 30%;
			display: flex;
			justify-content: center;
			'>
			" . "Saved New User info !" . "
			</div>
			<script>
		  setTimeout(function() {
				var div = document.getElementsByClassName('alert')[0];
				document.body.removeChild(div);
		  }, 5000);
		  </script>
		";
	}
	if (isset($_SESSION['error']) && $_SESSION['error'] == 2) {
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
	}

	if (isset($_SESSION['error'])) {
		$_SESSION['error'] = 0;
		$_SESSION['message'] = '';
		$_SESSION['message2'] = '';
	}
	?>
</body>

</html>