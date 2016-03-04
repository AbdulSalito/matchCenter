<?php
/*	session_start();
if (isset($_SESSION['MCadminlogin'])) {
	unset($_SESSION['MCadminlogin']);
}
header('Location: index.php');
exit;*/

$expire=time()-60*60*24*30;

setcookie("username", "", $expire);
setcookie("userID", "", $expire);
header("Location: index.php");
exit;

?>