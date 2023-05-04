<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'community_website_db');

if(isset($_GET['id'])){
  $id = htmlspecialchars($_GET['id']);
  $_SESSION['id_event']=$id;
  $select_q = "SELECT * FROM `event` WHERE `id_event` ='$id'";
  $data = mysqli_query($con, $select_q);
  $results = mysqli_fetch_assoc($data);

  $results['error']=0;
  if(empty($results)){
    $results['error']= 1;
  }

  $select_q = "SELECT * FROM `practice` WHERE `id_event` ='$id'";
  $data = mysqli_query($con, $select_q);
  $results_2 = mysqli_fetch_all($data);

  $results['num_pract']=count($results_2);

  if(isset($_COOKIE['id'])){
    $id_user = $_COOKIE['id'];
    $select_q="SELECT * FROM `practice` WHERE `id_event`='$id' AND `id_user`='$id_user'";
    $data = mysqli_query($con, $select_q);
    $results_2 = mysqli_fetch_all($data);
    if(empty($results_2)){
      $results['status']=0;
    }else{
      $results['status']=1;
    }
  }else{
    $results['status']=-1;
  }

  echo json_encode($results);
}
?>