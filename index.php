<?php
session_start();
$privilege = '';
$con = mysqli_connect('localhost', 'root', '', 'community_website_db');
if (isset($_COOKIE['id'])) {

	$id_user = $_COOKIE['id'];
	$select_q = "SELECT `privilege`,`state` FROM `user` WHERE `id_user` ='$id_user'";
	$data = mysqli_query($con, $select_q);
	$results = mysqli_fetch_assoc($data);

	if (empty($results)) {
		$_SESSION['error'] = 1;
		$_SESSION['message'] = "User is deleted.";
		header('location: php_request/logout.php');
		exit;
	}
	if ($results['state'] != 1) {
		$_SESSION['error'] = 1;
		if ($results['state'] == -1)
			$_SESSION['message'] = "User is blocked.";
		else
			$_SESSION['message'] = "User in pending.";
		header('location: php_request/logout.php');
		exit;
	}


	if ($results['state'] != 1) {
		$_SESSION['error'] = 1;
		if ($results['state'] == -1)
			$_SESSION['message'] = "User is blocked.";
		else
			$_SESSION['message'] = "User is pending Approval...";

		header('location: php_request/logout.php');
		exit;
	}

	$privilege = $results['privilege'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/all.min.css" />
	<link rel="stylesheet" href="css/home.css" />
	<script src="js/home_f.js"></script>
	<title>Home page</title>
</head>



<body>

	<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">
				<img src="image/eksu black.svg" width="70" height="50" alt="" />
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
						<a class="nav-link active disabled" aria-current="page" href="#">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link px-lg-3" href="page/event.php">Events</a>
					</li>

					<?php
					if (isset($_COOKIE['id'])) {
						echo '

          <li class="nav-item">
            <a class="nav-link px-lg-3 disabled" style="color: #9E9E9E;" href="#">Forum<sub>(soon)</sub></a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-lg-3" href="page/member.php">Members</a>
          </li>';
					}
					
					?>
					<?php
					if ($privilege == 'admin' || $privilege == 'owner') {
						echo '<li class="nav-item">
                    			<a class="nav-link" aria-current="page" href="page/join_request.php">Join-Request</a>
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
							echo '<li>
                    <form action="php_request/logout.php" style="margin:10%;" method="post" class="d-inline">
                    <button class="btn btn-warning me-lg-3" type="submit">Logout</button>
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

	<div class="landing">
		<div class="text-center">
			<h1>E-KSU Problem Solving Community</h1>
			<p id="typing-text" class="text-light"></p>
		</div>
	</div>

	<div class="goal row">
		<p id="target-element" class="col-12 col-lg-8"><span>GOAL</span></p>
		<img src="image/about.jpg" alt="" class="col-4 d-none d-lg-inline" />
	</div>

	<div class="number row justify-content-center">
		<div class="col-12 py-5 col-md-3 p-md-0 member">
			<p>Members</p>
			<p>
				<?php
				$select_user_q = "SELECT `id_user` FROM `user`";
				$data = mysqli_query($con, $select_user_q);
				$results = mysqli_fetch_all($data);
				echo count($results);
				?>
			</p>
			<i class="fa-solid fa-user"></i>
		</div>
		<div class="col-12 py-5 col-md-3 p-md-0 event">
			<p>Events</p>
			<p>
				<?php
				$select_event_q = "SELECT `id_event` FROM `event`";
				$data = mysqli_query($con, $select_event_q);
				$results = mysqli_fetch_all($data);
				echo count($results);
				?>
			</p>
			<i class="fa-solid fa-calendar-check"></i>
		</div>
	</div>


	<div class="footer">
		<footer class="bg-dark text-center text-white">
			<!-- Grid container -->
			<div class="container p-4 pb-0">
				<!-- Section: Social media -->
				<section class="mb-4">
					<!-- Facebook -->
					<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
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
					<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
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


	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/all.min.js"></script>
	<script src="js/home_l.js"></script>
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