<?php

session_start();
$con = mysqli_connect('localhost', 'root', '', 'community_website_db');

if(isset($_POST['practice'])){
    $id_event =null;
    if(isset($_SESSION['id_event'])){
        $id_event = $_SESSION['id_event'];
    }
    else{
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "Try Anthor Time.";
        header("location: ../page/event.php");
        exit;
    }

    $id_user =null;
    if(isset($_COOKIE['id'])){
        $id_user = $_COOKIE['id'];
    }
    else{
        $_SESSION['error'] = 1;
        $_SESSION['message'] = "Login first.";
        header("location: ../page/event.php");
        exit;
    }

    if($_POST['practice']=='1'){
        $insert_q= "INSERT INTO `practice`(`id_event`, `id_user`) VALUES ($id_event,'$id_user')";
        mysqli_query($con, $insert_q);
        header("location: ../page/event.php");
        exit;
    }else{
        $insert_q= "DELETE FROM `practice` WHERE `id_event`= $id_event AND `id_user`='$id_user'";
        mysqli_query($con, $insert_q);
        header("location: ../page/event.php");
        exit;
    }
}

?>