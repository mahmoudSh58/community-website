<?php
$expire_time = time() - (30 * 24 * 60 * 60);
setcookie('id', '',$expire_time, '/');
setcookie('username', '', $expire_time, '/');
unset($_COOKIE['id']);
unset($_COOKIE['username']);
header('Location: ../index.php');
exit;
?>
