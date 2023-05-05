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

  $privilege = $results['privilege'];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/all.min.css" />
  <link rel="stylesheet" href="../css/home.css" />
  <link rel="stylesheet" href="../css/event.css" />

  <title>Event</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php">
        <img src="../image/eksu black.svg" width="70" height="50" alt="" />
        <span class="icon-text"> EKSU-PSC</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <?php
          if ($privilege == 'admin' || $privilege == 'owner') {
            echo '<li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Control</a>
                  </li>
            ';
          }
          ?>
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-lg-3 active disabled" aria-current="page" href="#">Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-lg-3" href="#">Chat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-lg-3" href="#">Members</a>
          </li>
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

  <div class="title">
    <span>Events</span>
    <div class='forms'>
      <form method="post" style='width:250px; padding:8px' class="input-group">
        <select name="filter" class="form-select">
          <option value="">All Event</option>
          <option value="">Practice Event</option>
          <option value="">Now Event</option>
          <option value="">End Event</option>
        </select>
        <button type="button" class="btn btn-primary">Filter</button>
      </form>

      <form method="post" style='width:250px; padding:8px' class='input-group'>
        <div class="form-outline">
          <input type="search" style="border-radius: 5px 0 0 5px;width: 193px;" placeholder="search"
            class="form-control" />
        </div>
        <button type="button" class="btn btn-primary">
          <i class="fas fa-search"></i>
        </button>
      </form>


      <?php
      if ($privilege == 'admin' || $privilege == 'owner') {
        echo '<a href="add_event.php" class="btn btn-primary" style="width:234px; margin:8px">Add event</a>';
      }
      ?>
    </div>
  </div>
  <div class="cont">
    <?php
    $select_event_q = "SELECT * FROM `event`";
    $data = mysqli_query($con, $select_event_q);
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
        '>NO EVENT YET</p>
        ";
    } else {
      foreach ($results as $result) {
        
        $backgroung_type=null;
        $color_type=null;
    
        if($result['event_type']=='course'){
          $backgroung_type='red';
          $color_type='white';
        }else if($result['event_type']=='conference'){
          $backgroung_type='#FFEB3B';
          $color_type='black';
        }else if($result['event_type']=='contest'){
          $backgroung_type='blue';
          $color_type='white';
        }

        echo "
        <div class='card text-center' style='width: 18rem;'>
          <img src='" . $result['img_url'] . "' class='card-img-top' alt=''>
          <div class='card-body'>
            <div style='
            background-color: $backgroung_type;
            color: $color_type;
            width: 100px;
            padding: 2px;
            border-radius: 9px;
            display: flex;
            justify-content: center;
            font-size: .9rem;
            font-weight: 600;
            margin:auto;
            margin-bottom:5px;
            '>" . ucfirst($result['event_type']) . " </div>
            <h5 class='card-title'>". ucfirst($result['event_name']) . "</h5>
            <p class='card-text'style='display: flex;align-items: center;height: 130px;'>" . $result['summary'] . "</p>
            <button class='btn btn-primary show_e' event='" . $result['id_event'] . "'>Show</button>
          ";

          if ($privilege == 'admin' || $privilege == 'owner') {
          echo "
          <button class='btn btn-primary edit_e' event='" . $result['id_event'] . "'>Edit</button>
          ";
        }

        echo "
          </div>
        </div>
        ";
      }
    }
    ?>
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
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>

          <!-- Google -->
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>

          <!-- Instagram -->
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>

          <!-- Linkedin -->
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
              class="fab fa-linkedin-in"></i></a>

          <!-- Github -->
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
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
  <script src="../js/event.js"></script>
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