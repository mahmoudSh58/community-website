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
} else {
    $_SESSION['error'] = 1;
    $_SESSION['message'] = "login first.";
    header('location: ../index.php');
    exit;
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
    <link rel="stylesheet" href="../css/member.css" />

	<script src="../js/icon.js"></script>

    <title>Event</title>
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
                        <a class="nav-link px-lg-3" aria-current="page" href="event.php">Events</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-lg-3 disabled" style="color: #9E9E9E;" href="#">Forum<sub>(soon)</sub></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-lg-3 active disabled" href="#">Members</a>
                    </li>

                    <?php
                    if ($privilege == 'admin' || $privilege == 'owner') {
                        echo '<li class="nav-item">
                    			<a class="nav-link" aria-current="page" href="join_request.php">Join-Request</a>
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

    <div class="title">
        <span>Members</span>
    </div>

    <div class="cont m-3">
        <table class="table align-middle mb-0 bg-white m-0 text-center">
            <thead class="bg-light">
                <tr>
                    <th scope="col" style='width:5%'>#</th>
                    <th scope="col">Name</th>
                    <th scope="col" style='width:20%'>Role</th>
                    <?php if ($privilege == 'admin' || $privilege == 'owner')
                        echo '<th scope="col" style="width:10%">Actions</th>';
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $roles = ['head', 'HR', 'instructor', 'admin', 'member'];
                if ($privilege == 'member') {
                    $i = 1;
                    foreach ($roles as $role) {
                        $select_q = "SELECT `id_user`, `role` ,`privilege`,`first_name` , `second_name` , `last_name` ,`state` FROM `user` WHERE `role` ='$role'";
                        $data = mysqli_query($con, $select_q);
                        $results = mysqli_fetch_all($data, MYSQLI_ASSOC);

                        foreach ($results as $result) {
                            if ($result['state'] == 0 || $result['state'] == -1)
                                continue;

                            if ($result['id_user'] == $_COOKIE['id']) {
                                echo "
                                <tr class='table-info'>
                                    <th scope='row'>$i</th>
                                    <td>" . ucfirst($result['first_name']) . ' ' . ucfirst($result['second_name']) . ' ' . ucfirst($result['last_name']) . "</td>
                                    <td>" . ucfirst($result['role']) . "</td> 
                                </tr>";
                                $i++;
                                continue;
                            }

                            echo "
                                <tr>
                                    <th scope='row'>$i</th>
                                    <td>" . ucfirst($result['first_name']) . ' ' . ucfirst($result['second_name']) . ' ' . ucfirst($result['last_name']) . "</td>
                                    <td>" . ucfirst($result['role']) . "</td> 
                                </tr>";
                            $i++;
                        }
                    }
                } else if ($privilege == 'owner') {
                    $i = 1;
                    $d = 0;
                    $_SESSION['users'] = [];
                    foreach ($roles as $role) {
                        $select_q = "SELECT `id_user`, `role` ,`privilege`,`first_name` , `second_name` , `last_name` ,`state` FROM `user` WHERE `role` ='$role'";
                        $data = mysqli_query($con, $select_q);
                        $results = mysqli_fetch_all($data, MYSQLI_ASSOC);

                        if ($role == 'head') {
                            foreach ($results as $result) {
                                if ($result['id_user'] == $_COOKIE['id']) {
                                    echo "
                                    <tr class='table-info'>
                                        <th scope='row'>$i</th>
                                        <td>" . ucfirst($result['first_name']) . ' ' . ucfirst($result['second_name']) . ' ' . ucfirst($result['last_name']) . "</td>
                                        <td>" . ucfirst($result['role']) . "</td>
                                        <td></td>
                                    </tr>";
                                    $i++;
                                    continue;
                                }

                                echo "
                                <tr>
                                    <th scope='row'>$i</th>
                                    <td>" . ucfirst($result['first_name']) . ' ' . ucfirst($result['second_name']) . ' ' . ucfirst($result['last_name']) . "</td>
                                    <td>" . ucfirst($result['role']) . "</td>
                                    <td></td>
                                </tr>";
                                $i++;
                            }
                            continue;
                        }
                        foreach ($results as $result) {
                            if ($result['state'] == 0)
                                continue;
                            $_SESSION['users'][$d] = $result['id_user'];

                            echo "
                            <tr>
                                <th scope='row'>$i</th>
                                <td>" . ucfirst($result['first_name']) . ' ' . ucfirst($result['second_name']) . ' ' . ucfirst($result['last_name']) . "</td>
                                <td>" . ucfirst($result['role']) . "</td>
                                <td align='center'>
                                <div class='dropdown'>
                                <a class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuLink' data-toggle='dropdown' data-bs-toggle='dropdown' aria-expanded='false'>
                                <i class='fa-solid fa-gear'></i>
                                </a>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
                                ";
                            if ($result['privilege'] == 'admin') {
                                echo "
                                    <form class='dropdown-item p-0 m-0' action='../php_request/action_user.php' method='post'>
                                        <input type='hidden' name='id' value='$d'>
                                        <a type='submit' name='submit' value='unadmin' class='btn btn-link' style = 'text-decoration: none;color: red;'>UnAdmin</a>
                                    </form>
                                    ";
                            } else {
                                if ($result['state'] == -1) {
                                    echo "
                                        <form class=' dropdown-item p-0 m-0' action='../php_request/action_user.php' method='post'>
                                            <input type='hidden' name='id' value='$d'>
                                            <button type='submit' name='submit' value='unblock' class='btn btn-link' style = 'text-decoration: none;color: red;'>UnBlock</button>
                                        </form>
                                        ";
                                } else {
                                    echo "
                                        <form class=' dropdown-item p-0 m-0' action='../php_request/action_user.php' method='post'>
                                            <input type='hidden' name='id' value='$d'>
                                            <button type='submit' name='submit' value='block' class='btn btn-link' style = 'text-decoration: none;color: blue;'>Block</button>
                                        </form>

                                        <form class=' dropdown-item p-0 m-0' action='../php_request/action_user.php' method='post'>
                                            <input type='hidden' name='id' value='$d'>
                                            <button type='submit' name='submit' value='admin' class='btn btn-link' style = 'text-decoration: none;color: blue;'>Admin</button>
                                        </form>
                                        ";
                                }
                            }
                            echo "
                                </div>
                                </div>
                                </td>  
                            </tr>";
                            $i++;
                            $d++;
                        }
                    }
                } else {
                    $i = 1;
                    $d = 0;
                    $_SESSION['users'] = [];

                    foreach ($roles as $role) {
                        $select_q = "SELECT `id_user`, `role` ,`privilege`,`first_name` , `second_name` , `last_name` ,`state` FROM `user` WHERE `role` ='$role'";
                        $data = mysqli_query($con, $select_q);
                        $results = mysqli_fetch_all($data, MYSQLI_ASSOC);


                        if ($role == 'head' || $role == 'HR' || $role == 'instructor' || $role == 'admin') {
                            foreach ($results as $result) {

                                if ($result['id_user'] == $_COOKIE['id']) {
                                    echo "
                                    <tr class='table-info'>
                                        <th scope='row'>$i</th>
                                        <td>" . ucfirst($result['first_name']) . ' ' . ucfirst($result['second_name']) . ' ' . ucfirst($result['last_name']) . "</td>
                                        <td>" . ucfirst($result['role']) . "</td>
                                        <td></td>
                                    </tr>";
                                    $i++;
                                    continue;
                                }

                                echo "
                                <tr>
                                    <th scope='row'>$i</th>
                                    <td>" . ucfirst($result['first_name']) . ' ' . ucfirst($result['second_name']) . ' ' . ucfirst($result['last_name']) . "</td>
                                    <td>" . ucfirst($result['role']) . "</td>
                                    <td></td>
                                </tr>";
                                $i++;
                            }
                            continue;
                        }

                        foreach ($results as $result) {
                            if ($result['state'] == 0)
                                continue;
                            $_SESSION['users'][] = $result['id_user'];

                            echo "
                            <tr>
                                <th scope='row'>$i</th>
                                <td>" . ucfirst($result['first_name']) . ' ' . ucfirst($result['second_name']) . ' ' . ucfirst($result['last_name']) . "</td>
                                <td>" . ucfirst($result['role']) . "</td>
                                <td align='center'>
                                <div class='dropdown'>
                                <a class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuLink' data-toggle='dropdown' data-bs-toggle='dropdown' aria-expanded='false'>
                                <i class='fa-solid fa-gear'></i>
                                </a>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
                                ";
                            if ($result['state'] == -1) {
                                echo "
                                <form class=' dropdown-item p-0 m-0' action='../php_request/action_user.php' method='post'>
                                    <input type='hidden' name='id' value='$d'>
                                    <button type='submit' name='submit' value='unblock' class='btn btn-link' style = 'text-decoration: none;color: red;'>UnBlock</button>
                                </form>
                                        ";
                            } else {
                                echo "
                                <form class=' dropdown-item p-0 m-0' action='../php_request/action_user.php' method='post'>
                                    <input type='hidden' name='id' value='$d'>
                                    <button type='submit' name='submit' value='block' class='btn btn-link' style = 'text-decoration: none;color: blue;'>Block</button>
                                </form>
                                ";
                            }
                            echo "
                                </div>
                                </div>
                                </td>  
                            </tr>";
                            $d++;
                            $i++;
                        }
                    }
                }

                ?>

            </tbody>
        </table>
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

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/all.min.js"></script>
    <script src="../js/member.js"></script>
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