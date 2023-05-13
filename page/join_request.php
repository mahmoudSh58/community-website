<?php
if (session_status() == PHP_SESSION_NONE)
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
        $_SESSION['message'] = "This is page for admin";
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
                            echo '<li>
                    <form action="../php_request/logout.php" style="margin:10%;" method="post" class="d-inline">
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


    <div class="form row m-2">
        <h3 class="h3 text-center mb-4" style="font-family : monospace;">Join Requests</h3>
    </div>

    <?php
    $select_q = "SELECT * FROM `user` WHERE `state` ='0'";
    $data = mysqli_query($con, $select_q);
    $results = mysqli_fetch_all($data, MYSQLI_ASSOC);


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
    }else{

        $_SESSION['users'] = [];

        echo'
        <div class="cont m-3" style="min-height: 75vh;">
        <table class="table align-middle mb-0 bg-white m-0 text-center">
            <tbody>
                <hr class="m-0">
        ';
        $i=0;
        foreach($results as $result){

            $_SESSION['users'][$i] = $result['id_user'];
            
            echo"
            <tr>
                <th scope='row'>" .ucfirst($result['first_name']) . ' ' . ucfirst($result['second_name']) . ' ' . ucfirst($result['last_name'])."</th>
                <td>". ucwords($result['college']) ."</td>
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
        $i=0;
        foreach($results as $result){
            echo"
            <form method='post' action='../php_request/join_event.php' class='overform_card user-$i'>
                <div class='d-flex' style='
                justify-content: space-around;
                flex-wrap: wrap;
                align-items: center;
                '>
                    <button type='submit' style='width:200px' class='btn btn-success mb-2' name='accept' value='$i'>Accept</button>
                    <button type='submit' style='width:200px'  class='btn btn-danger mb-2' name='reject' value='$i'>Reject</button>
                </div>
                <div class='mb-3 btn xmark'><i class='fa-solid fa-xmark'></i></div>
            </form>
            ";
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