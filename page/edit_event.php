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
        header('location: ../php_request/logout.php');
        exit;
    }
    if ($results['state'] != 1) {
        $_SESSION['error'] = 1;
        if ($results['state'] == -1)
            $_SESSION['message'] = "User is blocked.";
        else
            $_SESSION['message'] = "User in pending.";
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
    <link rel="stylesheet" href="../css/add_event.css" />

    <title>Edit Event</title>
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
                    			<a class="nav-link" aria-current="page" href="#">Join-Request</a>
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

    <?php

    if (!isset($_POST['id'])) {
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "Error! Try again.";
        header('location: event.php');
        exit;
    }

    $id_event = $_POST['id'];
    $select_q = "SELECT `id_event`, `event_type`, `event_name`, `from_date`, `to_date`, `start_date` , `summary`, `description`, `end_date`, `num_lecture`, `content`, `qualification`, `experience`  FROM `event` WHERE `id_event` ='$id_event'";
    $data = mysqli_query($con, $select_q);
    $result = mysqli_fetch_assoc($data);

    if (empty($result)) {
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "Wrong event.";
        header('location: event.php');
        exit;
    }

    echo "
    <div class='form'>
        <form class='needs-validation' novalidate method='post' action='../php_request/edit_event_req.php' enctype='multipart/form-data'>
        <div class='form row m-2'>
            <h3 class='h3 text-center mb-4' style='font-family : monospace;'>Edit Event {$id_event}</h3>
        </div>
            <input type='hidden' name='id' value='$id_event'>
            <div class='form row m-2'>
                <div class='col-md-6 mb-2'>
                    <label for='title'>Title <sub style='color:red;'>*</sub> </label>
                    <input value='" . $result['event_name'] . "' type='text' class='form-control r' id='title' placeholder='Title' name='title' required>
                </div>

                <div class='col-md-6 mb-2'>
                    <label for='type'>Event Type <sub style='color:red;'>*</sub></label>
                    <select id='type' class='form-select' name='type' required>
                        <option value='course'" . (($result['event_type'] == 'course') ? 'selected' : '') . ">course</option>
                        <option value='contest'" . (($result['event_type'] == 'contest') ? 'selected' : '') . ">contest</option>
                        <option value='conference'" . (($result['event_type'] == 'conference') ? 'selected' : '') . ">conference</option>
                    </select>
                </div>

            </div>

            <div class='form row m-2'>
                <div class='col-md-4 mb-2 md-form md-outline input-with-post-icon datepicker'>
                    <label for='from'>From <sub style='color:red;'>*</sub></label>
                    <input value='" . $result['from_date'] . "' placeholder='Select date' type='date' id='from' name='from' class='form-control' required>
                </div>

                <div class='col-md-4 mb-2 md-form md-outline input-with-post-icon datepicker'>
                    <label for='to'>To <sub style='color:red;'>*</sub></label>
                    <input value='" . $result['to_date'] . "' placeholder='Select date' type='date' id='to' name='to' class='form-control' required>
                </div>
            </div>

            <div class='form row m-2'>
                <div class='col-md-4 mb-2 md-form md-outline input-with-post-icon datepicker'>
                    <label for='start'>Start <sub style='color:red;'>*</sub> </label>
                    <input value='" . $result['start_date'] . "' placeholder='Select date' type='datetime-local' id='start' name='start' class='form-control'
                        required>
                </div>

                <div class='col-md-4 mb-2 md-form md-outline input-with-post-icon datepicker'>
                    <label for='end'>End <sub style='color:red;'>*</sub> </label>
                    <input value='" . $result['end_date'] . "' placeholder='Select date' type='datetime-local' id='end' name='end' class='form-control'
                        required>
                </div>

            </div>

            <div class='form row m-2'>
                <div class='col-md-12 mb-2'>
                    <label for='summary'>Summary <sub style='color:red;'>without details *</sub> </label>
                    <textarea class='form-control' id='summary' name='summary' rows='2' required>" . $result['summary'] . "</textarea>
                </div>
            </div>

            <div class='form row m-2'>
                <div class='col-md-12 mb-2'>
                    <label for='description'>Description <sub style='color:blue;'>in details</sub> </label>
                    <textarea class='form-control' id='description' name='description' rows='4'>" . $result['description'] . "</textarea>
                </div>
            </div>

            <div class='form row m-2'>
                <div class='col-md-12 mb-2'>
                    <label for='content'>Content</label>
                    <textarea class='form-control' id='content' name='content' rows='4'>" . $result['content'] . "</textarea>
                </div>
            </div>

            <div class='form row m-2'>
                <div class='col-md-12 mb-2'>
                    <label for='qualifications'>Qualifications</label>
                    <textarea class='form-control' id='qualifications' name='qualifications' rows='4'>" . $result['qualification'] . "</textarea>
                </div>
            </div>

            <div class='form row m-2'>
                <div class='col-md-12 mb-2'>
                    <label for='experience'>Experience</label>
                    <textarea class='form-control' id='experience' name='experience' rows='4'>" . $result['experience'] . "</textarea>
                </div>
            </div>

            <div class='form row i-college m-2'>
                <div class='col-md-6 mb-2'>
                    <label class='form-label' for='num_lecture'>Number of lectures</label>
                    <input value='" . $result['num_lecture'] . "' type='number' id='num_lecture' name='num_lecture' min='0' class='form-control' />
                </div>
            </div>

            <div class='form row i-image m-2'>
                <div class='col-md-6 mb-2'>
                    <label for='file' class='form-label'>Upload image <sub style='color:red;'>*</sub></label>
                    <input class='form-control' type='file' id='file' name='url_img'  enctype='multipart/form-data' required>
                </div>
            </div>

            <button class='btn btn-primary m-2' type='submit' style='
                margin-left: 40% !important;
                width: 20%;
            '>Edit Event</button>
        </form>
    </div>
    ";
    ?>


    <div class='footer'>
        <footer class='bg-dark text-center text-white'>
            <!-- Grid container -->
            <div class='container p-4 pb-0'>
                <!-- Section: Social media -->
                <section class='mb-4'>
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
    <script src="../js/add_event.js"></script>
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