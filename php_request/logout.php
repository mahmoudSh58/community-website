<?php
$expire_time = time() - (30 * 24 * 60 * 60);
setcookie('id', '',$expire_time, '/');
setcookie('username', '', $expire_time, '/');
unset($_COOKIE['id']);
unset($_COOKIE['username']);


//reset search and filter only on || login || logout || when user uses them (later move to separate file or func)
if( isset($_SESSION['search_events_res']))
 	unset( $_SESSION['search_events_res']);
if( isset($_SESSION['filter_events_res']))
 	unset( $_SESSION['filter_events_res']);
if (isset($_SESSION['last_search']))
	 unset($_SESSION['last_search']);
if (isset($_SESSION['last_filter']))
	 unset($_SESSION['last_filter']);

header('Location: ../index.php');
exit;
?>
