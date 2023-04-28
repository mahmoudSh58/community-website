<?php
setcookie('username', '', time() - 3600,'/');
unset($_COOKIE['username']);
header('Location: ../index.php');
?>
