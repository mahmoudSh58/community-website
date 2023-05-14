<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'community_website_db');

$id_user = $_COOKIE['id'];
//echo $id_user;

// Receive event data from the Add_event page
$id_event = htmlspecialchars($_POST['id']);
$atitle = htmlspecialchars(mysqli_real_escape_string($con, $_POST['title']));
$atype = htmlspecialchars($_POST['type']);
$afrom = htmlspecialchars($_POST['from']);
$ato = htmlspecialchars($_POST['to']);
$astart = htmlspecialchars($_POST['start']);
$aend = htmlspecialchars($_POST['end']);
$asummary = htmlspecialchars(mysqli_real_escape_string($con, $_POST['summary']));
$adescription = htmlspecialchars(mysqli_real_escape_string($con, $_POST['description']));
$acontent = htmlspecialchars(mysqli_real_escape_string($con, $_POST['content']));
$aqualifications = htmlspecialchars(mysqli_real_escape_string($con, $_POST['qualifications']));
$aexperience = htmlspecialchars(mysqli_real_escape_string($con, $_POST['experience']));
$anum_lecture = htmlspecialchars($_POST['num_lecture']);


$astart = new DateTime($astart);
$astart = $astart->format('Y-m-d H:i:s');

$aend = new DateTime($aend);
$aend = $aend->format('Y-m-d H:i:s');

// print_r($_FILES);

if ($_FILES['url_img']['error'] != UPLOAD_ERR_NO_FILE) {

  $select_q = "SELECT `img_url` FROM `event`  WHERE id_event = $id_event";
  $data = mysqli_query($con, $select_q);
  $result = mysqli_fetch_assoc($data);


  if (empty($result)) {
    $_SESSION['error'] = 1;
    $_SESSION['message'] = "Wrong event.";
    unset($_SESSION['id_event']);
    header('location: ../page/edit_event.php');
    exit;
  }

  $url = mysqli_real_escape_string($con, $result['img_url']);

  $select_q = "SELECT * FROM `event`  WHERE img_url = '$url'";
  $data = mysqli_query($con, $select_q);
  $url_images = mysqli_fetch_all($data);

  if (file_exists($result['img_url']) && count($url_images)==1) {
    if (unlink($result['img_url'])) {
      echo 'Image deleted successfully.';
    } else {
      echo 'Unable to delete the image.';
    }
  } else {
    echo 'Image not found.';
  }

  // Receive the event image from array FILE and set conditions
  $img_name = $_FILES['url_img']['name'];
  $img_size = $_FILES['url_img']['size'];
  $img_tmp = $_FILES['url_img']['tmp_name']; // temporary track for the image
  // array extensions required for images
  $arr_extension = array("jpg", "png", "gif", "jpeg");

  $expl = explode(".", $img_name);
  $ext_explode = end($expl);
  //echo $ext_explode;

  if (!in_array($ext_explode, $arr_extension)) {
    $_SESSION['error'] = 1;
    $_SESSION['message'] = "Extention error";
    header('location:../page/edit_event.php');
    exit();
  }

  if ($img_size >= 3000000) {
    $_SESSION['error'] = 1;
    $_SESSION['message'] = "Size error";
    header('location:../page/edit_event.php');
    exit();
  }

  $new_img_name = $img_name;
  move_uploaded_file($img_tmp, "../image/events/$new_img_name");


  $t_img_name = mysqli_real_escape_string($con, $new_img_name);
  $t_img_name = "../image/events/$t_img_name";

  // if ($con) echo "conected <br>";
  $sql = "UPDATE `event` SET `event_type`='$atype',`event_name`='$atitle',`from_date`='$afrom',`to_date`='$ato',`start_date`='$astart',`summary`='$asummary',`description`='$adescription',`end_date`='$aend',`num_lecture`='$anum_lecture',`content`='$acontent',`qualification`='$aqualifications',`experience`='$aexperience',`made_by`='$id_user',`edit_by`='$id_user',`img_url`='$t_img_name' WHERE id_event = $id_event";
} else {
  $sql = "UPDATE `event` SET `event_type`='$atype',`event_name`='$atitle',`from_date`='$afrom',`to_date`='$ato',`start_date`='$astart',`summary`='$asummary',`description`='$adescription',`end_date`='$aend',`num_lecture`='$anum_lecture',`content`='$acontent',`qualification`='$aqualifications',`experience`='$aexperience',`made_by`='$id_user',`edit_by`='$id_user' WHERE id_event = $id_event";
}
mysqli_query($con, $sql);

unset($_SESSION['id_event']);
header('location:../page/event.php');