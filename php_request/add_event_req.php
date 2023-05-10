  <?php
  session_start();
  $con = mysqli_connect('localhost', 'root', '', 'community_website_db');

  $id_user = $_COOKIE['id'];
  //echo $id_user;

  // Receive event data from the Add_event page
  $atitle = mysqli_real_escape_string($con ,$_POST['title']);
  $atype = $_POST['type'];
  $afrom = $_POST['from'];
  $ato = $_POST['to'];
  $astart = $_POST['start'];
  $aend = $_POST['end'];
  $asummary = mysqli_real_escape_string($con ,$_POST['summary']);
  $adescription = mysqli_real_escape_string($con ,$_POST['description']);
  $acontent = mysqli_real_escape_string($con ,$_POST['content']);
  $aqualifications = mysqli_real_escape_string($con ,$_POST['qualifications']);
  $aexperience = mysqli_real_escape_string($con ,$_POST['experience']);
  $anum_lecture = $_POST['num_lecture'];

  $astart = new DateTime($astart);
  $astart = $astart->format('Y-m-d H:i:s');

  $aend = new DateTime($aend);
  $aend = $aend->format('Y-m-d H:i:s');

  // print_r($_FILES);

  // Receive the event image from array FILE and set conditions
  $img_name = $_FILES['url_img']['name'];
  $img_size = $_FILES['url_img']['size'];
  $img_tmp  = $_FILES['url_img']['tmp_name']; // temporary track for the image
  // array extensions required for images
  $arr_extension = array("jpg", "png", "gif", "jpeg");

  $expl = explode(".", $img_name);
  $ext_explode = end($expl);
  //echo $ext_explode;

  if (!in_array($ext_explode, $arr_extension)) {
    echo "Extension error";
    exit();
  }

  if ($img_size >= 3000000) {
    echo "Size error";
    exit();
  }
  
  $new_img_name = $img_name;
  move_uploaded_file($img_tmp, "../image/events/$new_img_name");

  $img_name_t = mysqli_real_escape_string($con ,"../image/events/$new_img_name");
  // if ($con) echo "conected <br>";
  $sql = "INSERT INTO 
  `event` 
  ( `event_type`,
    `event_name`,
    `from_date`,
    `to_date`, 
    `start_date`, 
    `summary`,
    `description`,
    `end_date`,
    `num_lecture`,
    `content`,
    `qualification`,
    `experience`,
    `made_by`,
    `img_url`)
    
  VALUES 
  ( 
   '$atype',
   '$atitle', 
   '$afrom', 
   '$ato', 
   '$astart', 
   '$asummary', 
   '$adescription', 
   '$aend', 
   '$anum_lecture', 
   '$acontent', 
   '$aqualifications', 
   '$aexperience', 
   '$id_user', 
   '$img_name_t'
   )";

  echo $sql;
   mysqli_query($con, $sql);
    
   header('location:../page/event.php');
  ?> 
